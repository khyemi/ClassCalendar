<!-- logout page -->
<?php
session_start();
unset($_SESSION["login"]);
header("LOCATION: login.php");
?>
