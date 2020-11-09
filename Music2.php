<?php
	session_start();
	$user_name = "root";
	$pass_word = "";
	$database = "schoolschedule";
	$server = "127.0.0.1";
	
	$PrioritySubject='MUS';
	$Grade=$_POST["Grade"];	
	$PeriodTime=$_POST["PeriodTime"];
	$PeriodDay=$_POST["PeriodDay"];
	$Periods=$_POST['Periods'];
	$db_handle = mysql_connect($server,$user_name,$pass_word);
	$db_found = mysql_select_db($database,$db_handle);	
	$ErrorMessage="";
	$InsertionCheck="";
	$OverlapError="";

		for ($time=1;$time<17;$time++) {
     		for($day=1;$day<6;$day++){
              $TimeTable[$time][$day]="";
			}
		}	
   $SQLclass = "SELECT * FROM class WHERE ClassID LIKE '%$Grade%'";
   	$classresult = mysql_query($SQLclass);		
   	$num_rows = mysql_num_rows($classresult);	
   	while($db_field=mysql_fetch_assoc($classresult)) {	
			$ClassID=$db_field['ClassID'];		    
		
			$SQLwrite = "INSERT INTO assignment (TeacherID,SubjectID,ClassID,Periods)
       		VALUES ('MUS','MUS','$ClassID','$Periods')"; //Assign music to assignment table        
      	$result = mysql_query($SQLwrite);
 	  	
 	$PresenceCheckMus = "SELECT * FROM periodassignment WHERE SubjectID = 'MUS' AND ClassID='$ClassID'";	
 			$result = mysql_query($PresenceCheckMus); 
 			$num_rows = mysql_num_rows($result);
 			if($num_rows==0) {	
			//$SQLCheck = "SELECT * FROM periodassignment WHERE (PeriodTime = '$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$ClassID') OR (PeriodTime = '$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='ALL') OR (PeriodTime = '$PeriodTime' AND PeriodDay='$PeriodDay')"; //Check if there is a subject in the PeriodTime and PeriodDay
			//$result = mysql_query($SQLCheck);
   		//$num_rows = mysql_num_rows($result);
     			$num_rows2=0;
     			$time=$PeriodTime;
				$PeriodTest=$PeriodTime+$Periods;				
				
				 while (($num_rows2 == 0) && ($time<$Periods+$PeriodTime)){
					$SQLCheck = "SELECT * FROM periodassignment WHERE (PeriodTime = '$time' AND PeriodDay='$PeriodDay' AND ClassID='$ClassID') OR (PeriodTime = '$time' AND PeriodDay='$PeriodDay' AND ClassID='ALL')"; //Check if there is a subject in the PeriodTime and PeriodDay
						$result = mysql_query($SQLCheck);
   					$num_rows2 = mysql_num_rows($result);	
						$time=$time+1;		
				}
				if($num_rows2==0) {	
				$SQLPeriodCheck = "SELECT * FROM periodassignment WHERE SubjectID='$PrioritySubject' AND ClassID='$ClassID'"; //Check if there is a subject in the PeriodTime and PeriodDay
					$result = mysql_query($SQLPeriodCheck);
   				$num_rows = mysql_num_rows($result);
   				if($num_rows < $Periods) {
   					if(($Periods+$num_rows)<=$Periods) {
     						$PeriodTest=$PeriodTime+$Periods;

								for($x=$PeriodTime;$x<$PeriodTest;$x++) {   			
   								$SQLGetPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$PrioritySubject' AND ClassID='$ClassID'";
   									$GetPrioritySubjectResult = mysql_query($SQLGetPrioritySubject);	
	
   							while($db_field=mysql_fetch_assoc($GetPrioritySubjectResult)) {
									$TeacherOne=$db_field['TeacherID'];   						
   							}


								$SQLWritePrioritySubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay) 
      							VALUES ('$PrioritySubject','$ClassID','$TeacherOne','$x','$PeriodDay')"; //Assign music to periodassignment table
      							$result = mysql_query($SQLWritePrioritySubject);      					
								}

						} 
					else {
						$ErrorMessage='Subject has reached its maximum number of periods';
					}
		
				} else {
					$ErrorMessage='Subject has reached its maximum number of periods';				
					}

			}
			else {
					$ErrorMessage='There is a subject overlapping';		
			}
	
	}else {
		$ErrorMessage='Music has already been assigned for that grade';	
	 }
}
?>
<center>
<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Choose a Period Time and Day for Music</title>
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
<h1>Choose a Period Time and Day for Music</h1>
<div style="text-align: center; font-family: Arial; font-size:100%; ">
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<img src="music.png"><img src="baka2.png" alt="" width="162" height="224">
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
<table style="height: 20px;" align="center" bgcolor="">	
<form action="Music2.php" method="post">
	<tr>	
		<td>
			Subject:
		</td>	
		<td>
			Music
		</td>
		<td>
	
		</td>		
	</tr>
	<tr>
		<td colspan="2">
			<font color='red' size='0.5'><?php echo $ErrorMessage;?><br><?php echo $OverlapError; ?></font>
			<font color='green' size='0.5'><?php echo $InsertionCheck; ?></font>			
		</td>	
	</tr>
	<tr>
	<tr>
		<td>
				ClassID:
	 	</td>	
	 	<td>
	 		<select name='Grade'>
				<option value="SC1">SC1</option>
				<option value="SC2">SC2</option>
				<option value="SC3">SC3</option>
				<option value="SC4">SC4</option>
				<option value="JC1">JC1</option>
				<option value="JC2">JC2</option>
			</select>		
		</td>	
	</tr>
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

			</select></td></tr></	
	<tr>
		<td>		Period Day:</td><td><select name='PeriodDay'>
					   <option value="1">Monday</option>
					   <option value="2">Tuesday</option>
					   <option value="3">Wednesday</option>
					   <option value="4">Thursday</option>
					   <option value="5">Friday</option>
			</select></td>
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
			<input type="hidden" name="PrioritySubject" value="MUS">
		</td>
		<td>
			<?php
		$SQLMusAss = "SELECT * FROM assignment WHERE SubjectID='MUS'";
   		$SQLMusAssResult = mysql_query($SQLMusAss);
  		$RowsOfMusinAss = mysql_num_rows($SQLMusAssResult);

		$SQLClass = "SELECT * FROM class WHERE ClassID<>'ALL'";
   		$SQLClassResult = mysql_query($SQLClass);
  		$RowsOfClasses = mysql_num_rows($SQLClassResult);  
	
  		if($RowsOfClasses==$RowsOfMusinAss) {				
			?>	
			<a href="ScheduleGeneration.php"><button type="button">Done</button></a>				
		</td>
	<?php 
	}
   	$SQLPeriods = "SELECT * FROM assignment WHERE SubjectID='MUS' AND ClassID='ALL'";
   		$PeriodsResult = mysql_query($SQLPeriods);
   	
   	while($db_field=mysql_fetch_assoc($PeriodsResult)) {
			$TeacherID=$db_field['TeacherID'];
			$SubjectID=$db_field['SubjectID'];   		
   		$Periods=$db_field['Periods'];
   		$MergeInfo=$db_field['MergeInfo'];
   		$IsFirstSubjectParallel=$db_field['IsFirstSubjectParallel'];
   		$IsSubjectForAllClasses=$db_field['IsSubjectForAllClasses'];
   	}	
	?>
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

