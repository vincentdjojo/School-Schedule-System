<?php
		session_start();
		$ClassID=$_SESSION['ClassID'];	

		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);			
	
		$PrioritySubject=$_POST['PrioritySubject'];
		$PeriodTime=$_POST['PeriodTime'];
		$PeriodDay=$_POST['PeriodDay'];
		$DayPeriods=$_POST['Periods']; //Number of periods on that particular day
		$OverlapError='';
		$ErrorMessage='';			
			
   	$SQLPeriods = "SELECT * FROM assignment WHERE MergeInfo='$PrioritySubject' AND ClassID='$ClassID'";
   		$PeriodsResult = mysql_query($SQLPeriods);
   	
   	while($db_field=mysql_fetch_assoc($PeriodsResult)) {
			$TeacherID=$db_field['TeacherID'];
			$SubjectID=$db_field['SubjectID'];   		
   		$Periods=$db_field['Periods'];
   		$MergeInfo=$db_field['MergeInfo'];
   		$IsFirstSubjectParallel=$db_field['IsFirstSubjectParallel'];
   		$IsSubjectForAllClasses=$db_field['IsSubjectForAllClasses'];
   	}		
			
		//${$ClassID}=$_SESSION["$ClassID"];
		//$Classes=$_SESSION["Classes"];	
		
		for ($time=1;$time<17;$time++) {
     		for($day=1;$day<6;$day++){
              $TimeTable[$time][$day]="";
			}
		}
					
		//$Count=1;
		//$_SESSION["Count"]=$Count;
		//$Classes[$Count]=$ClassID; /* Store class name in an Array called 'Classes' */
		//$_SESSION["Classes"]=$Classes[$Count];		

		//$SQLclass = "SELECT * FROM assignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$ClassID' OR IsSubjectForAllClasses='1'";
   		//$ParallelSubjectResult = mysql_query($SQLclass);

   	$SQLteacher = "SELECT * FROM assignment WHERE MergeInfo='$PrioritySubject' AND ClassID='$ClassID'"; //Get teacher names
   		$ParallelTeacherResult = mysql_query($SQLteacher);
		$Teachers='';
		
   	while($db_field=mysql_fetch_assoc($ParallelTeacherResult)) { //Get teacher names
			$Teachers=$Teachers.$db_field['TeacherID'];
			$MergeInfo=$db_field['MergeInfo'];
		}
		   		
		$FirstTeacher=substr($Teachers,0,3);
 		$SecondTeacher=substr($Teachers,3,3);
 		$ThirdTeacher=substr($Teachers,6,6);

		//echo $FirstTeacher.' '.$SecondTeacher.' ' .$ThirdTeacher;		
		
		$FirstSubject=substr($MergeInfo,0,3);
		$SecondSubject=substr($MergeInfo,4,3);
		$ThirdSubject=substr($MergeInfo,8,3);

		//echo $FirstSubject.' '.$SecondSubject.' '.$ThirdSubject;
 		
