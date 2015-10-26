<?php

// Check that the super admin is meant to handle this event
function canManageEvent($db, $event_id) {
    $validation_query = '
        SELECT E.Event_id
        FROM Event E, User U
        WHERE E.Event_id = :event_id
        AND E.Approved = 0
        AND E.Admin_id = U.User_id
        AND U.University_id = :university_id
    ';
    $result = $db->prepare($validation_query);
    $validation_params = array(
        ':event_id' => $event_id,
        ':university_id' => $_SESSION['user']['University_id']
    );
    $result->execute($validation_params);
    return $result->rowCount() > 0;
}