<h2><center>Schedule</center></h2>
<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 80%;" align="center" bgcolor="#FFFFFF">
	<?php
	
				for ($x=1;$x<17;$x++) { //Store subjects in array TimeTable
     				for($y=1;$y<6;$y++){
   					$SQLGetSubject = "SELECT * FROM periodassignment WHERE (PeriodTime = '$x' AND PeriodDay = '$y' OR ClassID='ALL' OR TeacherID='ALL') ";
							$GetSubjectResult = mysql_query($SQLGetSubject); 
						while($db_field=mysql_fetch_assoc($GetSubjectResult)) {
								$TimeTable[$db_field["PeriodTime"]][$db_field["PeriodDay"]]=$db_field["SubjectID"].'-'.$db_field['ClassID'];
						
   					      
               }
            }
            }
        
				for ($x=1;$x<17;$x++) { //Store parallel subjects and Music in array TimeTable
     				for($y=1;$y<6;$y++){            
   						$SQLGetPeriodMergedSubject = "SELECT * FROM periodassignment WHERE (PeriodTime='$x' AND PeriodDay='$y') ";
								$GetPeriodMergedSubjectResult = mysql_query($SQLGetPeriodMergedSubject); 			
							$num_rows = mysql_num_rows($GetPeriodMergedSubjectResult);	
							if($num_rows>1) {
   							$SQLGetSubject = "SELECT * FROM periodassignment WHERE (PeriodTime = '$x' AND PeriodDay = '$y') ";
									$GetSubjectResult = mysql_query($SQLGetSubject); 															
									$TimeTable[$x][$y]='';								
								while($db_field=mysql_fetch_assoc($GetSubjectResult)){
									$subject=$db_field['SubjectID'];					
									if($subject=='MUS') {
										
										$TimeTable[$x][$y]='MUS'.'-'.substr($db_field['ClassID'], 0, 3);;									
									}else if($TimeTable[$x][$y]=="") {
										$TimeTable[$x][$y]=$db_field["SubjectID"];
									}else 										
										if(($subject!='MUS')&&($subject!='ASS')&&($subject!='CPL')) {
											$TimeTable[$x][$y]=$TimeTable[$x][$y].'-'.$db_field["SubjectID"];
										}
									}
								}
   							$SQLGetTeacher = "SELECT * FROM periodassignment WHERE ( PeriodTime = '$x' AND PeriodDay = '$y') ";
									$GetTeacherResult = mysql_query($SQLGetTeacher); 	
								while($db_field=mysql_fetch_assoc($GetTeacherResult)){
										$subject=$db_field['SubjectID'];										
										if(($subject!='MUS')&&($subject!='ASS')&&($subject!='CPL')) {
											$TimeTable[$x][$y]=$TimeTable[$x][$y].'-'.$db_field["SubjectID"];
										}
								}									
															
					}								
				}
																				
					 
		echo "<tr><td>"."</td>";
		echo "<td align='center'>Mon</td><td align='center'>Tue</td><td align='center'>Wed</td><td align='center'>Thu</td><td align='center'>Fri</td>";
		echo "<tr><td></td><td align='center' colspan='5'>Assembly</td></tr>";
		echo "<tr>";
		for($time=1;$time<5;$time++) {
			echo "<td align='center'>".$time."</td>";
			for($day=1;$day<6;$day++){
				echo "<td align='center'>".$TimeTable[$time][$day]."</td>";
			}
			echo "</tr>";
		}
		echo "<tr><td></td><td colspan='5' align='center'>Break</td></tr>";
		for($time=5;$time<9;$time++){
			echo "<tr><td align='center'>".$time."</td>";	
			for($day=1;$day<6;$day++){
				echo "<td align='center'>".$TimeTable[$time][$day]."</td>";
			}
			echo "</tr>";
		}
		echo "<tr><td></td><td colspan='5' align='center'>Lunch</td></tr>";
		for($time=9;$time<16;$time++){
			echo "<tr><td align='center'>".$time."</td>";	
			for($day=1;$day<6;$day++){
				echo "<td align='center'>".$TimeTable[$time][$day]."</td>";
			}
			echo "</tr>";
		}
	?>
</table>
</body>
</html>