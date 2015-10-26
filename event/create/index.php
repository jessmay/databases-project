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

<?php include TEMPLATE_MIDDLE;
    $success = false;
    $conflict = false;
    $event_type_submit = 3;
    
    function tryCreateEvent ($db, $name, $category_id, $description, $event_date, $event_time, $event_type, $contact_email, $contact_phone) {
        $admin_id = $_SESSION['user']['User_id'];   // Only Admins can see the Event Form
        
        $approved = 0;
        if ($event_type == 2)
        {
            $approved = 1;
        }
        
        list($month, $day, $year) = explode('/', $event_date);
        list($hour, $dayType) = explode(' ', $event_time);
        $hour = ($hour != 12 && $dayType == "PM") ? $hour + 12 : $hour;
        $date_time = $year . '-' . $month . '-' . $day . ' ' . $hour . ':00:00';
        
        // TODO: Check to see if there is an existing event with the same date, time, and place
    
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
        return true;
    }
    
    // If the user has submitted the form to create an event
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['createEvent'])) {
            $success = tryCreateEvent(
                $db,
                $_POST['name'],
                $_POST['category_id'],
                $_POST['description'],
                $_POST['event_date'],
                $_POST['event_time'],
                $_POST['event_type'],
                $_POST['contact_email'],
                $_POST['contact_phone']
            );
            $conflict = !$success;
            $event_type_submit = $_POST['event_type'];
        }
    }
?>

    <?php if (!$success): ?>
    <h2>
        Create Event
    </h2>
    <hr>
    <?php
        $name = $conflict ? htmlentities($_POST['name']) : '';
        $category_id = $conflict ? htmlentities($_POST['category_id']) : '';
        $description = $conflict ? htmlentities($_POST['description']) : '';
        $event_date = $conflict ? htmlentities($_POST['event_date']) : '';
        $event_time = $conflict ? htmlentities($_POST['event_time']) : '12 PM';
        $event_type = $conflict ? htmlentities($_POST['event_type']) : '3';
        $contact_email = $conflict ? htmlentities($_POST['contact_email']) : '';
        $contact_phone = $conflict ? htmlentities($_POST['contact_phone']) : '';
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
				<div class="col-md-6">
					<div class="form-group">
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
                                    echo '<option value="'.$res['Category_id'].'">';
                                    echo $res['Name'];
                                    echo '</option>'.PHP_EOL;
                                }
                            ?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="description">Description</label>
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Add more info" size="160" maxlength="160" required><?=$description?></textarea>
			</div>
			
			<div class="form-group">
				<label for="eventLocation">Where</label>
				<input type="text" class="form-control" id="eventLocation" placeholder="ex: Room 101 of Engineering Building" size="50" maxlength="50" required>
			</div>
			
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
			
			<div class="row">
				<div class="col-md-1">
					<b>Type</b>
				</div>
				<div class="col-md-2">			
					<input type="radio" name="event_type" id="event_type_3" value="3" <?php if ($event_type == 3) echo 'checked="checked"' ?>> Public
				</div>
				<div class="col-md-2">
					<input type="radio" name="event_type" id="event_type_1" value="1" <?php if ($event_type == 1) echo 'checked="checked"' ?> > Private
				</div>
				<div class="col-md-2">
					<input type="radio" name="event_type" id="event_type_2" value="2" <?php if ($event_type == 2) echo 'checked="checked"' ?> > RSO
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
			</div><br>
			
			<button type="submit" name="createEvent" class="btn btn-primary">Submit</button>
		</form>
	</p>
    <?php else: ?>
    <h2>
        Submitted Form
    </h2>
    <hr>
        <?php if ($event_type_submit == 2): ?>
        <p>
            The event has been created.
        </p>
        <?php else: ?>
        <p>
            The event is pending approval.
        </p>
        <?php endif; ?>
    <p>
        <a href="/event/create">Return to Form</a>
    </p>
    <?php endif; ?>

<?php include TEMPLATE_BOTTOM; ?>