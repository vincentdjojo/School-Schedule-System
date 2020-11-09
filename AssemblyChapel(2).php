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

		$SQLWriteAss = "INSERT INTO assignment (SubjectID,PeriodTime,PeriodDay,IsSubjectForAllClasses) 
     		VALUES ('$PrioritySubject','$PeriodTime','$PeriodDay','1')";   /* Insert the subject 'Assembly' into the table 'Assignment */      
      	$result1 = mysql_query($SQLWriteAss); 	

?>

<center>
<h2>Choose a Period Time and Day for Assembly</h2>
<font color = "red">

</font>
<table>
<form action="AssemblyChapel(2).php" method="post">
	<tr>	
		<td>
			Subject:
		</td>	
		<td>
			Assembly
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
			<input type="hidden" name="PrioritySubject" value="ASS">
			<input type="submit" value="Submit">
		</td>
		<td>
			<a href="AssemblyChapel2.php"><button type="button">Done</button>
		</td>
	</tr>
</table>
</center>
</form>
<?php
		$ASSCPLResult = "SELECT * FROM assignment WHERE SubjectID = 'ASS'";
		$ASSCPL=mysql_query($ASSCPLResult);		
		
		while($db_field=mysql_fetch_assoc($ASSCPL)) {
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
?>
