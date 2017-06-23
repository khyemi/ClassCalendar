<!-- login page -->
<?php 
	session_start();
?>

<html lang="en">
  <head>
	<meta name="viewport" content="initial-scale=1.0 user-scalable=no">
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
  	<div style="text-align: center;"><h1>Login Page</h1></div>
<?php
  ini_set('display_errors','1');
  error_reporting(E_ALL);
  include_once('database_HW8F16.php');
	
  /** Form Validation **/
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$valid = true;
		if(isset($_POST['Submit'])){
			$username = $_POST['name'];
			$password = $_POST['password'];

			if(empty($username)){
					  $nameErr = 'Please enter a valid value for name field';
					  $valid = false;  
				}
			if (empty($password)){
					  $passwordErr = 'Please enter a valid value for password field';
				  $valid = false;
				}

			if($valid){
				$userValid = testUserExists($username);
				$passwordValid = testUserPassword($username, $password);
				if($userValid && $passwordValid){
				      $_SESSION['login'] = $username;
				      header('LOCATION:calendar.php');
				}
			}     	
		}
	}
  	// Check userID
	function testUserExists($name){
		global $db_servername, $db_name, $db_password, $db_username, $db_port, $nameErr;
		// Create connection  
		$conn = new mysqli($db_servername,$db_name,$db_password,$db_username,$db_port);
		// Check connection 
		if ( $conn->connect_error ) {
			echo "<h3 style='text-align:center'>Connection Failed: " . mysqli_connect_error() ."</h3>";
		} else {
		    $sql = 'SELECT acc_id, acc_name, acc_login, acc_password FROM tbl_accounts WHERE acc_login = "'.$name.'"';
			$results = mysqli_query($conn,$sql);
			$row = mysqli_num_rows($results);
			if ($row == 0){
				$nameErr = 'Login is incorrect. User does not exist. Please check the login details and try again.';
				$valid = false;
				return $valid;
			}   
		}
		return true;
	}
	// Check password
	function testUserPassword($name, $password){
		global $db_servername, $db_name, $db_password, $db_username, $db_port, $passwordErr;
		$conn = new mysqli($db_servername,$db_name,$db_password,$db_username,$db_port);
		if ( $conn->connect_error ) {
			echo "<h3 style='text-align:center'>Connection Failed password: " . mysqli_connect_error() . "</h3>";
		} else {
		    $sql = 'SELECT acc_id, acc_name, acc_login, acc_password FROM tbl_accounts WHERE acc_login = "'.$name.'"';
		    $result = mysqli_query($conn,$sql);
		    $row = mysqli_fetch_row($result);
		    if ($row[3] != sha1($password)){
		    	$passwordErr = 'Password is incorrect. Please check the password and try again.';
		    	$valid = false;
			return $valid;
		    }
		}
		return true;
	}
 
?>

<?php if(isset($nameErr)){ echo '<div style="text-align: center;"><span class = "error" style="text-align:center";>'.$nameErr.'</span></div><br>';}?>
<?php if(isset($passwordErr)){ echo '<div style="text-align: center;"><span class = "error">'.$passwordErr.'</span></div><br>';}?>
<form action = "login.php" method="POST">
	<p>Please enter your user's login name and password. Both values are case sensitive.</p>
	<p>Login: <input type="text" name="name"></p>
	<p>Password: <input type="password" name="password"></p>
	<br>
<p><input type="submit" name = "Submit" value = "Submit"></p>
</form>