//===============================================
 		
		$SQLCheck = "SELECT * FROM periodassignment WHERE (PeriodTime = '$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$ClassID') OR (PeriodTime = '$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='ALL')"; //Check if there is a subject in the PeriodTime and PeriodDay
			$result = mysql_query($SQLCheck);
   		$num_rows = mysql_num_rows($result);


			
		$CheckPeriodTimeFirstTeacher = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND TeacherID='$FirstTeacher'";	 
   		$FirstTeacherTimeResult = mysql_query($CheckPeriodTimeFirstTeacher);
		$FirstTeacherRowCheck = mysql_num_rows($FirstTeacherTimeResult);	

		$CheckPeriodTimeSecondTeacher = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND TeacherID='$SecondTeacher'";	 
   		$SecondTeacherTimeResult = mysql_query($CheckPeriodTimeSecondTeacher);
		$SecondTeacherRowCheck = mysql_num_rows($SecondTeacherTimeResult);		
		
		$CheckPeriodTimeThirdTeacher = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND TeacherID='$ThirdTeacher'";	 
   		$ThirdTeacherTimeResult = mysql_query($CheckPeriodTimeThirdTeacher);
		$ThirdTeacherRowCheck = mysql_num_rows($ThirdTeacherTimeResult);				

		if($FirstTeacherRowCheck==0) {
			if($SecondTeacherRowCheck==0) {
				if($SecondTeacherRowCheck==0) {			
   				if($num_rows>0) {
						$OverlapError="There is already a subject at Day ".$PeriodDay." during Period ".$PeriodTime;	
     				}					
     				else {
     					$num_rows2=0;
     					$time=$PeriodTime;
						$PeriodTest=$PeriodTime+$DayPeriods;				
					
						 while (($num_rows2 == 0) && ($time<$DayPeriods+$PeriodTime)){
							$SQLCheck = "SELECT * FROM periodassignment WHERE (PeriodTime = '$time' AND PeriodDay='$PeriodDay' AND ClassID='$ClassID') OR (PeriodTime = '$time' AND PeriodDay='$PeriodDay' AND ClassID='ALL')"; //Check if there is a subject in the PeriodTime and PeriodDay
								$result = mysql_query($SQLCheck);
   						$num_rows2 = mysql_num_rows($result);	
							$time=$time+1;		
						}
						if($num_rows2==0) {	
							$SQLPeriodCheck = "SELECT * FROM periodassignment WHERE SubjectID='$FirstSubject' AND ClassID='$ClassID'"; //Check if there is a subject in the PeriodTime and PeriodDay
								$result = mysql_query($SQLPeriodCheck);
   						$num_rows = mysql_num_rows($result);
   						if($num_rows < $Periods) {
   							if(($DayPeriods+$num_rows)<=$Periods) {
     								$PeriodTest=$PeriodTime+$DayPeriods;
									if($ThirdSubject=='') {
										for($x=$PeriodTime;$x<$PeriodTest;$x++) {   			
   										$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$ClassID'";
   										$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);	
	
   										while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {
												$SubjectOne=$db_field['SubjectID'];
												$TeacherOne=$db_field['TeacherID'];   						
   										}


												$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      											VALUES ('$FirstSubject','$ClassID','$TeacherOne','$x','$PeriodDay')";        
      										$result = mysql_query($SQLWriteFirstSubject);      					
      					
   											$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$ClassID'";
   												$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   											while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
													$SubjectTwo=$db_field['SubjectID'];
													$TeacherTwo=$db_field['TeacherID'];   						
   											}

												$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      										VALUES ('$SubjectTwo','$ClassID','$TeacherTwo','$x','$PeriodDay')";        
      											$result = mysql_query($SQLWriteSecondSubject);
   									}
   								}
   								else {//Insert parallel subject into table periodassignment
   									for($x=$PeriodTime;$x<$PeriodTest;$x++) {  
   										$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$ClassID'";
   										$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);

   										while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {	
												$SubjectOne=$db_field['SubjectID'];
												$TeacherOne=$db_field['TeacherID'];   						
   										}


											$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$FirstSubject','$ClassID','$TeacherOne','$x','$PeriodDay')";        
      										$result = mysql_query($SQLWriteFirstSubject);      						
   										$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$ClassID'";
   										$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   										while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
												$SubjectTwo=$db_field['SubjectID'];
												$TeacherTwo=$db_field['TeacherID'];   						
   										}
											$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$SubjectTwo','$ClassID','$TeacherTwo','$x','$PeriodDay')";        
      									$result = mysql_query($SQLWriteSecondSubject);
      					
   										$SQLGetThirdPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$ThirdSubject' AND ClassID='$ClassID'";
   										$GetThirdPrioritySubjectResult = mysql_query($SQLGetThirdPrioritySubject);
												
	
   										while($db_field=mysql_fetch_assoc($GetThirdPrioritySubjectResult)) {
												$SubjectThree=$db_field['SubjectID'];
												$TeacherThree=$db_field['TeacherID'];   						
   										}
											$SQLWriteThirdSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$SubjectThree','$ClassID','$TeacherThree','$x','$PeriodDay')";        
      									$result = mysql_query($SQLWriteThirdSubject);
      								}		
									}
								}
								else {
									$ErrorMessage='The total periods is exceeding its limit';	
								}
							}
							else {
								$ErrorMessage='Subject has reached its maximum number of periods';
							}
		
						}
						else {
							$ErrorMessage='There is a subject overlapping';		
						}
					}	
	
				}else {
					$ErrorMessage=$FirstTeacher." has another class";				
				}
			}else {
				$ErrorMessage=$SecondTeacher." has another class";										
			}
		}else {
			$ErrorMessage=$ThirdTeacher." has another class";			
		}
		
			$SQLparallelsubject = "SELECT * FROM assignment WHERE IsFirstSubjectParallel = '1'"; //Get MergeInfo from the table assignment
			$parallelsubjectresult=mysql_query($SQLparallelsubject);
