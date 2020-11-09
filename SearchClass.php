<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);			
	
		   $SQLTeacher = "SELECT * FROM teacher WHERE TeacherID<>'ALL' AND TeacherID!='ADM'";
   			$TeacherResult = mysql_query($SQLTeacher);

			$SQLClass= "SELECT * FROM class WHERE ClassID<>'ALL'";
				$ClassResult = mysql_query($SQLClass);
		session_start();
		@$UserName=$_SESSION['UserName'];
		@$TeacherID=$_SESSION['ID'];


?>

<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Search Schedule</title>
</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
		  <?php if(@$_SESSION['login']==1) {	?>
	
		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li> 
		<li><a href="selectclassparallelsubject.php">Parallel Subject Assignment</a></li>			
		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
		<?php
		}else {}?>
 		<li><a class="active"href="search.php">Search Schedule</a></li>
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
<center><h1>Search Schedule</h1></center>
<table
 style="width: 100%; height: 516px;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
<tr>
	<td>
<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<img src="searchforaclass.png"><img src="baka2.png" alt="" width="162" height="224">
					<table background="backgroundforcontact2.png" style="background-size: 100% 100%; width:80%; height:200px;">
						<tr>
							<td align='center'>
								<table background="backgroundforcontact3.png "style="background-size: 100% 100%";>
									<tr>
										<td align='center'>									
											<br><br><br>
											<img src="575346.gif" width="68" height="76">
											<table background="backgroundforcontact4.png "style="background-size: 100% 100%; font-size:90%;";>
												<tr>
													<td align='center'>
														<br><br>	
														<table border="0" cellpadding="0" cellspacing="0">
														<form action="SearchClass2.php" method="post">
																														
															<tr>
																<td>
																	ClassID: 
																</td>		
																<td>
																	<select name='ClassID'>
																<?php
   	 															while ($row = mysql_fetch_assoc($ClassResult)) {
   	 														?>
   	 				
   																<option value="<?php echo $row['ClassID'];?>" ><?php echo $row['ClassID'].'-'.$row['ClassName']; ?></option>
																<?php				
																	} 
																?>
																	</select>
																</td>	
															</tr>
															<tr>
															<tr>
																<td>
																	<input type="submit" value="Submit">
																</td>
																<td>
																	<a href="search.php"><button type="button">Return</button></a>
																</td>															
															</tr>
															</form>												
															</tr>
														</table>
																			
													</td>
												</tr>
											</table>
												
										</td>
									</tr>								
								</table>
								<br><br>							
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