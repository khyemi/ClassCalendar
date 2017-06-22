<?php
	session_start();
	if(!isset($_SESSION['login'])){
		header("LOCATION:login.php");
		die();
	}
	$username = $_SESSION['login'];
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Calendar	Input</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
  <?php 
  /** Form Validation **/
 	$eventErr = $sTimeErr = $eTimeErr = $locErr = $dayErr = "";
 	if(filesize("./calendar.txt")){
  	$outerArr = json_decode(file_get_contents('./calendar.txt'), true);
 	}
	else{
		$outerArr = array();
	}  	

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//submit event
		if(isset($_POST['Submit'])){
			$content = $_POST;
			$eventname = $_POST['eventname'];
			$starttime = $_POST['starttime'];
			$endtime = $_POST['endtime'];
			$location = $_POST['location'];
			$day = $_POST['day'];

			if(empty($eventname)||empty($starttime)||empty($endtime)||empty($location)||empty($day)){
				if (empty($eventname)){
					$eventErr = "Please provide a value for the event name.";
				}
				if (empty($starttime)){
					$sTimeErr = "Please select a value for the event's start time.";
				}
				if (empty($endtime)){
					$eTimeErr = "Please select a value for the event's end time.";
				}		
				if (empty($location)){
					$locErr = "Please provide a value for the event location.";
				}
				if (empty($day)){
					$dayErr = "Please select the day of week for the event.";
				}
			}
			else{
				array_push($outerArr, $content);
				writeEventtoTxt(json_encode($outerArr));
				echo "<script>window.location.href='calendar.php'</script>";
			}
		}
		//clear file content
		elseif (isset($_POST['Clear'])) {
			$clearMsg = "All events have been cleared.";
			file_put_contents("calendar.txt", "");
			echo "<script>window.location.href='calendar.php'</script>";
		}
	}
	/** Write to txt file **/
	function writeEventtoTxt($newEvent){
		file_put_contents("calendar.txt", $newEvent);
	}	

  ?>


  <h1>Calendar Input</h1>
  <button onclick="window.location.href='logout.php'">Log out</button><br>
	<span><?php echo 'Welcome '.$username. '!'; ?></span><br>
  <nav>
		<button onclick="window.location.href='calendar.php'">My Calendar</button>
		<button onclick="window.location.href='input.php'">Form Input</button>
    <button onclick="window.location.href='admin.php'">Administration Page</button>
	</nav>
	<br>
	<br>
	<div class = "errorMessages">
		<span class = "error"><?php echo $eventErr;?></span><br>
		<span class = "error"><?php echo $sTimeErr;?></span><br>
		<span class = "error"><?php echo $eTimeErr;?></span><br>
		<span class = "error"><?php echo $locErr;?></span><br>
		<span class = "error"><?php echo $dayErr;?></span><br>
		<span class = "error"><?php echo $clearMsg;?></span><br>    
	</div>

	<form method="POST" action = "input.php">
		<table>
		<tr>
			<td><label>Event Name:</label></td>
			<td><input type="text" name="eventname"></td>
		</tr>
		<tr>
			<td><label>Start Time:</label></td>
			<td><input type="time" name="starttime"></td>
		</tr>
		<tr>
			<td><label> End Time:</label></td>
			<td><input type="time" name="endtime"></td>
		</tr>
		<tr>
			<td><label>Location:</label></td>
			<td><input type="text" name="location"></td>
		</tr>
		<tr>
			<td><label>Day of the week:</label></td>
			<td>
				<select name = "day">
					<option value=""></option>
					<option value="Mon">Mon</option>
					<option value="Tue">Tue</option>
					<option value="Wed">Wed</option>
					<option value="Thur">Thur</option>
					<option value="Fri">Fri</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"> 
				<input type = "submit" name = "Submit" value = "Submit" >
				<input type = "submit" name = "Clear" value = "Clear" >
			</td>
		</tr>
		</table>
		<br>
		<br>
	</form>
  </body>
</html>

  