?>
<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Choose a Period Time and Day for a Parallel Subject</title>
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
 		<li><a href="">Search Schedule</a></li>
  		<li><a href="#contact">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a href="#about">About</a></li>
		<li>
			<a href="#login">Login</a></li>
		</ul>
	</ul>
<div style="text-align: center; font-family: Arial;">
<h1>Generate Schedule</h1>
<table
 style="width: 100%; height: 516px;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
<tr>
	<td>
	<center>
		<h2>Choose a Period Time and Day for a Parallel Subject</h2>	
<table style="height: 20px;" align="center" bgcolor="#FFFFFF">	
<form action="PrioritySubjects2.php" method="post">
	<tr>	
		<td>
			Parallel Subject:
		</td>	
		<td>
			<select name='PrioritySubject'>
				<?php
					while ($row = mysql_fetch_assoc($parallelsubjectresult)) {
   	 		?>
   	 		<option value="<?php echo $row['MergeInfo'];?>"><?php echo $row['MergeInfo'];?></option>
		<?php				
					} 
		?>
			</select></td>
		<td>
			<font color="red"><?php echo $OverlapError.' '.$ErrorMessage; ?></font>		
		</td>		
	</tr>		
			<td>			
			Period Time:
			</td>
			<td><select name='PeriodTime'>
			
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
   	 				<option value="13">13</option>
   	 				<option value="14">14</option>

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
<td>		Periods:</td><td><select name='Periods'>
					   <option value="1">1</option>
					   <option value="2">2</option>
					   <option value="3">3</option>
					   <option value="4">4</option>
					   <option value="5">5</option>
					   
			</select></td>
			</tr>
<tr>
	<td>
		<input type="submit" value="Submit">
	</td>
	<?php// 
   		//				$RowsGet = "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND SubjectID='$FirstSubject'";
			//					$RowsGetResult = mysql_query($RowsGet); 			
			//				$num_rows3 = mysql_num_rows($RowsGetResult);		//check number of the parallel subject exist
		//if($num_rows3==$Periods) {
	 ?>
<td>
<?php 
			$SQLparallelsubject = "SELECT * FROM assignment WHERE IsFirstSubjectParallel = '1'"; //Get Periods of Parallel Subject from the table assignment
			$parallelsubjectresult=mysql_query($SQLparallelsubject);
			$total=0;
			while ($row = mysql_fetch_assoc($parallelsubjectresult)) {
				$total=$total+$row['Periods'];
				$subject=$row["SubjectID"];
				$SQLPeriodAssignment = "SELECT * FROM periodassignment WHERE SubjectID = '$subject'"; //Get SubjectID of Parallel Subject from the table periodassignment
					$SQLPeriodAssignmentResult=mysql_query($SQLPeriodAssignment);			
				$num_rows = mysql_num_rows($SQLPeriodAssignmentResult);
			}
			if($num_rows==$total) {				

?>
		<a href="PrioritySubjectMenu.php"><button type="button">Done</button></a>
	</td>
	<?php 
		   } 
	?>
	
	
