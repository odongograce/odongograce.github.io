<?php 
//logging out the current user by destroying the session and all session data and redirecting them to the login page.
session_start();

session_destroy();

header("Location: ./login.php?status=logged_out");
exit();
?>