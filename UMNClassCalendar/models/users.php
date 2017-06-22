<?php
//Include database credentials
include '../database_HW8F16.php';

class DBQuery{
	//database credentials
	public $conn;
	private $db_servername = "egon.cs.umn.edu";
	private $db_name = "C4131F16U46";
	private $db_password = "1009";
	private $db_username = "C4131F16U46";
	private $db_port = "3307";

	public function __construct(){
		$this->connect();
	}

	public function connect(){
		$this->conn = new mysqli($this->db_servername,$this->db_name,$this->db_password,$this->db_username,$this->db_port);
		if ( $this->conn->connect_error ) {
			printf("Connection failed");
		} else {
			return true;
		}
	}

	public function disconnect(){
		mysqli_close($this->conn);
	}

	public function viewAllUsers(){
		$sql = "SELECT * FROM tbl_accounts;";
		$query = mysqli_query($this->conn, $sql);
		return $query;
	}

	public function deleteUser($row_no){
		$sql = "DELETE FROM tbl_accounts WHERE acc_id=$row_no;";
		$query = mysqli_query($this->conn, $sql);
	}

	public function updateUser($row_no, $name, $login, $password){
		$sql = "SELECT * FROM tbl_accounts WHERE acc_login = '".$login."';";
		$query = mysqli_query($this->conn, $sql);
		$result = mysqli_num_rows($query);
		if($result == 0){
			$sql = "UPDATE tbl_accounts SET acc_name = '".$name."', acc_login = '".$login."', acc_password = '".$password."' WHERE acc_id = ".$row_no.";";
			$query = mysqli_query($this->conn, $sql);
			return true;
		}
		else{
			return false;
		}		
	}

	public function addUser($name, $login, $password){
		$sql = "SELECT * FROM tbl_accounts WHERE acc_login = '".$login."';";
		$query = mysqli_query($this->conn, $sql);
		$result = mysqli_num_rows($query);
		if($result == 0){
			$sql = "INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES ('".$name."','".$login."','".$password."');";
			mysqli_query($this->conn, $sql);
			return true;
		}
		else{
			return false;
		}
	}

}


?>
