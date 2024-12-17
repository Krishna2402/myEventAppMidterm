<?php
session_start();
session_destroy(); // Destroy all sessions
setcookie("user_email", "", time() - 3600, "/"); // Remove the "Remember Me" cookie
header("Location: login.php"); // Redirect to login
exit();
?>
