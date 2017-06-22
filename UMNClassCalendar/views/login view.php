<?php
  session_start();
  if(!isset($_SESSION['login'])){
    header("LOCATION:../login.php");
    die();
  }
  $username = $_SESSION['login'];
?>
<!DOCTYPE html>
<html>
  <!-- the login view section -->
  <head>
    <meta name="viewport" content="initial-scale=1.0 user-scalable=no">
    <meta charset="utf-8">
    <title>Administration Page</title>
    <link rel="stylesheet" type="text/css" href="../style.css" />
  </head>
  
  <body>    
  <div style="padding:20px; margin:40px; border:2px solid Maroon; border-radius:5px; background-color: White;">
    <button onclick="window.location.href='../logout.php'">Log out</button><br>
    <span style="font-size:20px;"><?php echo 'Welcome '.$username. '!'; ?></span><br>
      <button onclick="window.location.href='../calendar.php'">My Calendar</button>
		  <button onclick="window.location.href='../input.php'">Form Input</button>
		  <button onclick="window.location.href='../admin.php'">Administration Page</button><br>
  </div>
 


  