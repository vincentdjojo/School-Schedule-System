<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);

		$PrioritySubject=$_POST['PrioritySubject'];
		$PeriodDay=$_POST['PeriodDay'];
		$PeriodTime=$_POST['PeriodTime'];	
		$ErrorMessage="";
		$InsertionCheck="";
		
		@$UserName=$_SESSION['UserName'];
		@$TeacherID=$_SESSION['ID'];	

		$SQLCheckAss = "SELECT * FROM periodassignment WHERE SubjectID = 'ASS' AND PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay'"; /*Check where the subject 'Assembly' and 'CPL has been assigned to prevent overlapping between Assembly and Chapel (Next Page) */
		$CheckAss=mysql_query($SQLCheckAss);
      	$num_rows = mysql_num_rows($CheckAss);             
         if($num_rows>0) {
				$ErrorMessage= 'There is already a subject Day '.$PeriodDay.' during period '.$PeriodTime;
			}	
			else {
				$InsertionCheck=$PrioritySubject.' '.'Insertion Successful';
				$SQLWriteAssIntoAssignment = "INSERT INTO assignment (SubjectID,TeacherID,ClassID,IsFirstSubjectParallel,IsSubjectForAllClasses,Periods) 
                                   VALUES ('$PrioritySubject','ALL','ALL','0','1','1')";   /* Insert the subject 'Assembly' into the table 'Assignment */      
                                   $result = mysql_query($SQLWriteAssIntoAssignment);
				$SQLWriteAssIntoPeriodAssignment = "INSERT INTO periodassignment (SubjectID,TeacherID,ClassID,PeriodTime,PeriodDay) 
                                   VALUES ('$PrioritySubject','ALL','ALL','$PeriodTime','$PeriodDay')";   /* Insert the subject 'Assembly' into the table 'PeriodAssignment */      
                                   $result = mysql_query($SQLWriteAssIntoPeriodAssignment);  

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
<h1>Choose a Period Time and Day for Chapel</h1>
<div style="text-align: center; font-family: Arial; font-size:100%; ">
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
<form action="AssemblyChapel2.php" method="post">
<br>
	<table style="height: 20px;" align="center" bgcolor="">
<form action="AssemblyChapel3.php" method="post">
	<tr>	
		<td>
			Subject:
		</td>	
		<td>
			Chapel
		</td>		
		<td>

		</td>
	</tr>
	<tr>
		<td colspan="2">
			<font color='red' size='0.5'><?php echo $ErrorMessage; ?></font><font color='green' size='0.5'><?php echo $InsertionCheck; ?></font>		
		</td>	
	</tr>
	<tr>			
		<td>			
			Period Time:
		</td>
		<td>
			<select name='PeriodTime'>
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
   	 				<option value="11">11</option>
   	 				<option value="12">12</option>
			</select>
		</td>
	</tr>	
	<tr>
		<td>		
			Day:
		</td>
		<td>
			<select name='PeriodDay'>
				<option value="1">Monday</option>
				<option value="2">Tuesday</option>
				<option value="3">Wednesday</option>
				<option value="4">Thursday</option>
				<option value="5">Friday</option>
			</select>
		</td>
	</tr>
	<tr>
		
		<?php
		$SQLCheckCpl = "SELECT * FROM periodassignment WHERE SubjectID = 'CPL'"; /*Check where the subject 'Assembly' and 'CPL has been assigned to prevent overlapping between Assembly and Chapel (Next Page) */
		$CheckCpl=mysql_query($SQLCheckCpl);
      	$num_rows = mysql_num_rows($CheckCpl);             
      if($num_rows==0) {		 
		?>
		<td>
			<input type="submit" value="Submit">
		</td>
		<?php	
			
		}
		
		?>

			<input type="hidden" name="PrioritySubject" value="CPL">			
		<?php
			
			if($num_rows>0) {
		?>
		<td></td>
		<td>
			<a href="cca.php"><button type="button">Done</button></a>
		</td>
		<?php
			}	
		?>
		
	</tr>
	</table>
</table>
</form>
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
		</form>
		</td>
	</tr>
</table>
</table>
<?php
		$SQL = "SELECT * FROM periodassignment WHERE SubjectID = 'ASS'";
		$result=mysql_query($SQL);		
		
		while($db_field=mysql_fetch_assoc($result)) {
			$ASS=$db_field["SubjectID"];
			$AssPeriodDay=$db_field["PeriodDay"];
			$AssPeriodTime=$db_field["PeriodTime"];
		
				
?>
<br>
<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">
		<div align="center" style="font-family: Arimo;">
			<tr>
				<td>
					Subject:
				</td>
				<td>
					<?php echo $ASS?>
				</td>
			</tr>
			<tr>
				<td>
					Day
				</td>
				<td>
					<?php echo $AssPeriodDay;?>
				</td>
			</tr>
			<tr>
				<td>
					Period Time:
				</td>
				<td>
					<?php echo $AssPeriodTime; ?>
				</td>
			</tr>
		</div>
	</table>
			

<?php 
}		

		$SQL = "SELECT * FROM periodassignment WHERE SubjectID = 'CPL'";
		$result=mysql_query($SQL);		
		while($db_field=mysql_fetch_assoc($result)) {
			$CPL=$db_field["SubjectID"];
			$CPLPeriodDay=$db_field["PeriodDay"];
			$CPLPeriodTime=$db_field["PeriodTime"];
		
				
?>

<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">
		<div align="center" style="font-family: Arimo;">
			<tr>
				<td>
					Subject:
				</td>
				<td>
					<?php echo $CPL?>
				</td>
			</tr>
			<tr>
				<td>
					Day
				</td>
				<td>
					<?php echo $CPLPeriodDay;?>
				</td>
			</tr>
			<tr>
				<td>
					Period Time:
				</td>
				<td>
					<?php echo $CPLPeriodTime; ?>
				</td>
			</tr>
		</div>
	</table>
<?php
		}
?>