<?php
		session_start();
		$ClassID=$_SESSION['ClassID'];	
		
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);			
	
		$OverlapError='';				
		$_SESSION["$ClassID"]=${$ClassID};
		
		$PrioritySubject=$_POST["PrioritySubject"];		
		$PeriodTime=$_POST["PeriodTime"];
		$PeriodDay=$_POST["PeriodDay"];
		
		$SQLclass = "SELECT * FROM assignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$ClassID' OR IsSubjectForAllClasses='1'";
   		$ParallelSubjectResult = mysql_query($SQLclass);

   	$SQLteacher = "SELECT * FROM assignment WHERE MergeInfo='$PrioritySubject' AND ClassID='$ClassID'";
   		$ParallelTeacherResult = mysql_query($SQLteacher);
		$Teachers='';
   	while($db_field=mysql_fetch_assoc($ParallelTeacherResult)) {
			$Teachers=$Teachers.$db_field['TeacherID'];
		}
		   		
		$FirstTeacher=substr($Teachers,0,3);
 		$SecondTeacher=substr($Teachers,3,3);
 		$ThirdTeacher=substr($Teachers,6,6);
 		
   		while($db_field=mysql_fetch_assoc($ParallelSubjectResult)) {		
				$ParallelTime = $db_field['PeriodTime'];
				$ParallelDay = $db_field['PeriodDay'];
				
			//echo $Teachers;

			//echo $ParallelTime;
			//echo $ParallelDay;

				if($ParallelTime != $PeriodTime){ /* Write PeriodDay and PeriodTime only if the cell in the Time Table is not occupied in the specified Period Time and Day */
					if($ParallelDay != $PeriodDay) {
						$SQLwrite = "UPDATE assignment SET PeriodTime='$PeriodTime', PeriodDay='$PeriodDay' 
							WHERE MergeInfo='$PrioritySubject' AND ClassID='$ClassID'";       
      					$result = mysql_query($SQLwrite);
      					${$ClassID}[$PeriodTime][$PeriodDay]=$PrioritySubject.'-'.$FirstTeacher.'-'.$SecondTeacher.'-'.$ThirdTeacher;			
							$_SESSION["$ClassID"]=${$ClassID}[$PeriodTime][$PeriodDay];					
					}		
				}
			
				if($PeriodDay == $ParallelDay){ /* Write PeriodDay and PeriodTime only if the cell in the Time Table is not occupied in the specified Period Time and Day */
					if($PeriodTime != $ParallelTime){
						$SQLwrite = "UPDATE assignment SET PeriodTime='$PeriodTime', PeriodDay='$PeriodDay' 
							WHERE MergeInfo='$PrioritySubject' AND ClassID='$ClassID'";       
      					$result = mysql_query($SQLwrite);	
      					${$ClassID}[$PeriodTime][$PeriodDay]=$PrioritySubject.'-'.$FirstTeacher.'-'.$SecondTeacher.'-'.$ThirdTeacher;						
							$_SESSION["$ClassID"]=${$ClassID}[$PeriodTime][$PeriodDay];					
					}
					else {
						$OverlapError="There is already a subject at Day ".$PeriodDay." during Period ".$PeriodTime;				
					}		
				}
			}	
?>	
<html>
<body>
<center>
<h2>Choose a Period Time and Day for a Priority Subject</h2>
<br>
<table>
<form action="PrioritySubjects4.php" method="post">
	<tr>	
		<td>
			Priority Subject:
		</td>	
		<td>
			<select name='PrioritySubject'>
				<option value="CHL">CHL</option>
				<option value="PE">PE</option>
				<option value="MUS">MUS</option>
			</select></td>		
	</tr>
	<tr>
		<tr>			
			<td>			
			Period Time:
			</td><td><select name='PeriodTime'>
			
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

			</select></td></tr></	
			<tr>
<td>		Day:</td><td><select name='PeriodDay'>
					   <option value="1">Monday</option>
					   <option value="2">Tuesday</option>
					   <option value="3">Wednesday</option>
					   <option value="4">Thursday</option>
					   <option value="5">Friday</option>
			</select></td>
			</tr>
<tr>
	<td>
		<input type="submit" value="Submit">
	</td>
</tr>
</table>
</form>