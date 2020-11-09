<html>
<head>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Choose a Period Time and Day for Faith Builder</title>
</head>
<?php
ini_set('max_execution_time', 300); 
		session_start();
		$ClassID=$_SESSION['ClassID'];	
		ini_set('max_execution_time', 300); 
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);	
		
		for ($time=1;$time<17;$time++) {
     		for($day=1;$day<6;$day++){
              $TimeTable[$time][$day]="";
			}
		}
   	
   	$SQLSubjects = "SELECT * FROM assignment WHERE ClassID='$ClassID' AND SubjectID!='ASS' AND SubjectID!='CPL' AND SubjectID!='MUS' AND SubjectID!='PHE' AND SubjectID!='FAB' AND SubjectID!='CCA' AND MergeInfo=''";
   		$SubjectResult = mysql_query($SQLSubjects);

   	$SubjectCount=1;
   	$PeriodCount=1;
   	$RemainingSubjectCount=0;	
   	$TotalRemainingPeriods=0;
   		
		while($db_field=mysql_fetch_assoc($SubjectResult)) {
			$Subject=$db_field['SubjectID'];
			
			$Periods=$db_field['Periods'];
			$Teacher=$db_field['TeacherID'];
   		
   		$SQLAssignmentRows = "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND SubjectID='$Subject'";
   			$SQLAssignmentRowsResult = mysql_query($SQLAssignmentRows);

   		$AssignmentRows=mysql_num_rows($SQLAssignmentRowsResult);				
	
			if($AssignmentRows!=$Periods) {
				$RemainingSubjectCount=$RemainingSubjectCount+1;
				$RemainingSubjects[$RemainingSubjectCount]=$Subject;
			   $RemainingTeachers[$RemainingSubjectCount]=$Teacher;
			   $RemainingPeriods[$RemainingSubjectCount]=$Periods;
			}
			$SubjectCount=$SubjectCount+1;
	
		}
		
			$SumOfNonParallel="SELECT sum(Periods) as TotPer FROM `assignment` WHERE classID='$ClassID' AND IsFirstSubjectParallel=0 and MergeInfo='' OR (SubjectID='ASS' OR SubjectID='CPL' OR SubjectID='CCA')";
   				$SumOfNonParallelResult = mysql_query($SumOfNonParallel);	
			$SumOfParallel="SELECT sum(Periods) as TotPer FROM `assignment` WHERE classID='$ClassID' AND IsFirstSubjectParallel=1";
   				$SumOfParallelResult = mysql_query($SumOfParallel);	
			$TotalNonParallel=mysql_fetch_assoc($SumOfNonParallelResult);
			$TotalParallel=mysql_fetch_assoc($SumOfParallelResult);
   		$Period=$TotalNonParallel['TotPer']+$TotalParallel['TotPer'];			
			$Remainder=$Period % 5;
			echo $Period;
			if($Remainder==0) {
			
			for($i=0;$i<5;$i++) {
					$max[$i]=floor($Period/5);	
				}	
			}else if($Remainder==1){
				$max[0]=floor($Period/5)+1;	
				for($i=1;$i<5;$i++) {	
					$max[$i]=floor($Period/5);								
				}			
			}else if($Remainder==2){
				$max[0]=floor($Period/5)+1;
				$max[1]=floor($Period/5)+1;
				for($i=2;$i<5;$i++) {	
					$max[$i]=floor($Period/5);								
				}						
			}else if($Remainder==3){
				$max[0]=floor($Period/5)+1;
				$max[1]=floor($Period/5)+1;
				$max[2]=floor($Period/5)+1;
				for($i=3;$i<5;$i++) {	
					$max[$i]=floor($Period/5);								
				}						
			}else if($Remainder==4){
				$max[0]=floor($Period/5)+1;
				$max[1]=floor($Period/5)+1;
				$max[2]=floor($Period/5)+1;
				$max[3]=floor($Period/5)+1;				
				for($i=4;$i<5;$i++) {	
					$max[$i]=floor($Period/5);								
				}
			}	
			
			$PeriodDay=1;
			$RemainingCount=1;			
				$GetPeriodDayGaps= "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND PeriodDay='$PeriodDay'";	
					$GetPeriodDayGapsResult = mysql_query($GetPeriodDayGaps);							
				$GapRows=mysql_num_rows($GetPeriodDayGapsResult);
				//$maximum=$max[$PeriodDay]			
		for ($i=1;$i<count($RemainingSubjects);$i++) 
			for($Day=1;$Day<6;$Day++) {
				$maximum=$max[$Day-1];	
				
				for($DayTime=1;$DayTime<=$maximum;$DayTime++){
						
										
						
						$GetEmptySlot= "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND PeriodDay='$Day' 
						AND PeriodTime='$DayTime'";	
							$GetEmptySlotResult = mysql_query($GetEmptySlot);						
						$EmptySlotRows=mysql_num_rows($GetEmptySlotResult);					
						$CheckPeriodTimeTeacher = "SELECT * FROM periodassignment WHERE PeriodTime='$DayTime' 
						AND PeriodDay='$Day' AND TeacherID='$RemainingTeachers[$i]'";	 
							$TeacherTimeResult = mysql_query($CheckPeriodTimeTeacher);
						$TeacherRowCheck = mysql_num_rows($TeacherTimeResult);													
						
						echo "empty=".$EmptySlotRows;		
						
										
						
						if($EmptySlotRows==0) {
							if($TeacherRowCheck==0) {
								$SQLWriteSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$RemainingSubjects[$i]','$ClassID','$RemainingTeachers[$i]',$DayTime,$Day)";
      						echo $SQLWriteSubject;
      						$result = mysql_query($SQLWriteSubject);									
							}
						}
							
					}
									
				}
					
							
			
?>
<html>

  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Choose a Period Time and Day for Faith Builder</title>
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
  		<li><a href="contact.php">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a href="about.php">About</a></li>
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
	<td align='center'>
		<img src="575346.gif" alt="">
	</td>	
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