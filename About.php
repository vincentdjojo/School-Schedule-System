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
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Contact</title>

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
		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
 		<li><a href="search.php">Search Schedule</a></li>
  		<li><a   href="contact.php">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a class='active' href="about.php">About</a></li>
		<li>
			<a  href="login.php"><?php if(@$_SESSION['login']==1) {
																	 echo @$_SESSION['UserName'];
																	}else {
																		echo 'Login';	
																	} ?></a></li>
		</ul>
	</ul>

<div style="text-align: center; font-family: Arial; font-size:100%; ">
	<h1>About</h1>
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<img src="pb.png" alt=""  height="224">
					<table background="backgroundforcontact2.png" style="background-size: 100% 100%; width:80%; height:249px;">
						<tr>
							<td align='center'>
								<table background="backgroundforcontact3.png "style="background-size: 100% 100%";>
									<tr>
										<td align='center'>									
											<img src="575346.gif" width="68" height="76">
												<br>
												BSSS stands for <br>
												Better School <br> Schedule System
											<table background="backgroundforcontact4.png "style="background-size: 100% 100%; font-size:90%;";>
												<tr>
													<td align='center'>
														This system has been created<br>
														to create A Level School<br>
														Schedules in order to simplify<br>
														the creation of new schedules <br>
														for both the teachers and <br>
														students.
													</td>
												</tr>
											</table>
							
										</td>
									</tr>								
								</table>							
							</td>
						</tr>
					</table>
					</td>				
				</tr>
			</table>	
		</td>
	</tr>

</table>
</div>
</body></html> 	