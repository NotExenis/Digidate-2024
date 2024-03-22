<?php
function unsetSessions() {
    unset($_SESSION['users_role']);
    unset($_SESSION['users_id']);
    unset($_SESSION['first_login']);
    unset($_SESSION['user_active']);
}