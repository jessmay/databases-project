<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create RSO</title>
    <script>
		$(function() {
            $('form').on('click', '.addMember', function() {
                var start = $('#memberList'),
                newMember = $('<div class="form-group"><input type="email" class="form-control" id="rsoMemberEmail" placeholder="Email" size="50" maxlength="50" required></div>');
                $(start).append(newMember);
            });
		});
	</script>

<?php include TEMPLATE_MIDDLE;
    $status = 0;
    define('VALID_SUBMIT', 1);
    define('RSO_TAKEN', 2);
    define('INVALID_ADMIN', 3);
    
    function checkInvalidEmail($db, $email) {
        $email = strtolower($email);
        $email_used_params = array(
            ':email' => $email
        );
        $email_used_query = '
            SELECT COUNT(*)
            FROM User U
            WHERE U.Email = :email
        ';
        
        $result = $db->prepare($email_used_query);
        $result->execute($email_used_params);
        $email_exists = $result->fetchColumn();
        if ($email_exists)
            return false;
            
        return true;
    }
    
    function tryCreateRSO($db, $name, $admin_email) {    
        // Check if the admin email exists
        $INVALID_ADMIN_email = checkInvalidEmail($db, $admin_email);
        if ($INVALID_ADMIN_email)
            return INVALID_ADMIN;
        
        // Find the user_id and the university_id of the admin
        $find_user_id_params = array(
            ':admin_email' => $admin_email
        );
        $find_user_id_query = '
            SELECT User_id, University_id
            FROM User U
            WHERE U.Email = :admin_email
        ';
        
        $result = $db->prepare($find_user_id_query);
        $result->execute($find_user_id_params);
        
        $row = $result->fetch();
        $admin_id = $row['User_id'];
        $university_id = $row['University_id'];
        
        // Check to see if there is an existing RSO with that name in the university
        $name_used_params = array(
            ':name' => $name,
            ':university_id' => $university_id
        );
        $name_used_query = '
            SELECT COUNT(*)
            FROM RSO R, University_RSO UR
            WHERE (UR.University_id = :university_id) AND (UR.RSO_id = R.RSO_id) AND (R.Name = :name)
        ';
        
        $result = $db->prepare($name_used_query);
        $result->execute($name_used_params);
        $name_taken = $result->fetchColumn();
        if ($name_taken)
            return RSO_TAKEN;
        
        // Check users are valid and not the same
        
        // Promote the user type into an admin user-type if applicable (i.e. just a user)
        $find_user_type_params = array(
            ':admin_id' => $admin_id
        );
        $find_user_type_query = '
            SELECT Type
            FROM User U
            WHERE U.User_id = :admin_id
        ';
        
        $result = $db->prepare($find_user_type_query);
        $result->execute($find_user_type_params);
        $user_type = $result->fetch()['Type'];
        
        if ($user_type == 1) {
            $update_user_type_params = array(
                ':admin_id' => $admin_id
            );
            $update_user_type_query = '
                UPDATE User
                SET Type = 2
                WHERE User_id = :admin_id
            ';
            
            $result = $db
                ->prepare($update_user_type_query)
                ->execute($update_user_type_params);
        }
            
        // Insert the RSO information into the RSO table
        $create_rso_params = array(
            ':name' => $name,
            ':admin_id' => $admin_id
        );
        $create_rso_query = '
            INSERT INTO RSO (
                Name,
                Admin_id
            ) VALUES (
                :name,
                :admin_id
            )
        ';
        
        $result = $db
            ->prepare($create_rso_query)
            ->execute($create_rso_params);
        
        // Find the RSO_id from the RSO table
        $rso_id = $db->lastInsertId();
        
        // Insert the relation into the University_RSO table
        $create_rso_relation_params = array(
            ':university_id' => $university_id,
            ':rso_id' => $rso_id
        );
        $create_rso_relation_query = '
            INSERT INTO University_RSO (
                University_id,
                RSO_id
            ) VALUES (
                :university_id,
                :rso_id
            )
        ';
        
        $result = $db
            ->prepare($create_rso_relation_query)
            ->execute($create_rso_relation_params);
        return VALID_SUBMIT;
    }
    
    // If the user has submitted the form to create a RSO
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['createRSO'])) {
            $status = tryCreateRSO(
                $db,
                $_POST['name'],
                $_POST['admin_email']
            );
        }
    }
?>

    <?php if ($status != VALID_SUBMIT): ?>
    <h2>
        Create RSO
    </h2>
    <hr>
    <?php
        $name = ($status == 0) ? '' : htmlentities($_POST['name']);
        $admin_email = ($status == 0) ? '' : htmlentities($_POST['admin_email']);
    ?>
	<p>
		<form role="form" action="" method="post">
            <?php if ($status == RSO_TAKEN) : ?>
            <div class="form-group has-error">
                <label class="control-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="ex: Student Government Association (SGA)" size="50" maxlength="50" required value="<?=$name?>">
                <span id="invalidAdmin" class="help-block">This RSO has already been created.</span>
            </div>
            <?php else: ?>
            <div class="form-group">
                <label class="control-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="ex: Student Government Association (SGA)" size="50" maxlength="50" required value="<?=$name?>">
            </div>
            <?php endif; ?>
			<?php if ($status == INVALID_ADMIN) : ?>
            <div class="form-group has-error">
                <label for="admin_email">Admin Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="ex: rsoAdmin@university.edu" size="50" maxlength="50" required value="<?=$admin_email?>">
                <span id="invalidAdmin" class="help-block">Please enter an existing user email.</span>
            </div>
            <?php else: ?>
            <div class="form-group">
                <label for="admin_email">Admin Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="ex: rsoAdmin@university.edu" size="50" maxlength="50" required value="<?=$admin_email?>">
            </div>
            <?php endif; ?>
            <div id="memberList">
                <label>List of Members</label> <i>(Note: email domains must all match)</i>
                <div class="form-group">
                    <input type="email" class="form-control" id="rsoMemberEmail1" placeholder="Email" size="50" maxlength="50" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="rsoMemberEmail2" placeholder="Email" size="50" maxlength="50" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="rsoMemberEmail3" placeholder="Email" size="50" maxlength="50" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="rsoMemberEmail4" placeholder="Email" size="50" maxlength="50" required>
                </div>
            </div>
            <button type="button" class="addMember btn btn-success btn-sm">Add Member</button><br><br><br>
			
			<button type="submit" name="createRSO" class="btn btn-primary">Submit</button>
	</p>
    <?php else: ?>
    <h2>
        Submitted Form
    </h2>
    <hr>
    <p>
        The RSO has been created.
    </p>
    <p>
        <a href="/rso/create">Return to Form</a>
    </p>
    <?php endif; ?>

<?php include TEMPLATE_BOTTOM; ?>