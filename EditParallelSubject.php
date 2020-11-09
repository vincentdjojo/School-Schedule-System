<html>

	<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";


		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
	
	
		$TeacherID=$_GET["tid"];	
		$SubjectID=$_GET["sid"];
		$ClassID=$_GET["cid"];
		$MergeInfo=$_GET["mergeinfo"];		
		
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
   			$SQLparallelsubject = "SELECT * FROM subject WHERE Category = 'p'";
					$parallelsubjectresult=mysql_query($SQLparallelsubject);
   
	?>
<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Select Parallel Subject</title>
</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li>
		<li><a class="active" href="selectclassparallelsubject.php">Parallel Subject Assignment</a></li>		 		
 		<li><a  href="ScheduleGeneration.php">Generate Schedule</a></li>
  		<li><a  href="search.php">Search Schedule</a></li>
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
	<center>
		<h1>Parallel Subject Assignment</h1>	
	</center>
<div style="text-align: center; font-family: Arial; font-size:100%; ">
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<img src="editparallelsubject.png"><img src="baka2.png" alt="" width="162" height="224">
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

		<form action="EditParallelSubject2.php" method="post">
	<center>
<table style="height: 20px;" align="center" bgcolor="">	
	<tr>
		<td>Class:</td>
		<td><?php echo $ClassID; ?></td>	
	</tr>
	<tr>
		<td>First Parallel Subject:</td>
		<td><?php echo $SubjectID?></td>
	</tr>	
	<tr>	
		<td>Second Parallel Subject:</td>	
		<td><select name='SecondParallelSubject'>
			
			<?php
					
   	 			while ($row = mysql_fetch_assoc($parallelsubjectresult)) {
   	 				?>
   	 				
   					<option value="<?php echo $row['SubjectID'];?>"><?php echo $row['SubjectID'];?></option>
<?php				
				} ?>
			</select></td>		
	</tr>
	<tr>
		<td>Third Parallel Subject:</td>	
		<td><select name='ThirdParallelSubject'>
			<option value=""> </option>
			<?php
			$SQLparallelsubject = "SELECT * FROM subject WHERE Category = 'p'";
			$parallelsubjectresult=mysql_query($SQLparallelsubject);
   	 		while ($row2 = mysql_fetch_assoc($parallelsubjectresult)) {
   	 				?>
   	 				
   					<option value="<?php echo $row2['SubjectID'];?>"><?php echo $row2['SubjectID'];?></option>
<?php				
				} ?>
			</select>
		</td>
	
	</tr>	
	<tr>
	<td>
		<input type="submit" value="Submit">
	</td>	
	<td>
			<a href="ParallelSubjectAssign.php?cid=<?php echo $ClassID;?>"><button type="button">Return</button></a>	
	</td>
	
	</tr>
</table>
	</center>
	<input type="hidden" name="SubjectID" value="<?php echo $SubjectID?>">
	<input type="hidden" name="ClassID" value="<?php echo $ClassID;?>">
		</form>
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
</table>
</div>
</body>
<center>
	<h2>
Previous Parallel Subject
	</h2>
</center>
<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">	
	<tr>

		<td align='center'>
			<?php 
				$SQLMergeInfo = "SELECT * FROM assignment WHERE TeacherID='$TeacherID' AND SubjectID='$SubjectID' AND ClassID='$ClassID'";
   				$MergeInfoResult = mysql_query($SQLMergeInfo);
   	 			while ($row = mysql_fetch_assoc($MergeInfoResult)) {
   	 					echo $row['MergeInfo'];
					} 
			?>
		</td>
	</tr>
	

</table>	