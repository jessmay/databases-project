<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create University</title>

<?php include MAP_FUNCTIONS; ?>
<?php include TEMPLATE_MIDDLE;
    $status = 0;
    define('VALID_SUBMIT', 1);
    define('NAME_TAKEN', 2);
    define('USER_HAS_UNIVERSITY', 3);
    define('INVALID_LOCATION', 4);
    
    define('DEFAULT_UNIVERSITY', 1);
    
    function tryCreateUniversity($db, $name, $student_count, $description, $location, $picture_url) {
        // Check to see if there is a existing university with that name
        $lower_name = strtolower($name);
        $name_used_params = array(
            ':lower_name' => $lower_name
        );
        $name_used_query = '
            SELECT COUNT(*)
            FROM University U
            WHERE LOWER(U.Name) = :lower_name
        ';
        
        $result = $db->prepare($name_used_query);
        $result->execute($name_used_params);
        $univ_name_taken = $result->fetchColumn();
        
        if ($univ_name_taken)
            return NAME_TAKEN;
        
        // Check to see the user is already affiliated with a university
        $super_admin_id = $_SESSION['user']['User_id'];
        $find_user_university_params = array(
            ':super_admin_id' => $super_admin_id
        );
        $find_user_university_query = '
            SELECT University_id
            FROM User U
            WHERE U.User_id = :super_admin_id
        ';
        
        $result = $db->prepare($find_user_university_query);
        $result->execute($find_user_university_params);
        $user_university = $result->fetch()['University_id'];
        
        if ($user_university != DEFAULT_UNIVERSITY) {
            return USER_HAS_UNIVERSITY;
        }
        
        // Insert the university information into the University table
        $create_university_params = array(
            ':super_admin_id' => $super_admin_id,
            ':name' => $name,
            ':student_count' => $student_count,
            ':description' => $description,
        );
        $create_university_query = '
            INSERT INTO University (
                SuperAdmin_id,
                Name,
                Student_count,
                Description
            ) VALUES (
                :super_admin_id,
                :name,
                :student_count,
                :description
            )
        ';
        
        $result = $db
            ->prepare($create_university_query)
            ->execute($create_university_params);
        
        // Find the university_id from the University table
        $university_id = $db->lastInsertId();
        
        // Update the university_id of the user and into a super-admin user-type
        $update_user_university_params = array(
            ':super_admin_id' => $super_admin_id,
            ':university_id' => $university_id
        );
        $update_user_university_query = '
            UPDATE User
            SET University_id = :university_id, Type = 3
            WHERE User_id = :super_admin_id
        ';
        
        $result = $db
            ->prepare($update_user_university_query)
            ->execute($update_user_university_params);
        
        // Retrieve the latitude and longitude of the location
        $location_name = $name . ' ' . $location;
        $search_lookup = lookup($location_name);
        
        if ($search_lookup['latitude'] == 'failed') {
            return INVALID_LOCATION;
        }
        
        // Insert the location into the Location table
        $create_location_params = array(
            ':location' => $location,
            ':latitude' => $search_lookup['latitude'],
            ':longitude' => $search_lookup['longitude']
        );
        $create_location_query = '
            INSERT INTO Location (
                Name,
                Latitude,
                Longitude
            ) VALUES (
                :location,
                :latitude,
                :longitude
            )
        ';
        
        $result = $db
            ->prepare($create_location_query)
            ->execute($create_location_params);
        
        // Find the location_id from the Location table
        $location_id = $db->lastInsertId();
        
        // Insert the relation into the University_Location table
        $create_location_relation_params = array(
            ':university_id' => $university_id,
            ':location_id' => $location_id
        );
        $create_location_relation_query = '
            INSERT INTO University_Location (
                University_id,
                Location_id
            ) VALUES (
                :university_id,
                :location_id
            )
        ';
        
        $result = $db
            ->prepare($create_location_relation_query)
            ->execute($create_location_relation_params);
        
        // If there are no pictures to be added, then the form submitted successfully
        if ($picture_url == '')
            return VALID_SUBMIT;
            
        // Insert the picture url into the Picture table
        $create_picture_params = array(
            ':picture_url' => $picture_url
        );
        $create_picture_query = '
            INSERT INTO Picture (
                Url
            ) VALUES (
                :picture_url
            )
        ';
        
        $result = $db
            ->prepare($create_picture_query)
            ->execute($create_picture_params);
                
        // Find the picture_id from the Picture table
        $picture_id = $db->lastInsertId();
        
        // Insert the relation into the University_Picture table
        $create_picture_relation_params = array(
            ':university_id' => $university_id,
            ':picture_id' => $picture_id
        );
        $create_picture_relation_query = '
            INSERT INTO University_Picture (
                University_id,
                Picture_id
            ) VALUES (
                :university_id,
                :picture_id
            )
        ';
        
        $result = $db
            ->prepare($create_picture_relation_query)
            ->execute($create_picture_relation_params);
        return VALID_SUBMIT;
    }
    
    // If the user has submitted the form to create a university
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['createUniversity'])) {
            $status = tryCreateUniversity(
                $db,
                $_POST['name'],
                $_POST['student_count'],
                $_POST['description'],
                $_POST['location'],
                $_POST['picture_url']
            );
        }
    }
