<?php
// Restrict access to admin users
if (!$is_type_admin) {
    header('Location: /');
}
?>