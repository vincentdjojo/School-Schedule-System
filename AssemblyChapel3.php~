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
	$AssemblyPeriodTime = $_POST['AssemblyPeriodTime'];
	$AssemblyDay = $_POST['AssemblyDay'];						
		
		//echo $_POST['PeriodTime']." ".$_POST['PeriodDay']; 		
		//echo $PrioritySubject;
		//echo $AssemblyPeriodTime;
		//echo	$AssemblyDay;
		
	$SQLclass = "SELECT * FROM assignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' OR SubjectID='CPL'";
   	$ParallelSubjectResult = mysql_query($SQLclass);
		$num_rows = mysql_num_rows($ParallelSubjectResult);
	//$SQL = "SELECT * FROM assignment WHERE PeriodTime = '$PeriodTime' AND PeriodDay='$PeriodDay'"; /*Check if the subject 'Chapel' has been inserted into the database*/
	//	$result = mysql_query($SQL);
   //	$num_rows = mysql_num_rows($result);
   $ErrorMessage= "";
   $OverlapError = "";          
   
   		//while($db_field=mysql_fetch_assoc($ParallelSubjectResult)) {		
			//	$ParallelTime = $db_field['PeriodTime'];
			//	$ParallelDay = $db_field['PeriodDay'];
			//}
			if($num_rows>0){
				$ErrorMessage='There is already a subject on that PeriodTime and PeriodDay';	
			}
			else {
		$SQLWriteCpl = "INSERT INTO assignment (SubjectID,TeacherID,ClassID,IsFirstParallelSubject,IsSubjectForAllClasses, Periods) 
                                   VALUES ('$PrioritySubject','ALL','ALL','0','1','1')";   /* Insert the subject 'Cpl' into the table 'Assignment */      
                                   $result = mysql_query($SQLWriteCpl); 
		$SQLWriteCplIntoPeriodAssignment = "INSERT INTO periodassignment (SubjectID,TeacherID,ClassID,PeriodTime,PeriodDay) 
                                   VALUES ('$PrioritySubject','ALL','ALL','$PeriodTime','$PeriodDay')";   /* Insert the subject 'Cpl' into the table 'PeriodAssignment */      
                                   $result = mysql_query($SQLWriteAssIntoPeriodAssignment);  
          } 
			//echo $Teachers;

			//echo $ParallelTime;
			//echo $ParallelDay;

//				if($ParallelTime != $PeriodTime){ /* Write PeriodDay and PeriodTime only if the cell in the Time Table is not occupied in the specified Period Time and Day */
//					if($ParallelDay != $PeriodDay) {
//						$SQLWriteCPL = "INSERT INTO assignment (SubjectID,PeriodTime,PeriodDay) 
//    						VALUES ('$PrioritySubject','$PeriodTime','$PeriodDay')"; 						    
//            		$result = mysql_query($SQLWriteCPL);		
//					}		
//				}
			
//				if($PeriodDay == $ParallelDay){ /* Write PeriodDay and PeriodTime only if the cell in the Time Table is not occupied in the specified Period Time and Day */
//					if($PeriodTime != $ParallelTime){
//						$SQLWriteCPL = "INSERT INTO assignment (SubjectID,PeriodTime,PeriodDay) 
//     						VALUES ('$PrioritySubject','$PeriodTime','$PeriodDay')"; 						    
//           		$result = mysql_query($SQLWriteCPL);	
//					}
//					else {
//						$OverlapError="There is already a subject at Day ".$PeriodDay." during Period ".$PeriodTime;				
//					}		
//				}
//			}	
			                  
//   if($num_rows>0) {
//   	$ErrorMessage = "Chapel already taken";
//  }
//		else {
//			
//			if($PeriodDay == $AssemblyDay){    /*Check if the PeriodTime overlaps if the day is the same so that the subject 'Chapel' can be written on the same day*/
//				if($PeriodTime!=$AssemblyPeriodTime){ /* If PeriodTime is not the same, but PeriodDay is the same, then allow the subject 'CPL' to be written into the database */
//					$SQLWriteCPL = "INSERT INTO assignment (SubjectID,PeriodTime,PeriodDay) 
//    					VALUES ('$PrioritySubject','$PeriodTime','$PeriodDay')"; 						    
//            	$result = mysql_query($SQLWriteCPL);
//				}
//				else{
//					$OverlapError = 'The Period is overlapping at Day '.$AssemblyDay.' during '.' Period '.$AssemblyPeriodTime;		
//				}
//			}
//			
//			if($PeriodTime==$AssemblyPeriodTime){    /*Check if the PeriodTime overlaps if the day is the same so that the subject 'Chapel' can be written on the same day*/
//				if($PeriodDay != $AssemblyDay){		  /* If PeriodDay is not the same, but PeriodTime is the same, then allow the subject 'CPL'to be written into the database */
//					$SQLWriteCPL = "INSERT INTO assignment (SubjectID,PeriodTime,PeriodDay,IsSubjectForAllClasses) 
//     					VALUES ('$PrioritySubject','$PeriodTime','$PeriodDay','1')"; 						    
//           	$result = mysql_query($SQLWriteCPL);
//				}
//				else{
//					
//					$OverlapError = 'The Period is overlapping at Day '.$AssemblyDay.' during '.' Period '.$AssemblyPeriodTime;  		
//					
//				}
//			}							
		
//			if($PeriodDay!=$AssemblyDay){     /*If the PeriodTime and PeriodDay are not the same, the PeriodTime can be written into the database as both PeriodTime and PeriodDay do not overlap*/
//				if($PeriodTime!=$AssemblyPeriodTime){
//					$SQLWriteCPL = "INSERT INTO assignment (SubjectID,PeriodTime,PeriodDay,IsSubjectForAllClasses) 
//    					VALUES ('$PrioritySubject','$PeriodTime','$PeriodDay','1')"; 									  
//            	$result = mysql_query($SQLWriteCPL); 
//				}
//			}
//
//		}
?>
<center>
<h2>Choose a Period Time and Day for Chapel</h2>
<font color = "red">
	<?php// echo $OverlapError; ?>
</font>
<table>
<form action="AssemblyChapel3.php" method="post">
	<tr>	
		<td>
			Subject:
		</td>	
		<td>
			Chapel
		</td>
		<td>
			<font color="red"><?php echo $ErrorMessage; ?></font>		
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
		<td>
			<input type="hidden" name="PrioritySubject" value="CPL">
			<input type="hidden" name="AssemblyPeriodTime" value="<?php $AssemblyPeriodTime ?>">
			<input type="hidden" name="AssemblyDay" value="<?php $AssemblyDay ?>">
			<input type="submit" value="Submit">
		</td>
		<td>
			<a href="AssemblyChapel4.php"><button type="button">Done</button>
		</td>
	</tr>
</table>
</form>
</center>
<?php
		$SQL = "SELECT * FROM periodassignment WHERE SubjectID = 'ASS'";
		$result=mysql_query($SQL);		
		
		while($db_field=mysql_fetch_assoc($result)) {
			$ASS=$db_field["SubjectID"];
			$AssPeriodDay=$db_field["PeriodDay"];
			$AssPeriodTime=$db_field["PeriodTime"];
		
				
?>

	<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center">
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

	<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center">
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