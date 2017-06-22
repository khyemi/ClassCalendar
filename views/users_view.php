<?php 
	include '../database_HW8F16.php';
	include '../models/users.php';
  include '../views/login view.php';
?>

<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="../users.js"></script>
</head>
<main>
  <div style="padding:20px; margin:40px; border:2px solid Maroon; border-radius:5px; background-color: White;">
    <h2 style="color: Maroon; text-align: center;">List of Users</h2>
 	  <div class="table">
 	  <div id = class = 'errorMessages'><span class = 'error' id="msg"></span></div>
  	<table>
  		<tr>
  			<th>ID</th>
  			<th>Name</th>
			<th>Login</th>
  			<th>New Password</th>
  			<th>Action</th>
  		</tr>
  		<?php

  		$db = new DBQuery(); //User model
		$users = $db->viewAllUsers();//get the users
		if ($users && mysqli_num_rows($users) > 0){
	  		while($row = mysqli_fetch_array($users))
			{?>
				<tr id="row<?php echo $row[0];?>">
					<td><?php echo $row[0]; ?></td>
					<td id="name_val<?php echo $row[0];?>"><?php echo $row[1]; ?></td>
					<td id="login_val<?php echo $row[0];?>"><?php echo $row[2]; ?></td>
					<td id="password_val<?php echo $row[0];?>"><?php echo $row[3]; ?></td>
					<td>
					<input type='button' class="edit_button" id="edit_button<?php echo $row[0];?>" value="edit" onclick="edit_row('<?php echo $row[0];?>');">
	   				<input type='button' style="display: none;" class="save_button" id="save_button<?php echo $row[0];?>" value="update" onclick="save_row('<?php echo $row[0];?>');">
	   				<input type='button' style="display: none;" class="cancel_button" id="cancel_button<?php echo $row[0];?>" value="cancel" onclick="cancel_edit('<?php echo $row[0];?>');">
	   				<input type='button' class="delete_button" id="delete_button<?php echo $row[0];?>" value="delete" onclick="delete_row('<?php echo $row[0];?>');">
					</td>
				</tr>
			<?php	
			}
		} else{
			echo "<tr><td></td><td></td><td></td></tr>";
		}
		?>

  	</table>
  	</div>
  </div> 
  
  <div style="padding:20px; margin:40px; border:2px solid Maroon; border-radius:5px; background-color: White;">
    <h2 style="color: Maroon; text-align: center;">Add New User</h2>
    
    <!-- add user form -->      
      <label>Name: </label>
      <input type="text" id="new_name" name="name" />
      <br>
      
      <label>Login: </label>
      <input type="text" id="new_login" name="login" />
      <br>
      
      <label>Password: </label>
      <input type="password" id="new_password" name="password" />
      <br>
      
      <input type="button" value="Add User" onclick="insert_row();">
      <br>
  </div>
</main>
</body>
</html>


