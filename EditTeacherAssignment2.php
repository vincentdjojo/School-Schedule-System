<html>

	<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";


		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
	
		$InitializeAssignmentTable = "TRUNCATE TABLE periodassignment";
			$InitializeAssignmentTableResult = mysql_query($InitializeAssignmentTable);

		$InitializeAssembly = "DELETE from periodassignment WHERE SubjectID='ASS'";
			$InitializeAssemblyResult = mysql_query($InitializeAssembly);
		$InitializeAssembly2 = "DELETE from assignment WHERE SubjectID='ASS'";
			$InitializeAssemblyResult2 = mysql_query($InitializeAssembly2);  
		$InitializeChapel2 = "DELETE from assignment WHERE SubjectID='CPL'";
			$InitializeChapelResult2 = mysql_query($InitializeChapel2);
		$InitializeChapel = "DELETE from periodassignment WHERE SubjectID='CPL'";
			$InitializeChapelResult = mysql_query($InitializeChapel);
		$InitializeMergeInfo = "UPDATE assignment SET MergeInfo='',IsFirstSubjectParallel='0' WHERE MergeInfo!=''";
			$InitializeMergeInfoResult = mysql_query($InitializeMergeInfo);
		$InitializeFirstParallelSubject = "UPDATE assignment SET IsFirstSubjectParallel='0' WHERE IsFirstSubjectParallel='1'";
			$InitializeFirstParallelSubjectResult = mysql_query($InitializeFirstParallelSubject);
		$InitializeMus = "DELETE from assignment WHERE SubjectID='MUS'";
			$InitializeMusResult = mysql_query($InitializeMus);
	
		$TeacherID=$_GET["tid"];	
		$SubjectID=$_GET["sid"];
		$ClassID=$_GET["cid"];
		$Periods=$_GET["periods"];		
		
		$_SESSION['TeacherID']=$TeacherID;
		$_SESSION['SubjectID']=$SubjectID;		
		$_SESSION['ClassID']=$ClassID;
		
		$SubjectIDError="";
		$InsertionCheck="";
		//$TeacherIDError= $SubjectIDError= $ClassIDError= "";
		
				//=======================================================
				//		CHECK THAT ANY FIELD IS NOT TAKEN
				//=======================================================
				
		 
		 			$SQLTeacherName = "SELECT * FROM teacher WHERE TeacherID='$TeacherID'";
   					$TeacherNameResult = mysql_query($SQLTeacherName);
				   $SQLteacher = "SELECT * FROM teacher WHERE TeacherID<>'ALL'";
   					$teacherresult = mysql_query($SQLteacher);
		   		$SQLsubject = "SELECT * FROM subject WHERE SubjectID != 'CHL' AND SubjectID!='MUS' AND SubjectID!='PE' AND SubjectID!='CPL' AND SubjectID!='ASS'";
   					$subjectresult = mysql_query($SQLsubject);
   				$SQLclass = "SELECT * FROM class WHERE ClassID<>'ALL'";
   					$classresult = mysql_query($SQLclass);
   				
   	 			while ($row = mysql_fetch_assoc($TeacherNameResult)) {		
   	 				$TeacherName=$row['FirstName'];
   	 			}			
   
   
	?>
<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Teacher Assignment</title>
</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a class="active" href="assignement.php">Teacher Assignment</a></li> 		
 		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
  		<li><a href="#contact">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a href="#about">About</a></li>
		<li>
			<a href="#login">Login</a></li>
		</ul>
	</ul>
<div style="text-align: center; font-family: Arial; font-size:100%; ">
<center><h1>Teacher Assignment</h1></center>
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<img src="teacherassignment.png"><img src="baka2.png" alt="" width="162" height="224">
					<table background="backgroundforcontact2.png" style="background-size: 100% 100%; width:80%; height:249px;">
						<tr>
							<td align='center'>
								<table background="backgroundforcontact3.png "style="background-size: 100% 100%";>
									<tr>
										<td align='center'>									
											
												<img src="575346.gif" width="68" height="76">
											<table background="backgroundforcontact4.png "style="background-size: 100% 100%; font-size:90%;";>
												<tr>
													<td align='center'>
	
														<form action="EditTeacherAssignment3.php" method="post">
														<center>
														<table style="height: 20px;" align="center" bgcolor="">	
															<tr>			
																<td>
																	Teacher:
																</td>
																<td>
																	<?php echo $TeacherID.'-'.$TeacherName; ?>
    	 															<input type="hidden" name="TeacherID" value="<?php echo $TeacherID; ?>" />  	 	

																</td>
																<td>
																</td>
															<tr>
																<td colspan="2">
						
																</td>
															</tr>
															<tr>
																<td>
																	Subject:
																</td>
																<td>
																	<select name='SubjectID'>
																<?php
   	 															while ($row = mysql_fetch_assoc($subjectresult)) {
   	 														?>
   	 				
   																<option value="<?php echo $row['SubjectID'];?>"><?php echo $row['SubjectID'].'-'.$row['SubjectName'];;?></option>
																<?php				
																	} 
																?>
																	</select>
																</td>

															</tr>
														<tr>
															<td>
																Class:
															</td>
															<td>
																<select name='ClassID'>
															<?php
   	 														while ($row = mysql_fetch_assoc($classresult)) {
   	 													?>
   	 													<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
															<?php				
																}
															?>
																</select>
															</td>
														</tr>
														<tr>
															<td>
																Periods:
															</td>
															<td>
																<select name='Periods'>
																	<option value="1">1</option>
																	<option value="2">2</option>
																	<option value="3">3</option>
																	<option value="4">4</option>
																	<option value="5">5</option>
																	<option value="6">6</option>
																	<option value="7">7</option>
																	<option value="8">8</option>
																	<option value="9">9</option>
																	<option value="10">10</option>
																</select>
															</td>
														</tr>
														<tr>
															<td>
																<input type="submit" value="Submit">
															</td>
															<td>
																<a href="assignement.php"><button type="button">Return</button></a>		
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
		</form>
		</td>
	</tr>
</table>
</table>
<center>
	<h2>
Previous Assignment
	</h2>
</center>
<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">	
	<tr>
		<td>
			Teacher:
		</td>	
		<td>
			<?php 
				$SQLTeacherList = "SELECT * FROM teacher WHERE TeacherID='$TeacherID'";
   				$TeacherListResult = mysql_query($SQLTeacherList);
   	 			while ($row = mysql_fetch_assoc($TeacherListResult)) {
   	 					echo $TeacherID.'-'.$row['FirstName'];
					} 
			?>
		</td>
	</tr>
	<tr>
		<td>
			Subject:
		</td>	
		<td>
			<?php 
				$SQLSubjectList = "SELECT * FROM subject WHERE SubjectID='$SubjectID'";
   				$SubjectListResult = mysql_query($SQLSubjectList);
   	 			while ($row = mysql_fetch_assoc($SubjectListResult)) {				
						echo $SubjectID.'-'.$row['SubjectName']; 
					}				
				?>
		</td>
	</tr>	
	<tr>
		<td>
			Class:
		</td>	

		<td>
			<?php 
				$SQLClassList = "SELECT * FROM class WHERE ClassID='$ClassID'";
   				$ClassListResult = mysql_query($SQLClassList);
   	 			while ($row = mysql_fetch_assoc($ClassListResult)) {				
						echo $ClassID.'-'.$row['ClassName']; 
					}				
				?>
		</td>
	</tr>
	<tr>
		<td>
			Periods:
		</td>	

		<td>
			<?php echo $Periods; ?>
		</td>
	</tr>
</table>	