?>

    <?php if ($status != VALID_SUBMIT): ?>
    <h2>
        Create University
    </h2>
    <hr>
    <?php
        $name = ($status == 0) ? '' : htmlentities($_POST['name']);
        $student_count = ($status == 0) ? '' : htmlentities($_POST['student_count']);
        $description = ($status == 0) ? '' : htmlentities($_POST['description']);
        $location = ($status == 0) ? '' : htmlentities($_POST['location']);
        $picture_url = ($status == 0) ? '' : htmlentities($_POST['picture_url']);
    ?>
	<p>
		<form role="form" action="" method="post">
        	<div class="row">
				<div class="col-md-6">
                    <?php if ($status == NAME_TAKEN): ?>
					<div class="form-group has-error">
						<label class="control-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ex: University of Central Florida (UCF)" size="50" maxlength="50" required value="<?=$name?>">
                        <span id="invalid_name" class="help-block">This university has already been created.</span>
                    </div>
                    <?php elseif ($status == USER_HAS_UNIVERSITY): ?>
                    <div class="form-group has-error">
						<label class="control-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ex: University of Central Florida (UCF)" size="50" maxlength="50" required value="<?=$name?>">
                        <span id="invalid_name" class="help-block">You are already affiliated with a university.</span>
                    </div>
                    <?php else: ?>
					<div class="form-group">
						<label class="control-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ex: University of Central Florida (UCF)" size="50" maxlength="50" required value="<?=$name?>">
                    </div>
                    <?php endif; ?>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="student_count">Number of Students</label>
						<input type="number" class="form-control" id="student_count" name="student_count" placeholder="ex: 60576" min="0" max="10000000000" required value="<?=$student_count?>">
					</div>
				</div>
			</div>
			
            <div class="form-group">
				<label for="description">Description</label>
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Add more info" size="2000" maxlength="2000" required><?=$description?></textarea>
			</div>
            
            <?php if ($status == INVALID_LOCATION): ?>
            <div class="form-group has-error">
				<label for="location">Location</label>
				<input type="text" class="form-control" id="location" name="location" placeholder="ex: Orlando, Florida" size="50" maxlength="50" required value="<?=$location?>">
                <span id="invalid_location" class="help-block">The university could not be located. Please enter a valid city and state.</span>
			</div>
            <?php else: ?>
            <div class="form-group">
				<label for="location">Location</label>
				<input type="text" class="form-control" id="location" name="location" placeholder="ex: Orlando, Florida" size="50" maxlength="50" required value="<?=$location?>">
            </div>
            <?php endif; ?>
            
            <div class="form-group">
				<label for="picture_url">Picture</label>
				<input type="url" class="form-control" id="picture_url" name="picture_url" placeholder="ex: https://ucf.edu/logo.png" size="200" maxlength="200" value="<?=$picture_url?>">
			</div><br>
            
			<button type="submit" name="createUniversity" class="btn btn-primary">Submit</button>
        </form>
	</p>
    <?php else: ?>
    <h2>
        Submitted Form
    </h2>
    <hr>
    <p>
        The university has been created.
    </p>
    <p>
		<a href="/university/create">Return to Form</a>
	</p>
    <?php endif; ?>

<?php include TEMPLATE_MAP; ?>
<?php include TEMPLATE_BOTTOM; ?>