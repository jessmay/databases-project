<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create University</title>

<?php include TEMPLATE_MIDDLE;
    $name_taken = false;

    function tryCreateUniversity ($db, $university_name, $student_count, $description) {
        // Check to see if there is a existing university with that name
        $university_name = strtolower($university_name);
        $university_name_used_params = array(':university_name' => $university_name);
        $university_name_used_query = '
            SELECT COUNT(*) FROM University U
            WHERE U.Name = :university_name
        ';
        $result = $db->prepare($university_name_used_query);
        $result->execute($university_name_used_params);
        $name_taken = $result->fetchColumn();
        if ($name_taken)
            return false;
        
        $create_university_params = array(
            ':university_name' => $university_name,
            ':student_count' => $student_count,
            ':description' => $description
        );
        $create_university_query = '
            INSERT INTO University (
                Name,
                Student_count,
                Description
            ) VALUES (
                :university_name,
                :student_count,
                :description
            )
        ';
        
        $result = $db
            ->prepare($create_university_query)
            ->execute($create_university_params);
        return true;
    }
    
    // If the user has submitted the form to create a university
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['createUniversity'])) {
            $success = tryCreateUniversity(
                $db,
                $_POST['university_name'],
                $_POST['student_count'],
                $_POST['description']
            );
            $name_taken = !$success;
            if ($success) {
            } else {
            }
        }
    }
?>
    <h2>
        Create University
    </h2>
    <hr>
    <?php
        $university_name = $name_taken ? htmlentities($_POST['university_name']) : '';
        $student_count = $name_taken ? htmlentities($_POST['student_count']) : '';
        $description = $name_taken ? htmlentities($_POST['description']) : '';
    ?>
	<p>
		<form role="form" action"" method="post">
        	<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="university_name">Name</label>
                        <input type="text" class="form-control" id="university_name" name="university_name" placeholder="ex: University of Central Florida (UCF)" pattern="[A-Za-z]+" size="50" maxlength="50" required value="<?=$university_name?>">
                    </div>
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
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Add more info" size="160" maxlength="160" required value="<?=$description?>"></textarea>
			</div>
            
            <div class="form-group">
				<label for="univLocation">Location</label>
				<input type="text" class="form-control" id="univLocation" placeholder="ex: Orlando, Florida" size="50" maxlength="50" required>
			</div>
            
            <div class="form-group">
				<label for="univPicture">Picture</label>
				<input type="url" class="form-control" id="univPicture" placeholder="ex: https://pbs.twimg.com/profile_images/462235833274073088/2Mo_aqES.png" size="200" maxlength="200" required>
			</div><br>
            
			<button type="submit" name="createUniversity" class="btn btn-primary">Submit</button>
        </form>
	</p>

<?php include TEMPLATE_BOTTOM; ?>