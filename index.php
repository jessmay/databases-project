<?php include 'init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Database Project</title>

<?php 

include TEMPLATE_MIDDLE;

$email_taken = false;
// If the user has submitted the page
if (!$logged_in && $_SERVER['REQUEST_METHOD'] == 'POST') {

    // If the user is creating an account
    if (isset($_POST['createaccount'])) {
        // Check to see if the email is in use
        $email_used_params = array(':email' => $_POST['email']);
        $email_used_query = '
            SELECT COUNT(*) FROM User U
            WHERE U.Email = :email
        ';
        $result = $db->prepare($email_used_query);
        $result->execute($email_used_params);
        $email_taken = $result->fetchColumn();
        if ($email_taken) {
            include 'logged_out.php';
        } else {
            $create_account_params = array(
                ':fname' => $_POST['fname'],
                ':lname' => $_POST['lname'],
                ':email' => $_POST['email'],
                ':pass' => password_hash($_POST['pass'], PASSWORD_DEFAULT)
            );
            $create_account_query = '
                INSERT INTO User (
                    First_name,
                    Last_name,
                    Email,
                    Password_hash
                ) VALUES (
                    :fname,
                    :lname,
                    :email,
                    :pass
                )
            ';
            $result = $db
                ->prepare($create_account_query)
                ->execute($create_account_params);
        }
    } else if (isset($_POST['login'])) {
        $login_query = "
            SELECT User_id, First_name, Password_hash
            FROM User U
            WHERE U.Email = :email
        ";
        $login_params = array(':email' => $_POST['email']);
        $pass = $_POST['pass'];
        $result = $db->prepare($login_query);
        $result->execute($login_params);
        $row = $result->fetch();
        $is_match = password_verify($pass, $row['Password_hash']);
        if ($is_match) {
            $_SESSION['user'] = $row;
            header('Location: index.php');
            include 'logged_in.php';
        } else {
            echo 'Wrong password D:';
        }
    } else {
        include 'logged_out.php';
    }
} else {
    if(!empty($_SESSION['user'])) { 
        include 'logged_in.php';
    } else {
        include 'logged_out.php';
    }
}

include TEMPLATE_BOTTOM; 
