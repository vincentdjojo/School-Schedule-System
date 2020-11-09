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
<html>

<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Home</title>
</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a class="active" href="home.php">Home</a></li>
		<?php if(@$_SESSION['login']==1) { ?>																	
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li>
		<li><a href="selectclassparallelsubject.php">Parallel Subject Assignment</a></li>	 		
		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
		<?php 
		}
		 ?>
 		<li><a href="search.php">Search Schedule</a></li>
  		<li><a href="contact.php">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a href="about.php">About</a></li>
		<li>
			<a  href="login.php"><?php if(@$_SESSION['login']==1) {
											echo(@$_SESSION['UserName']);
										}else if(@$_SESSION['login']!=1) {
											echo ("Login");	
										} ?>
			</a>
		</li>
	</ul>
	</ul>
<div style="text-align: center; font-family: Arial; font-size:100%; ">
	<h1>Home</h1>
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;"  border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<img src="home.png"><img src="baka2.gif" alt="" width="162" height="224">
					<table background="backgroundforcontact2.png" style="background-size: 100% 100%; width:80%; height:249px;">
						<tr>
							<td align='center'>
								<table background=""style="background-size: 100% 100%";>
									<tr>
										<td align='center'>									

											<table background="backgroundforcontact3.png "style="background-size: 100% 100%; width:400px; font-size:226px;";>
												<tr>
													<td align='center'>
		<center>
			<img src="bbssslogo.png" align="middle"height="226"  >
		</center>	
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

</body>
</html>