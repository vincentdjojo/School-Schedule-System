<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
		
		$SQLteacher = "SELECT * FROM teacher WHERE TeacherID!='ADM' AND TeacherID!='ALL' AND TeacherID!='MUS'";
   		$TeacherIDResult = mysql_query($SQLteacher);
		
		$TeacherID=$_POST['TeacherID'];
		$Password=$_POST['Password'];
		$PasswordCheck=$_POST['PasswordCheck'];
		
		if(isset($_POST['head'])){
			$head=$_POST['head'];		
		}
		else {
			$head=0;
		}
		
		$PasswordCheckError="";
		$TeacherExistenseCheckError="";		
		$InsertionCheck="";		
		
		$PasswordLength = strlen($Password);
		
		$TeacherExistenseCheck = "SELECT * FROM admin WHERE TeacherID='$TeacherID'";
   		$TeacherExistenseCheckResult = mysql_query($TeacherExistenseCheck);
		$num_rows = mysql_num_rows($TeacherExistenseCheckResult);
		
		if (empty($PasswordCheck)) {
    		$PasswordCheckError = "Password Verification is required";
    
 		} 

		if($PasswordLength >= 4 && $PasswordLength <= 50) {
			$PasswordError = "";
		}
		else {
			$PasswordError = "Password must be less than or equal to 50 characters and greater than or equal to 4 characters";

		}
		
		if($Password!=$PasswordCheck) {
			$PasswordCheckError='The password you entered does not match';		
		}
		
		if (empty($Password)) {
    		$PasswordError = "Password is required";
    
 		} 
 		if($num_rows==0) {
			if($PasswordError=="") {
				if($PasswordCheckError=="") {
					if($head==0) {
						$InsertionCheck=$TeacherID.' is now a Moderator';
					}else {
						$InsertionCheck=$TeacherID.' is now a Operator';	
					}
						$SQL = "INSERT INTO admin (TeacherID,Password,Head)
                                        VALUES ('$TeacherID','$Password','$head')";
                        
                                        $result = mysql_query($SQL);
                                       			
				}
			}
		}else {
			$TeacherExistenseCheckError=$TeacherID.' is already an admin';		
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
													<form action="AddAdmin2.php" method="post">															
															<tr>
																<td align='center'>
																	<table>
																		<tr>
																			<td>
																				<font size='2'>TeacherID:<br><font color="red" size='0.1'><?php echo $TeacherExistenseCheckError; ?></font></font> <font color='green' size='0.1'><?php echo $InsertionCheck;?></font>																			
																			</td>
																			<td>
																			<select name='TeacherID'>	
																			<?php
   	 																		while ($row = mysql_fetch_assoc($TeacherIDResult)) {
   	 																	?>
   	 				
   																			<option value="<?php echo $row['TeacherID'];?>" ><?php echo $row['TeacherID'].'-'.$row['FirstName']; ?></option>
																			<?php				
																				} 
																			?>	
																			</select>
																			<br><font size='2'>Operator? <input type="checkbox" name="head" value="1" ></font>
																			</td>
																		</tr>
																	
																				
																			
																		<tr>
																			<td>
																				<font size='2'>Password:</font>
																			</td>
																			<td>
																			<input type="password" name="Password" maxlength="50">
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				<font color='red' size='0.1'><?php echo $PasswordError; ?></font>																			
																			</td>
																		</tr>
																		
																		<tr>
																			<td>
																			
																				<font size='2'>Verify Password:</font>
																			</td>
																			<td>
																				<input type="password" name="PasswordCheck" maxlength="50">
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				<font color='red' size='0.1'><?php echo $PasswordCheckError; ?></font>
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