</tr>
</table>
</table>
</form>
<h2><center><?php echo $ClassID.' ' ?>Schedule</center></h2>
<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 80%;" align="center" bgcolor="#FFFFFF">
	<?php
				for ($x=1;$x<17;$x++) { //Store subjects in array TimeTable
     				for($y=1;$y<6;$y++){
   					$SQLGetSubject = "SELECT * FROM periodassignment WHERE (ClassID = '$ClassID' AND PeriodTime = '$x' AND PeriodDay = '$y' OR ClassID='ALL' OR TeacherID='ALL') ";
							$GetSubjectResult = mysql_query($SQLGetSubject); 
						while($db_field=mysql_fetch_assoc($GetSubjectResult)) {
								$TimeTable[$db_field["PeriodTime"]][$db_field["PeriodDay"]]=$db_field["SubjectID"].'-'.$db_field['TeacherID'];								
						}   					      
               }
            }
				for ($x=1;$x<17;$x++) { //Store parallel subjects in array TimeTable
     				for($y=1;$y<6;$y++){            
   						$SQLGetPeriodMergedSubject = "SELECT * FROM periodassignment WHERE (ClassID = '$ClassID' AND PeriodTime='$x' AND PeriodDay='$y') ";
								$GetPeriodMergedSubjectResult = mysql_query($SQLGetPeriodMergedSubject); 			
							$num_rows = mysql_num_rows($GetPeriodMergedSubjectResult);	
							if($num_rows>1) {
   							$SQLGetSubject = "SELECT * FROM periodassignment WHERE (ClassID = '$ClassID' AND PeriodTime = '$x' AND PeriodDay = '$y') ";
									$GetSubjectResult = mysql_query($SQLGetSubject); 															
									$TimeTable[$x][$y]='';								
								while($db_field=mysql_fetch_assoc($GetSubjectResult)){
									if($TimeTable[$x][$y]=="") {
										$TimeTable[$x][$y]=$db_field["SubjectID"];
									}else{
									$TimeTable[$x][$y]=$TimeTable[$x][$y].'-'.$db_field["SubjectID"];
									}
								}
   							$SQLGetTeacher = "SELECT * FROM periodassignment WHERE (ClassID = '$ClassID' AND PeriodTime = '$x' AND PeriodDay = '$y') ";
									$GetTeacherResult = mysql_query($SQLGetTeacher); 	
								while($db_field=mysql_fetch_assoc($GetTeacherResult)){
									$TimeTable[$x][$y]=$TimeTable[$x][$y].'-'.$db_field["TeacherID"];
								}									
															
							}								
						}
					}															
					 
		echo "<tr><td>".$ClassID."</td>";
		echo "<td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td>";
		echo "<tr><td></td><td>Assembly</td></tr>";
		echo "<tr>";
		for($time=1;$time<5;$time++) {
			echo "<td>".$time."</td>";
			for($day=1;$day<6;$day++){
				echo "<td>".$TimeTable[$time][$day]."</td>";
			}
			echo "</tr>";
		}
		echo "<tr><td></td><td>Break</td></tr>";
		for($time=5;$time<9;$time++){
			echo "<tr><td>".$time."</td>";	
			for($day=1;$day<6;$day++){
				echo "<td>".$TimeTable[$time][$day]."</td>";
			}
			echo "</tr>";
		}
		echo "<tr><td></td><td>Lunch</td></tr>";
		for($time=9;$time<16;$time++){
			echo "<tr><td>".$time."</td>";	
			for($day=1;$day<6;$day++){
				echo "<td>".$TimeTable[$time][$day]."</td>";
			}
			echo "</tr>";
		}
	?>
</table>
	
	</body>
</html>		