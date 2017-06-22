<?php
# Users Controller Page
include 'database_HW8F16.php';
include './models/users.php';
/** It takes the POST variables from users_view 
calls on methods in model/users.php, 
where model/users.php gets the major 
database work done **/
if(isset($_POST['edit_row']))
{
	$row=$_POST['row_id'];
	$name=$_POST['name_val'];
	$login=$_POST['login_val'];
	$password=$_POST['password_val'];

	$updated = updateUserInDb($row, $name, $login, $password);
	if($updated == 'true'){
		echo "success";
	}
	else{
		echo "failed";
	}
	exit();
}

if(isset($_POST['delete_row']))
{
	$row_no=$_POST['row_id'];
	deleteUserFromDb($row_no);
	echo "success";
	exit();
}

if(isset($_POST['insert_row']))
{
	$name=$_POST['name_val'];
	$login=$_POST['login_val'];
	$password=$_POST['password_val'];
	if (empty($name) || empty($login) || empty($password)){
		echo "blank";
		exit();
	}
	$added = insertUserIntoDb($name, $login, $password);
	if ($added == 'true'){
		echo "success";
	}
	else{
		echo "failed";
	}
	exit();

}

function deleteUserFromDb($row){
	$db = new DBQuery();
	$db->deleteUser($row);
	$db->disconnect();
}

function updateUserInDb($row, $name, $login, $password){
	$db = new DBQuery();
	$p = sha1($password);
	$updated = $db->updateUser($row, $name, $login, $p);
	$db->disconnect();
	return $updated;
}

function insertUserIntoDb($name, $login, $password){
	$db = new DBQuery();
	$p = sha1($password);
	$added = $db->addUser($name, $login, $p);
	$db->disconnect();
	return $added;

}
?>