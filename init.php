<?php

// Set up globals
define('ROOT', __DIR__);
define('TEMPLATE_TOP', ROOT.'/template/template_top.php');
define('TEMPLATE_MIDDLE', ROOT.'/template/template_middle.php');
define('TEMPLATE_BOTTOM', ROOT.'/template/template_bottom.php');
define('MUST_BE_ADMIN', ROOT.'/template/require_admin.php');
define('MUST_BE_SUPER_ADMIN', ROOT.'/template/require_super_admin.php');
// TODO: Set up login session code
try {
    $db = new PDO(
        'mysql:host=localhost;dbname=database_project_db',
        'db_user',
        'db_user_password'
    );
} catch (PDOException $e) {
    die("Could not connect to database");
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

session_start();
$logged_in = !empty($_SESSION['user']);
$is_type_regular = $logged_in ? $_SESSION['user']['Type'] == 1 : true;
$is_type_admin = $logged_in ? $_SESSION['user']['Type'] == 2 : false;
$is_type_super_admin = $logged_in ? $_SESSION['user']['Type'] == 3 : false;