<?php include 'init.php'; ?>
<?php include TEMPLATE_TOP; ?>
    <title>Database Project</title>

<?php 

include TEMPLATE_MIDDLE;

$email_taken = false;
$bad_login = false;

function doLogin($db, $email, $pass) {
    $login_query = '
        SELECT U.User_id, U.First_name, U.Password_hash, U.Type
        FROM User U
        WHERE U.Email = :email
    ';
    // Standardize email
    $email = strtolower($email);
    
    $login_params = array(':email' => $email);
    $result = $db->prepare($login_query);
    $result->execute($login_params);
    $row = $result->fetch();
    $is_match = password_verify($pass, $row['Password_hash']);
    if ($is_match) {
        $_SESSION['user'] = $row;
        header('Location: /');
    } else {
        $bad_login = true;
        include 'logged_out.php';
    }
}

function tryCreateAccount($db, $fname, $lname, $email, $pass) {
    // Check to see if the email is in use
    $email = strtolower($email);
    $email_used_params = array(':email' => $email);
    $email_used_query = '
        SELECT COUNT(*) FROM User U
        WHERE U.Email = :email
    ';
    $result = $db->prepare($email_used_query);
    $result->execute($email_used_params);
    $email_taken = $result->fetchColumn();
    if ($email_taken)
        return false;

    $create_account_params = array(
        ':fname' => $fname,
        ':lname' => $lname,
        ':email' => $email,
        ':pass' => password_hash($pass, PASSWORD_DEFAULT)
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
    return true;
}

// If the user has submitted the page
if (!$logged_in && $_SERVER['REQUEST_METHOD'] == 'POST') {

    // If the user is creating an account
    if (isset($_POST['createaccount'])) {
        $success = tryCreateAccount(
            $db,
            $_POST['fname'],
            $_POST['lname'],
            $_POST['email'],
            $_POST['pass']
        );
        $email_taken = !$success;
        if ($success) {
            doLogin($db, $_POST['email'], $_POST['pass']);
        } else {
            include 'logged_out.php';
        }
    } else if (isset($_POST['login'])) {
        // If the user submitted the Log In form
        doLogin($db, $_POST['email'], $_POST['pass']);
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
