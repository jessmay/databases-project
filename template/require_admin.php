<?php
// Restrict access to admin users and above
if (!$is_type_admin && !$is_type_super_admin) {
    header('Location: /');
}
