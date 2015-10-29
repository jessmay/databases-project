<?php include '../../init.php'; ?>
<?php include TEMPLATE_TOP; ?>
	<title>Create RSO</title>
    <script>
		$(function() {
            $('form').on('click', '.addMember', function() {
                var start = $('#member_list'),
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
    define('ADMIN_MISSING_UNIVERSITY', 4);
    define('NOT_ALL_UNIQUE', 5);
    define('NOT_ALL_VALID', 6);
    define('NOT_ALL_SAME_UNIVERSITY', 7);
    define('NOT_ALL_SAME_DOMAIN', 8);
    
    define('DEFAULT_UNIVERSITY', 1);
    
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
    
    function tryCreateRSO($db, $name, $admin_email, $member_emails) {    
        // Check if the admin email exists
        $invalid_admin_email = checkInvalidEmail($db, $admin_email);
        if ($invalid_admin_email)
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
        
        // Check to see ensure the admin is enrolled in a university
        if ($university_id == DEFAULT_UNIVERSITY) {
            return ADMIN_MISSING_UNIVERSITY;
        }
        
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
        
        // Add the extra members into the list of emails
        
        // Check to ensure all emails are unique and not the same as the admin_email
        $total_members = count($member_emails) + 1;
        $member_emails_temp = $member_emails;
        array_push($member_emails_temp, $admin_email);
        $member_emails_temp = array_unique($member_emails_temp);
        if (count($member_emails_temp) != $total_members)
            return NOT_ALL_UNIQUE;
        
        // Check that each member is a valid, existing user enrolled in the same university
        $member_user_ids = array($admin_id);
        foreach ($member_emails as $member_email) {
            $find_user_params = array(
                ':member_email' => $member_email
            );
            $find_user_query = '
                SELECT User_id, University_id
                FROM User U
                WHERE U.Email = :member_email
            ';
            
            $result = $db->prepare($find_user_query);
            $result->execute($find_user_params);
            
            $row = $result->fetch();
            $user_id = $row['User_id'];
            $member_university_id = $row['University_id'];
            
            if ($user_id == '') {
                return NOT_ALL_VALID;
            }
            
            if ($member_university_id == '' || $member_university_id != $university_id) {
                return NOT_ALL_SAME_UNIVERSITY;
            }
            
            array_push($member_user_ids, $user_id);
        }
        
        // Check that all members have the same email domain as the admin
        list($admin_username, $admin_email_domain) = explode('@', $admin_email);
        foreach ($member_emails as $member_email) {
            list($member_username, $member_email_domain) = explode('@', $member_email);
            if ($member_email_domain != $admin_email_domain) {
                return NOT_ALL_SAME_DOMAIN;
            }
        }
        
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
        
        // Insert the relations into the RSO_User table
        foreach ($member_user_ids as $member_user_id) {
            $create_user_relation_params = array(
                ':rso_id' => $rso_id,
                ':member_user_id' => $member_user_id
            );
            $create_user_relation_query = '
                INSERT INTO RSO_User (
                    RSO_id,
                    User_id
                ) VALUES (
                    :rso_id,
                    :member_user_id
                )
            ';
            
            $result = $db
                ->prepare($create_user_relation_query)
                ->execute($create_user_relation_params);
        }
        
        return VALID_SUBMIT;
    }
    
    // If the user has submitted the form to create a RSO
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $member_emails = array(
            $_POST['member_email_1'],
            $_POST['member_email_2'],
            $_POST['member_email_3'],
            $_POST['member_email_4']
        ); 
        
        if (isset($_POST['createRSO'])) {
            $status = tryCreateRSO(
                $db,
                $_POST['name'],
                $_POST['admin_email'],
                $member_emails
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
        $member_email_1 = ($status == 0) ? '' : htmlentities($_POST['member_email_1']);
        $member_email_2 = ($status == 0) ? '' : htmlentities($_POST['member_email_2']);
        $member_email_3 = ($status == 0) ? '' : htmlentities($_POST['member_email_3']);
        $member_email_4 = ($status == 0) ? '' : htmlentities($_POST['member_email_4']);
    ?>
	<p>
		<form role="form" action="" method="post">
            <?php if ($status == RSO_TAKEN): ?>
            <div class="form-group has-error">
                <label class="control-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="ex: Student Government Association (SGA)" size="50" maxlength="50" required value="<?=$name?>">
                <span id="rso_taken" class="help-block">This RSO has already been created.</span>
            </div>
            <?php else: ?>
            <div class="form-group">
                <label class="control-label" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="ex: Student Government Association (SGA)" size="50" maxlength="50" required value="<?=$name?>">
            </div>
            <?php endif; ?>
			
            <?php if ($status == INVALID_ADMIN): ?>
            <div class="form-group has-error">
                <label for="admin_email">Admin Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="ex: rsoAdmin@university.edu" size="50" maxlength="50" required value="<?=$admin_email?>">
                <span id="invalid_admin" class="help-block">Please enter an existing user email.</span>
            </div>
            <?php elseif ($status == ADMIN_MISSING_UNIVERSITY): ?>
            <div class="form-group has-error">
                <label for="admin_email">Admin Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="ex: rsoAdmin@university.edu" size="50" maxlength="50" required value="<?=$admin_email?>">
                <span id="invalid_admin" class="help-block">Please join or create an existing university.</span>
            </div>
            <?php else: ?>
            <div class="form-group">
                <label for="admin_email">Admin Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="ex: rsoAdmin@university.edu" size="50" maxlength="50" required value="<?=$admin_email?>">
            </div>
            <?php endif; ?>
            
            <?php if ($status == NOT_ALL_UNIQUE): ?>
            <div class="has-error" id="member_list">
                <label class="text-danger">List of Members</label>
                <span id="not_all_unique" class="help-block">Please enter unique user email addresses.</span>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_1" name="member_email_1" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_1?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_2" name="member_email_2" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_2?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_3" name="member_email_3" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_3?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_4" name="member_email_4" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_4?>">
                </div>
            </div>
            <button type="button" class="addMember btn btn-success btn-sm">Add Member</button><br><br><br>
            <?php elseif ($status == NOT_ALL_VALID): ?>
            <div class="has-error" id="member_list">
                <label class="text-danger">List of Members</label>
                <span id="not_all_unique" class="help-block">Please ensure all emails belong to valid users.</span>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_1" name="member_email_1" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_1?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_2" name="member_email_2" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_2?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_3" name="member_email_3" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_3?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_4" name="member_email_4" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_4?>">
                </div>
            </div>
            <button type="button" class="addMember btn btn-success btn-sm">Add Member</button><br><br><br>
            <?php elseif ($status == NOT_ALL_SAME_UNIVERSITY): ?>
            <div class="has-error" id="member_list">
                <label class="text-danger">List of Members</label>
                <span id="not_all_unique" class="help-block">Please ensure all users belong to the same university as the entered Admin.</span>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_1" name="member_email_1" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_1?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_2" name="member_email_2" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_2?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_3" name="member_email_3" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_3?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_4" name="member_email_4" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_4?>">
                </div>
            </div>
            <button type="button" class="addMember btn btn-success btn-sm">Add Member</button><br><br><br>
            <?php elseif ($status == NOT_ALL_SAME_DOMAIN): ?>
            <div class="has-error" id="member_list">
                <label class="text-danger">List of Members</label>
                <span id="not_all_unique" class="help-block">Please ensure all emails share the same domain as the entered Admin email.</span>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_1" name="member_email_1" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_1?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_2" name="member_email_2" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_2?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_3" name="member_email_3" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_3?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_4" name="member_email_4" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_4?>">
                </div>
            </div>
            <button type="button" class="addMember btn btn-success btn-sm">Add Member</button><br><br><br>
			<?php else: ?>
            <div id="member_list">
                <label>List of Members</label>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_1" name="member_email_1" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_1?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_2" name="member_email_2" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_2?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_3" name="member_email_3" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_3?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="member_email_4" name="member_email_4" placeholder="Email" size="50" maxlength="50" required value="<?=$member_email_4?>">
                </div>
            </div>
            <button type="button" class="addMember btn btn-success btn-sm">Add Member</button><br><br><br>
            <?php endif; ?>
            
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