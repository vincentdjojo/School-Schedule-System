<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
		

		
		$RemoveCheck='';		
		
		$TeacherID=$_POST['TeacherID'];
		
		$ID=$_SESSION['ID'];
		$SQLteacher = "SELECT * FROM admin WHERE TeacherID!='ADM' and TeacherID!='$ID'";
   		$TeacherIDResult = mysql_query($SQLteacher);		
		
		$SQLRemoveAdmin = "DELETE FROM admin WHERE TeacherID = '$TeacherID'";
   		$SQLRemoveAdminResult = mysql_query($SQLRemoveAdmin);	
		
		if($_SERVER['REQUEST_METHOD']=='POST') {   	
   		$RemoveCheck=$TeacherID.' is successfully removed';
   	}	
?>
<html>
<head>
<link href="MyStyle.css" type="text/css" rel="stylesheet">
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Settings</title>

</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li> 		
		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
 		<li><a href="search.php">Search Schedule</a></li>
  		<li><a   href="contact.php">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a href="about.php">About</a></li>
		<li>
			<a class="active" href="login.php"><?php if($_SESSION['login']==1) {
																	 echo $_SESSION['UserName'];
																	}else {
																		echo 'Login';	
																	} ?></a></li>
		</ul>
	</ul>

<div style="text-align: center; font-family: Arial; font-size:100%; ">
	<h1>Settings</h1>
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
						<img src="settings.png" alt=""><img src="baka2.png" alt="" width="162" height="224">
						<table background="backgroundforcontact2.png" style="background-size: 100% 100%; width:80%; height:249px;">
							<tr>
								<td align='center'>
									<table background="backgroundforcontact3.png "style="background-size: 100% 100%";>
										<tr>
											<td align='center'>									
									
												<img src="575346.gif" width="68" height="76">
												<table background="backgroundforcontact4.png "style="background-size: 100% 100%; font-size:90%;";>
													<form action="RemoveAdmin2.php" method="post">															
															<tr>
																<td align='center'>
																	<table>
																		<tr>
																			<td>
																				<font size='2'>TeacherID:</font>																			
																			</td>
																			<td>
																			<select name='TeacherID'>	
																			<?php
   	 																		while ($row = mysql_fetch_assoc($TeacherIDResult)) {
   	 																	?>
   	 				
   																			<option value="<?php echo $row['TeacherID'];?>" ><?php echo $row['TeacherID']; ?></option>
																			<?php				
																				} 
																			?>	
																			</select><br>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				<font color='green' size='0.1'><?php echo $RemoveCheck; ?></font>
																			</td>
																		</tr>
																		<tr>
																			<td>
																				<!-- <font size='2'>Password:</font> -->
																			</td>
																			<td>
																				<!-- <input type="password" name="Password" maxlength="50"> -->
																	
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2">
																			</td>																		
																		</tr>																		
																		<tr>
																			<td>
																			
																				<font size='2'></font>
																			</td>
																			<td>
																				
																			</td>																		
																		</tr>
																		<tr>
																			<td colspan="2">
																			</td>																		
																		</tr>
																		<tr>
																			<td>
																				<input type="submit" value="Submit">																			
																			</td>	
																			<td>
																				<a href="settings.php"><button type="button">Return</button></a>
																			</td>																	
																		</tr>
																	</table>
																</td>
																</tr>
																</form>
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
		</td>
	</tr>

</table>
</div>
</body></html> 	