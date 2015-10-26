<?php
include 'init.php';
include 'manage_event.php';

if (!$is_type_super_admin || !isset($_POST['id'])) {
    die('Invalid request');
}

$id = (int)$_POST['id'];

if (!canManageEvent($db, $id)) {
    die('Invalid request');
}

$approval_query = '
    UPDATE Event E
    SET Approved = 1
    WHERE E.Event_id = :event_id
';
$approval_params = array(':event_id' => $id);
$result = $db->prepare($approval_query);
$result->execute($approval_params);
