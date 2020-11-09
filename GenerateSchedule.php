<html>
<head>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title></title>
<!--  <script type="text/javascript" >
setTimeout(function () {
   window.location.href= "http://localhost/SchoolSchedule/GenerateSchedule2.php"; // the redirect goes here
},4000);
</script>-->
  
</head>
<?php
	//header('Refresh: 10; URL=http://localhost/SchoolSchedule/home.php');
		session_start();
		$ClassID=$_SESSION['ClassID'];	
		//ini_set('max_execution_time', 5); 
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
   	
   	$SQLSubjects = "SELECT * FROM assignment WHERE ClassID='$ClassID' AND 
   	SubjectID!='ASS' AND SubjectID!='CPL' AND SubjectID!='MUS' AND SubjectID!='PHE' 
   	AND SubjectID!='FAB' AND SubjectID!='CCA' AND SubjectID!='CHL' AND MergeInfo=''
   	order by SubjectID";
   		$SubjectResult = mysql_query($SQLSubjects);
   	$SubjectCount=1;
   	$TeacherCount=1;		
		while($db_field=mysql_fetch_assoc($SubjectResult)) {
			$Subjects[$SubjectCount]=$db_field['SubjectID'];
			echo $Subjects[$SubjectCount];			
			$SubjectCount=$SubjectCount+1;	
			$Teachers[$TeacherCount]=$db_field['TeacherID'];
			$TeacherCount=$TeacherCount+1;	
		}

		$SubjectInsertCount=1;
		$TeacherInsertCount=1;
		//$PeriodDay=1;

		$start_time=time();
		 
		while($SubjectInsertCount<$SubjectCount) {
			
			$GetSubjectPeriods = "SELECT * FROM assignment 
			WHERE ClassID='$ClassID' AND 
			SubjectID='$Subjects[$SubjectInsertCount]'";	
   				$PeriodTimeResult = mysql_query($GetSubjectPeriods);	

			while($db_field=mysql_fetch_assoc($PeriodTimeResult)) {
			
				$Periods=$db_field['Periods'];
				//echo $db_field['SubjectID'];				
			}

			$SumOfNonParallel="SELECT sum(Periods) as TotPer FROM `assignment` WHERE classID='$ClassID' AND IsFirstSubjectParallel=0 and MergeInfo='' OR (SubjectID='ASS' OR SubjectID='CPL' OR SubjectID='CCA')";
   				$SumOfNonParallelResult = mysql_query($SumOfNonParallel);	
			$SumOfParallel="SELECT sum(Periods) as TotPer FROM `assignment` WHERE classID='$ClassID' AND IsFirstSubjectParallel=1";
   				$SumOfParallelResult = mysql_query($SumOfParallel);	
			$TotalNonParallel=mysql_fetch_assoc($SumOfNonParallelResult);
				//echo $TotalNonParallel;
			$TotalParallel=mysql_fetch_assoc($SumOfParallelResult);
   		//echo "NON= ".$TotalNonParallel['TotPer'];
   		//echo "Par= ".$TotalParallel['TotPer'];
   		$Period=$TotalNonParallel['TotPer']+$TotalParallel['TotPer'];			
			$Remainder=$Period % 5;
			//echo "TOT= ".$Period;
				
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
			$PeriodCheck=0;
			
			$PeriodDay=1;	
			while ($PeriodDay<6) {
			//while($PeriodCheck<$Periods) {
				$CheckPeriod1 = "SELECT *  FROM assignment, periodassignment 
				WHERE assignment.TeacherID=periodassignment.TeacherID AND
				assignment.SubjectID=periodassignment.SubjectID AND
				assignment.ClassID=periodassignment.ClassID AND
					PeriodDay='$PeriodDay' AND (periodassignment.ClassID='$ClassID' OR periodassignment.ClassID='ALL') AND MergeInfo=''";	
   				$CheckDayFullResult1 = mysql_query($CheckPeriod1);	
  			
  				$CheckPeriod2 = "SELECT distinct periodassignment.SubjectID  FROM assignment, periodassignment 
				WHERE assignment.TeacherID=periodassignment.TeacherID AND
				assignment.SubjectID=periodassignment.SubjectID AND
				assignment.ClassID=periodassignment.ClassID AND
					PeriodDay='$PeriodDay' AND (periodassignment.ClassID='$ClassID' OR periodassignment.ClassID='ALL') AND MergeInfo!=''";	
   				$CheckDayFullResult2 = mysql_query($CheckPeriod2);	
   				
				$db_field1=mysql_num_rows($CheckDayFullResult1);
				$db_field2=mysql_num_rows($CheckDayFullResult2);
				//echo $db_field1."<br>";
				//echo $db_field2."<br>";
				if ($db_field2>0) 
					$total=$db_field1+2;				
				
				 if($total<$max[$PeriodDay-1]) {	
				if ($PeriodCheck<$Periods) {
						$PeriodRowCheck=1;
						$TeacherRowCheck=1;
						$Period2RowCheck=1;
						$Teacher2RowCheck=1;
						
						while (($PeriodRowCheck>0)||($TeacherRowCheck>0)||($Period2RowCheck>0)||($Teacher2RowCheck>0)) { 
						 //if ((time() - $start_time) > 10)
						 		//header("location: home.php");
						$maximum=$max[$PeriodDay-1]-1;
						echo "Max = ".$maximum."<br>";
						//do {
							$PeriodTime=rand(1, $maximum);
							echo $PeriodTime."<br>";
						//} while($PeriodTime%2!=0); 
									
							$CheckPeriodTimeClass = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' 
				AND PeriodDay='$PeriodDay' AND (ClassID='$ClassID' OR ClassID='ALL')";	
				echo $CheckPeriodTimeClass."<br>";
   				$PeriodTimeResult = mysql_query($CheckPeriodTimeClass);	
				$PeriodRowCheck = mysql_num_rows($PeriodTimeResult);
			
				$CheckPeriodTimeTeacher = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' 
				AND PeriodDay='$PeriodDay' AND TeacherID='$Teachers[$TeacherInsertCount]'";	 
				echo $CheckPeriodTimeTeacher."<br>";
   				$TeacherTimeResult = mysql_query($CheckPeriodTimeTeacher);
				$TeacherRowCheck = mysql_num_rows($TeacherTimeResult);	
				echo $PeriodRowCheck."<br>";
							echo $TeacherRowCheck."<br>";
							$CheckAfterPeriodtTime= $PeriodTime+1;							
							
							$CheckPeriodTimeClass2 = "SELECT * FROM periodassignment WHERE PeriodTime='$CheckAfterPeriodtTime' 
							AND PeriodDay='$PeriodDay' AND (ClassID='$ClassID' OR ClassID='ALL')";	
							echo $CheckPeriodTimeClass2."<br>";
   							$PeriodTime2Result = mysql_query($CheckPeriodTimeClass2);	
							$Period2RowCheck = mysql_num_rows($PeriodTime2Result);									
			
								
							
							$CheckPeriodTimeTeacher2 = "SELECT * FROM periodassignment WHERE PeriodTime='$CheckAfterPeriodtTime' 
							AND PeriodDay='$PeriodDay' AND TeacherID='$Teachers[$TeacherInsertCount]'";	
							echo $CheckPeriodTimeTeacher2."<br>"; 
   							$TeacherTime2Result = mysql_query($CheckPeriodTimeTeacher2);
							$Teacher2RowCheck = mysql_num_rows($TeacherTime2Result);			
					echo $Period2RowCheck."<br>";
							echo $Teacher2RowCheck."<br>";
						} 
						
				
					 //1 period assignment
					
						//2 periods assignment
						//else {
							
							
							
																				
							
							//if(($PeriodRowCheck==0)&&($Period2RowCheck==0)&&($TeacherRowCheck==0)&&($TeacherRow2Check==0)){
								for($Time=$PeriodTime;$Time<($PeriodTime+2);$Time++) {
									$SQLWriteSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      								VALUES ('$Subjects[$SubjectInsertCount]','$ClassID','$Teachers[$TeacherInsertCount]',$Time,$PeriodDay)";        
      							$result = mysql_query($SQLWriteSubject);  
      							echo $SQLWriteSubject."<br>";
      							
								}								
							}
												
							
						
						//echo $SubjectInsertCount;
						//$PreviousTime=$PeriodTime;
						//if(($PeriodRowCheck==0)&&($TeacherRowCheck==0)) {					
							
						}
							$PeriodCheck=$PeriodCheck+2;
								
							
						
						
					
						//if($PeriodDay==5) {
							//if($SubjectInsertCount!=$SubjectCount) {
								//$PeriodDay=1;
							//}
						//}					
					
						//if($PreviousTime==$PeriodTime) {
						 	
						 
						 	$PeriodDay=$PeriodDay+1;
						}
						$SubjectInsertCount=$SubjectInsertCount+1;
						$TeacherInsertCount=$TeacherInsertCount+1;		

					}
					
				//$SubjectInsertCount;
			//}							
						//	if($PeriodDay==5) {
						//		$PeriodDay = $PeriodDay + 1 ;		
						//		$RemainingPeriodCheck=0;								
						//	if($RemainingPeriods>0) {
						//		while($RemainingPeriodCheck<=$RemainingPeriods) {

							
							
					////			$CheckPeriodTimeClass = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$ClassID'";	
   				//				$PeriodTimeResult = mysql_query($CheckPeriodTimeClass);	
					//			$PeriodRowCheck = mysql_num_rows($PeriodTimeResult);
			
					//			$CheckPeriodTimeTeacher = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND TeacherID='$Teachers[$TeacherInsertCount]'";	 
   				//				$TeacherTimeResult = mysql_query($CheckPeriodTimeTeacher);
					//			$TeacherRowCheck = mysql_num_rows($TeacherTimeResult);
					//			if(($PeriodRowCheck==0)&&($TeacherRowCheck==0)) {					
					//				$SQLWriteSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      			//					VALUES ('$Subjects[$SubjectInsertCount]','$ClassID','$Teachers[$TeacherInsertCount]','$PeriodTime','$PeriodDay')";        
      				//			$result = mysql_query($SQLWriteSubject);  

					//				$RemainingPeriodCheck=$RemainingPeriodCheck+1;
	
					//			}else{
					//				$PeriodTime=rand(1, 15);
					//			}								
					//		}
   				//		}
   				//	}			

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