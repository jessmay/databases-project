<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create University</title>

<?php include TEMPLATE_MIDDLE;
    $success = false;
    $name_taken = false;

    function tryCreateUniversity ($db, $name, $student_count, $description, $picture_url) {        
        // Check to see if there is a existing university with that name
        $name = strtolower($name);
        $name_used_params = array(':name' => $name);
        $name_used_query = '
            SELECT COUNT(*)
            FROM University U
            WHERE U.Name = :name
        ';
        $result = $db->prepare($name_used_query);
        $result->execute($name_used_params);
        $name_taken = $result->fetchColumn();
        if ($name_taken)
            return false;
        
        $super_admin_id = $_SESSION['user']['User_id'];     // Only Super_Admins can see the University Form
        
        // Insert the university information into the University table
        $create_university_params = array(
            ':super_admin_id' => $super_admin_id,
            ':name' => $name,
            ':student_count' => $student_count,
            ':description' => $description
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
        
        // Find the university_id from the University table
        $find_university_params = array(
            ':name' => $name
        );
        $find_university_query = '
            SELECT University_id
            FROM University U
            WHERE U.Name = :name
        ';
        
        $result = $db->prepare($find_university_query);
        $result->execute($find_university_params);
        $university_id = $result->fetch()['University_id'];
        
        // Find the picture_id from the Picture table
        $find_picture_params = array(
            ':picture_url' => $picture_url
        );
        $find_picture_query = '
            SELECT Picture_id
            FROM Picture P
            WHERE P.Url = :picture_url
        ';
        
        $result = $db->prepare($find_picture_query);
        $result->execute($find_picture_params);
        $picture_id = $result->fetch()['Picture_id'];
        
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
        return true;
    }
    
    // If the user has submitted the form to create a university
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['createUniversity'])) {
            $success = tryCreateUniversity(
                $db,
                $_POST['name'],
                $_POST['student_count'],
                $_POST['description'],
                $_POST['picture_url']
            );
            $name_taken = !$success;
        }
    }
?>

    <?php if (!$success): ?>
    <h2>
        Create University
    </h2>
    <hr>
    <?php
        $name = $name_taken ? htmlentities($_POST['name']) : '';
        $student_count = $name_taken ? htmlentities($_POST['student_count']) : '';
        $description = $name_taken ? htmlentities($_POST['description']) : '';
        $picture_url = $name_taken ? htmlentities($_POST['picture_url']) : '';
    ?>
	<p>
		<form role="form" action="" method="post">
        	<div class="row">
				<div class="col-md-6">
                    <?php if ($name_taken): ?>
					<div class="form-group has-error">
						<label class="control-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ex: University of Central Florida (UCF)" pattern="[A-Za-z ]+" size="50" maxlength="50" required value="<?=$name?>">
                        <span id="invalidName" class="help-block">This university has already been created.</span>
                    </div>
                    <?php else: ?>
					<div class="form-group">
						<label class="control-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ex: University of Central Florida (UCF)" pattern="[A-Za-z ]+" size="50" maxlength="50" required value="<?=$name?>">
                    </div>
                    <?php endif; ?>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="student_count">Number of Students</label>
						<input type="number" class="form-control" id="student_count" name="student_count" placeholder="ex: 60576" min="0" max="10000000" required value="<?=$student_count?>">
					</div>
				</div>
			</div>
			
            <div class="form-group">
				<label for="description">Description</label>
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Add more info" size="160" maxlength="160" required><?=$description?></textarea>
			</div>
            
            <div class="form-group">
				<label for="univLocation">Location</label>
				<input type="text" class="form-control" id="univLocation" placeholder="ex: Orlando, Florida" size="50" maxlength="50" required>
			</div>
            
            <div class="form-group">
				<label for="picture_url">Picture</label>
				<input type="url" class="form-control" id="picture_url" name="picture_url" placeholder="ex: https://ucf.edu/logo.png" size="200" maxlength="200" required value="<?=$picture_url?>">
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

<?php include TEMPLATE_BOTTOM; ?>