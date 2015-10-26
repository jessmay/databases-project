<?php
// Restrict access to super admin users
if (!$is_type_super_admin) {
    header('Location: /');
}
?>