<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";

		@$UserName=$_SESSION['UserName'];
		@$TeacherID=$_SESSION['ID'];	
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
	

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="MyStyle.css" type="text/css" rel="stylesheet">
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Data Insertion</title>

</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li> 
		<li><a href="selectclassparallelsubject.php">Parallel Subject Assignment</a></li>			
		<li><a class="active" href="ScheduleGeneration.php">Generate Schedule</a></li>
 		<li><a href="search.php">Search Schedule</a></li>
  		<li><a href="contact.php">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a href="about.php">About</a></li>
		<li>
			<a  href="login.php"><?php if(@$_SESSION['login']==1) {
																	 echo @$_SESSION['UserName'];
																	}else {
																		echo 'Login';	
																	} ?></a></li>
		</ul>
	</ul>
<div style="text-align: center; font-family: Arial;">
	<h1>Schedule Generation</h1>
<table style="width: 100%; height: 514px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">
<tr><td>
<center>
<img src="triangle-spin.gif"><font  color="red"><h2>Warning</h2>
<center>
	You must ensure that all teachers have been<br>
	assigned to their respective subjects and classes and that<br>
	no subjects are missing
</font>
</center>
<br>
<table>
<tr>
	<td>
		<a href="SelectClass.php"><button type="button" style="height:50px; width:100px">Proceed</button></a>
	</td>
</tr>
<tr>
	<td>
		<a href="ScheduleGeneration.php"><button type="button" style="height:50px; width:100px">Cancel</button></a>
	</td>
</tr>
<tr>
	<td>
		<a href="assignement.php"><button type="button" style="height:50px; width:100px">Add Assignment</button></a>
	</td>
</tr>
</tr></td>
</table>
</center>
</table>
</div>
</body></html> 	