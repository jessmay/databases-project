<?php include '../../init.php'; ?>
<?php include MUST_BE_ADMIN; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create Event</title>
	<script>
		$(function() {
			$( "#datepicker" ).datepicker();
            $.widget("ui.hourspin", $.ui.spinner, {
                _parse: function(value) {
                    if (typeof value === "string") {
                        var pm = value.split(' ')[1] == "PM";
                        var hour = parseInt(value);
                        if (hour == 12) {
                            return pm * 12;
                        }
                        return hour + (pm ? 12 : 0);
                    } else {
                        return value;
                    }
                },
                _format: function(value) {
                    if (value < 12) {
                        if (value == 0) {
                            return "12 AM";
                        }
                        return value + " AM";
                    } else {
                        if (value == 12) {
                            return "12 PM";
                        }
                        return (value - 12) + " PM";
                    }
                }
            });
            $( "#timespinner" ).hourspin({
                spin: function(event, ui) {
                    if (ui.value > 23) {
                        $(this).hourspin("value", 0);
                        return false;
                    }
                    else if (ui.value < 0) {
                        $(this).hourspin("value", 23);
                        return false;
                    }
                }
            });
		});
	</script>

<?php include MAP_FUNCTIONS; ?>
<?php include TEMPLATE_MIDDLE;
    $status = 0;
    define('VALID_SUBMIT_APPROVED', 1);
    define('VALID_SUBMIT_PENDING_APPROVAL', 2);
    define('INVALID_LOCATION', 3);
    define('CONFLICT', 4);
    define('MISSING_RSO', 5);
    define('UNNEEDED_RSO', 6);
    define('WRONG_RSO', 7);
    
    define('PRIVATE_EVENT', 1);
    define('RSO_EVENT', 2);
    define('PUBLIC_EVENT', 3);
    
    function tryCreateEvent($db, $name, $category_id, $description, $location, $room_number, $address, $event_date, $event_time, $event_type, $contact_email, $contact_phone, $rso_id) {
        $admin_id = $_SESSION['user']['User_id'];   // Only Admins or Super-Admins can see the form
        
        // If the event is an RSO event, then approval from the super-admin isn't needed
        $approved = 0;
        if ($event_type == RSO_EVENT || $_SESSION['user']['Type'] == 3)
        {
            $approved = 1;
        }
        
        // Store the date and time into an appropriate format to insert into the database
        list($month, $day, $year) = explode('/', $event_date);
        list($hour, $dayType) = explode(' ', $event_time);
        $hour = ($hour != 12 && $dayType == "PM") ? $hour + 12 : $hour;
        $date_time = $year . '-' . $month . '-' . $day . ' ' . $hour . ':00:00';
        
        // Retrieve the latitude and longitude of the address
        $search_lookup = lookup($address);
        
        if ($search_lookup['latitude'] == 'failed' ) {
            return INVALID_LOCATION;
        }
        
        // Create the location name to be stored into the Location table and check for conflicts
        if ($room_number != '')
            $location_name = $room_number . ' at ';
        $location_name .= $location . ' at ';
        $location_name .= $address;

        // Check to see if there is an existing event with the same date, time, and place
        $event_conflict_params = array(
            ':date_time' => $date_time,
            ':location_name' => strtolower($location_name)
        );
        $event_conflict_query = '
            SELECT COUNT(*)
            FROM Event E, Event_Location EL, Location L
            WHERE (E.date_time = :date_time) AND (E.Event_id = EL.Event_id) AND (EL.Location_id = L.Location_id) AND (LOWER(L.Name) = :location_name)
        ';
        
        $result = $db->prepare($event_conflict_query);
        $result->execute($event_conflict_params);
        $event_conflict = $result->fetchColumn();
        
        if ($event_conflict)
            return CONFLICT;
        
        // Check the user correctly submitted an RSO to be associated with the event if applicable
        if ($rso_id == 'Not Applicable' && $event_type == RSO_EVENT) {
            return MISSING_RSO;
        }
        if ($rso_id != 'Not Applicable' && $event_type != RSO_EVENT) {
            return UNNEEDED_RSO;
        }
        
        if ($rso_id != 'Not Applicable' && $event_type == RSO_EVENT) {
            $find_rso_params = array(
                ':rso_id' => $rso_id,
                ':admin_id' => $admin_id
            );
            $find_rso_query = '
                SELECT COUNT(*)
                FROM RSO R
                WHERE (R.RSO_id = :rso_id) AND (R.Admin_id = :admin_id)
            ';
            
            $result = $db->prepare($find_rso_query);
            $result->execute($find_rso_params);
            $admin_of_rso = $result->fetchColumn();
            
            if (!$admin_of_rso) {
                return WRONG_RSO;
            }
        }
        
        // Insert the event information into the Event table
        $create_event_params = array(
            ':admin_id' => $admin_id,
            ':name' => $name,
            ':category_id' => $category_id,
            ':description' => $description,
            ':date_time' => $date_time,
            ':event_type' => $event_type,
            ':contact_email' => $contact_email,
            ':contact_phone' => $contact_phone,
            ':approved' => $approved
        );
        $create_event_query = '
            INSERT INTO Event (
                Admin_id,
                Name,
                Category_id,
                Description,
                Date_time,
                Type,
                Contact_email,
                Contact_phone,
                Approved
            ) VALUES (
                :admin_id,
                :name,
                :category_id,
                :description,
                :date_time,
                :event_type,
                :contact_email,
                :contact_phone,
                :approved
            )
        ';
        
        $result = $db
            ->prepare($create_event_query)
            ->execute($create_event_params);
        
        // Find the event_id from the Event table
        $event_id = $db->lastInsertId();
        
        // Update the rso_id from a NULL value if applicable to the Event table
        if ($rso_id != 'Not Applicable') {
            $update_rso_id_params = array(
                ':event_id' => $event_id,
                ':rso_id' => $rso_id
            );
            $update_rso_id_query = '
                UPDATE Event
                SET RSO_id = :rso_id
                WHERE Event_id = :event_id
            ';
            
            $result = $db
                ->prepare($update_rso_id_query)
                ->execute($update_rso_id_params);
        }
        
        // Insert the relation into the University_Event table
        $create_event_relation_params = array(
            ':university_id' => $_SESSION['user']['University_id'],
            'event_id' => $event_id
        );
        $create_event_relation_query = '
            INSERT INTO University_Event (
                University_id,
                Event_id
            ) VALUES (
                :university_id,
                :event_id
            )
        ';
        
        $result = $db
            ->prepare($create_event_relation_query)
            ->execute($create_event_relation_params);
        
        // Insert the location into the Location table
        $create_location_params = array(
            ':location_name' => $location_name,
            ':latitude' => $search_lookup['latitude'],
            ':longitude' => $search_lookup['longitude']
        );
        $create_location_query = '
            INSERT INTO Location (
                Name,
                Latitude,
                Longitude
            ) VALUES (
                :location_name,
                :latitude,
                :longitude
            )
        ';
        
        $result = $db
            ->prepare($create_location_query)
            ->execute($create_location_params);  
        
        // Find the location_id from the Location table
        $location_id = $db->lastInsertId();
        
        // Insert the relation into the Event_Location table
        $create_location_relation_params = array(
            ':event_id' => $event_id,
            ':location_id' => $location_id
        );
        $create_location_relation_query = '
            INSERT INTO Event_Location (
                Event_id,
                Location_id
            ) VALUES (
                :event_id,
                :location_id
            )
        ';
        
        $result = $db
            ->prepare($create_location_relation_query)
            ->execute($create_location_relation_params);
        
        if ($approved) {
            return VALID_SUBMIT_APPROVED;
        }
        return VALID_SUBMIT_PENDING_APPROVAL;
    }
    
    // If the user has submitted the form to create an event
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['createEvent'])) {
            $status = tryCreateEvent(
                $db,
                $_POST['name'],
                $_POST['category_id'],
                $_POST['description'],
                $_POST['location'],
                $_POST['room_number'],
                $_POST['address'],
                $_POST['event_date'],
                $_POST['event_time'],
                $_POST['event_type'],
                $_POST['contact_email'],
                $_POST['contact_phone'],
                $_POST['rso_id']
            );
            $event_type_submit = $_POST['event_type'];
        }
    }
