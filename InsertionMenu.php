<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);

		@$UserName=$_SESSION['UserName'];
		@$TeacherID=$_SESSION['ID'];
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
  		<li><a class="active" href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li>
		<li><a href="selectclassparallelsubject.php">Parallel Subject Assignment</a></li>	 		
		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
 		<li><a href="search.php">Search Schedule</a></li>
  		<li><a href="contact.php">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a href="about.php">About</a></li>
		<li>
			<a href="login.php"><?php if(@$_SESSION['login']==1) {
																	 echo @$_SESSION['UserName'];
																	}else {
																		echo 'Login';	
																	} ?></a></li>
		</ul>
	</ul>
<div style="text-align: center; font-family: Arial;">
	<h1>Data Insertion</h1>
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width: 100%; height: 100%; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">

				<tr>
					<td style="text-align: center;">
						<div style="color: #603813;">
							<h2>Insert Teacher</h2>
						</div>
						<a href="TeacherInsertion.php"><img style="border: 0px solid ; width: 328px; height: 326px;" alt="" src="AddTeacher.png"></a><br>
				</td>
				<td style="text-align: center;">
					<font color="#603813"><h2 style="color: 3A3A3C;">Insert Class</h2>
					<a href="ClassInsertion.php"><img style="border: 0px solid ; width: 328px; height: 326px;" alt="" src="InsertClass.png"></a></td>
				<td style="text-align: center;">
					<h2 style="color: #603813;">Insert Subject</h2>
					<a href="SubjectInsertion.php"><img style="border: 0px solid ; width: 328px; height: 326px;" alt="" src="AddSubject.png"></a></td>
				</tr>
				<tr>
					<td>
					</td>
					<td style="text-align: center;"><br>
						<a href="home.php"><img style="width: 100px; height: 100px;" alt="" src="back-icon-clipart-1.png"></a>
					</td>
					<td>
					</td>
				</tr>

			</table>
		</td>
	</tr>

</table>
</div>
</body></html> 	