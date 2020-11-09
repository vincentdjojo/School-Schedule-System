<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";

		$ClassID=$_SESSION['ClassID'];
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
	


		$InitializeAssembly = "DELETE from periodassignment WHERE SubjectID!='ASS' AND SubjectID!='CPL' AND SubjectID!='MUS' AND SubjectID!='CCA' AND SubjectID!='PHE' AND SubjectID!='FAB'AND MergeInfo!=''";
			$InitializeAssemblyResult = mysql_query($InitializeAssembly);

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="MyStyle.css" type="text/css" rel="stylesheet">
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Schedule Generation</title>

</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li> 		
 		<li><a class="active" href="ScheduleGeneration.php">Generate Schedule</a></li>
  		<li><a href="#contact">Contact</a></li>
	
	<ul style="float: right; list-style-type: none;">
			<li>
				<a href="#about">About</a></li>
			<li>
			<a href="#login">Login</a></li>
		</ul>
	</ul>
<div style="text-align: center; font-family: Arial;">
	<h1>Schedule Generation</h1>
<table style="width: 100%; height: 514px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">
<tr><td>
<center>
<img src="check-mark.png"><font  color="green"><h2>Success</h2>
<center>
	Previous schedule successfully erased.
</font>
</center>
<br>
<table>
<tr>
	<td>
		<a href="ScheduleGeneration.php"><button type="button" style="height:50px; width:100px">Return</button></a>
	</td>
</tr>


</tr>
</tr></td>
</table>
</center>
</table>
</div>
</body></html> 	