?>

    <?php if ($status != VALID_SUBMIT_APPROVED && $status != VALID_SUBMIT_PENDING_APPROVAL): ?>
    <h2>
        Create Event
    </h2>
    <hr>
    <?php
        $name = ($status == 0) ? '' : htmlentities($_POST['name']);
        $category_id = ($status == 0) ? '' : htmlentities($_POST['category_id']);
        $description = ($status == 0) ? '' : htmlentities($_POST['description']);
        $location = ($status == 0) ? '' : htmlentities($_POST['location']);
        $room_number = ($status == 0) ? '' : htmlentities($_POST['room_number']);
        $address = ($status == 0) ? '' : htmlentities($_POST['address']);
        $event_date = ($status == 0) ? '' : htmlentities($_POST['event_date']);
        $event_time = ($status == 0) ? '12 PM' : htmlentities($_POST['event_time']);
        $event_type = ($status == 0) ? '3' : htmlentities($_POST['event_type']);
        $contact_email = ($status == 0) ? '' : htmlentities($_POST['contact_email']);
        $contact_phone = ($status == 0) ? '' : htmlentities($_POST['contact_phone']);
        $rso_id = ($status == 0) ? '' : htmlentities($_POST['rso_id']);
    ?>
	<p>
		<form role="form" action="" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="ex: Career Expo" size="50" maxlength="50" required value="<?=$name?>">
					</div>
				</div>
				<div class="col-md-6 form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category_id">
                        <?php
                            $get_category_query = '
                                SELECT C.Category_id, C.Name
                                FROM Category C
                            ';
                            $result = $db->prepare($get_category_query);
                            $result->execute();
                            while ($res = $result->fetch()) {
                                echo '<option value="'.$res['Category_id'].'"';
                                if ($category_id == $res['Category_id']) {
                                    echo ' selected';
                                }
                                echo '>';
                                echo $res['Name'];
                                echo '</option>'.PHP_EOL;
                            }
                        ?>
                    </select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="description">Description</label>
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Add more info" size="2000" maxlength="2000" required><?=$description?></textarea>
			</div>
			
            <?php if ($status == CONFLICT): ?>
            <label class="text-danger">Location Details</label><br>
            <span id="conflict" class="text-danger">There is already an event at this time, date, and place. Please change either your event location or time or date.</span>
            <div class="row">
                <div class="col-md-5 form-group has-error">
                    <label for="location" class="text-danger" style="font-size:small">Where</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="ex: Student Union" size="50" maxlength="30" required value="<?=$location?>">
                </div>
                <div class="col-md-5 form-group has-error">
                    <label for="room_number" class="text-danger" style="font-size:small">Meeting Place</label> <i>(optional)</i>
                    <input type="text" class="form-control" id="room_number" name="room_number" placeholder="ex: Domino's Pizza or 203" size="50" maxlength="30" value="<?=$room_number?>">
                </div>
            </div>
            <div class="form-group has-error">
                <label for="address" style="font-size:small" class="text-danger">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="ex: 12715 Pegasus Dr, Orlando, FL 32816" size="100" maxlength="100" required value="<?=$address?>">
            </div>
            <?php else: ?>
            <label>Location Details</label>
            <div class="row">
                <div class="col-md-5 form-group">
                    <label for="location" style="font-size:small">Where</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="ex: Student Union" size="50" maxlength="30" required value="<?=$location?>">
                </div>
                <div class="col-md-5 form-group">
                    <label for="room_number" style="font-size:small">Meeting Place</label> <i>(optional)</i>
                    <input type="text" class="form-control" id="room_number" name="room_number" placeholder="ex: Domino's Pizza or 203" size="50" maxlength="30" value="<?=$room_number?>">
                </div>
            </div>
            <?php if ($status == INVALID_LOCATION): ?>
            <div class="form-group has-error">
                <label for="address" style="font-size:small">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="ex: 12715 Pegasus Dr, Orlando, FL 32816" size="100" maxlength="100" required value="<?=$address?>">
                <span id="invalid_location" class="help-block">This address could not be located. Please enter a valid address.</span>
            </div>
            <?php else: ?>
            <div class="form-group">
                <label for="address" style="font-size:small">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="ex: 12715 Pegasus Dr, Orlando, FL 32816" size="100" maxlength="100" required value="<?=$address?>">
            </div>
            <?php endif; ?>
            <?php endif; ?>
			
            <?php if ($status == CONFLICT): ?>
			<div class="row">
				<div class="col-md-4 form-group has-error">
					<label for="event_date" class="text-danger">Date</label>
					<input type="text" class="form-control" id="datepicker" name="event_date" pattern="[0-1][0-9]/[0-3][0-9]/20[0-9][0-9]" required value="<?=$event_date?>">
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-4 form-group has-error">
					<label for="event_time" class="text-danger">Time</label>
					<input type="text" id="timespinner" name="event_time" pattern="(1|2|3|4|5|6|7|8|9|10|11|12) (PM|AM)" required value="<?=$event_time?>">
				</div>
			</div>
            <?php else: ?>
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="event_date">Date</label>
					<input type="text" class="form-control" id="datepicker" name="event_date" pattern="[0-1][0-9]/[0-3][0-9]/20[0-9][0-9]" required value="<?=$event_date?>">
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-4 form-group">
					<label for="event_time">Time</label>
					<input type="text" id="timespinner" name="event_time" pattern="(1|2|3|4|5|6|7|8|9|10|11|12) (PM|AM)" required value="<?=$event_time?>">
				</div>
			</div>
            <?php endif; ?>
			
			<div class="row">
				<div class="col-md-1">
					<b>Type</b>
				</div>
				<div class="col-md-2">			
					<input type="radio" name="event_type" id="event_type_3" value="3" <?php if ($event_type == PUBLIC_EVENT) echo 'checked="checked"' ?>> Public
				</div>
				<div class="col-md-2">
					<input type="radio" name="event_type" id="event_type_1" value="1" <?php if ($event_type == PRIVATE_EVENT) echo 'checked="checked"' ?> > Private
				</div>
				<div class="col-md-2">
					<input type="radio" name="event_type" id="event_type_2" value="2" <?php if ($event_type == RSO_EVENT) echo 'checked="checked"' ?> > RSO
				</div>
			</div><br>
						
			<div class="row">
				<div class="col-md-4 form-group">
					<label for="contact_email">Contact Email</label>
					<input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="ex: rso@university.edu" size="50" maxlength="50" required value="<?=$contact_email?>">
				</div>
				<div class="col-md-4 form-group">
					<label for="contact_phone">Contact Phone</label>
					<input type="tel" class="form-control" id="contact_phone" name="contact_phone" placeholder="ex: 1234567890" pattern="[0-9]{10,11}" size="11" maxlength="11" required value="<?=$contact_phone?>">
				</div>
                <?php if ($status == MISSING_RSO): ?>
                <div class="col-md-4 form-group has-error">
                    <label for="category">RSO</label>
                    <select class="form-control" name="rso_id">
                        <?php
                            $get_rso_params = array(
                                ':admin_id' => $_SESSION['user']['User_id']
                            );
                            $get_rso_query = '
                                SELECT R.RSO_id, R.Name
                                FROM RSO R
                                WHERE R.Admin_id = :admin_id
                            ';
                            $result = $db->prepare($get_rso_query);
                            $result->execute($get_rso_params);
                            echo '<option>Not Applicable</option>';
                            while ($res = $result->fetch()) {
                                echo '<option value="'.$res['RSO_id'].'"';
                                if ($rso_id == $res['RSO_id']) {
                                    echo ' selected';
                                }
                                echo '>';
                                echo $res['Name'];
                                echo '</option>'.PHP_EOL;
                            }
                        ?>
                    </select>
                    <span id="missing_rso" class="help-block">Please select an RSO associated with this RSO event.</span>
                </div>
                <?php elseif ($status == UNNEEDED_RSO): ?>
                <div class="col-md-4 form-group has-error">
                    <label for="category">RSO</label>
                    <select class="form-control" name="rso_id">
                        <?php
                            $get_rso_params = array(
                                ':admin_id' => $_SESSION['user']['User_id']
                            );
                            $get_rso_query = '
                                SELECT R.RSO_id, R.Name
                                FROM RSO R
                                WHERE R.Admin_id = :admin_id
                            ';
                            $result = $db->prepare($get_rso_query);
                            $result->execute($get_rso_params);
                            echo '<option>Not Applicable</option>';
                            while ($res = $result->fetch()) {
                                echo '<option value="'.$res['RSO_id'].'"';
                                if ($rso_id == $res['RSO_id']) {
                                    echo ' selected';
                                }
                                echo '>';
                                echo $res['Name'];
                                echo '</option>'.PHP_EOL;
                            }
                        ?>
                    </select>
                    <span id="unneeded_rso" class="help-block">Please select "Not Applicable" for Public and Private events.</span>
                </div>
                <?php elseif ($status == WRONG_RSO): ?>
                <div class="col-md-4 form-group has-error">
                    <label for="category">RSO</label>
                    <select class="form-control" name="rso_id">
                        <?php
                            $get_rso_params = array(
                                ':admin_id' => $_SESSION['user']['User_id']
                            );
                            $get_rso_query = '
                                SELECT R.RSO_id, R.Name
                                FROM RSO R
                                WHERE R.Admin_id = :admin_id
                            ';
                            $result = $db->prepare($get_rso_query);
                            $result->execute($get_rso_params);
                            echo '<option>Not Applicable</option>';
                            while ($res = $result->fetch()) {
                                echo '<option value="'.$res['RSO_id'].'"';
                                if ($rso_id == $res['RSO_id']) {
                                    echo ' selected';
                                }
                                echo '>';
                                echo $res['Name'];
                                echo '</option>'.PHP_EOL;
                            }
                        ?>
                    </select>
                    <span id="wrong_rso" class="help-block">Please select an RSO you are an admin of for the RSO event.</span>
                </div>
                <?php else: ?>
                <div class="col-md-4 form-group">
                    <label for="category">RSO</label>
                    <select class="form-control" name="rso_id">
                        <?php
                            $get_rso_params = array(
                                ':admin_id' => $_SESSION['user']['User_id']
                            );
                            $get_rso_query = '
                                SELECT R.RSO_id, R.Name
                                FROM RSO R
                                WHERE R.Admin_id = :admin_id
                            ';
                            $result = $db->prepare($get_rso_query);
                            $result->execute($get_rso_params);
                            echo '<option>Not Applicable</option>';
                            while ($res = $result->fetch()) {
                                echo '<option value="'.$res['RSO_id'].'"';
                                if ($rso_id == $res['RSO_id']) {
                                    echo ' selected';
                                }
                                echo '>';
                                echo $res['Name'];
                                echo '</option>'.PHP_EOL;
                            }
                        ?>
                    </select>
                </div>
                <?php endif; ?>
			</div><br>
			
			<button type="submit" name="createEvent" class="btn btn-primary">Submit</button>
		</form>
	</p>
    <?php elseif ($status == VALID_SUBMIT_APPROVED): ?>
    <h2>
        Submitted Form
    </h2>
    <hr>
        <p>
            The event has been created.
        </p>
    <p>
        <a href="/event/create">Return to Form</a>
    </p>
    <?php else: ?>
    <h2>
        Submitted Form
    </h2>
    <hr>
        <p>
            The event is pending approval.
        </p>
    <p>
        <a href="/event/create">Return to Form</a>
    </p>
    <?php endif; ?>

<?php include TEMPLATE_MAP; ?>
<?php include TEMPLATE_BOTTOM; ?>