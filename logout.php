<?php
include 'init.php';

if (isset($_SESSION['user'])) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        0,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
    session_destroy();
}
header('Location: /');
