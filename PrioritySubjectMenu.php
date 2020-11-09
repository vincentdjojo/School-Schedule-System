<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
			
		$SQLparallelsubject = "SELECT * FROM subject WHERE Category = 'p'"; /* Select parallel subjects for drop down list */
		$parallelsubjectresult=mysql_query($SQLparallelsubject);

		for ($time=1;$time<17;$time++) {
     		for($day=1;$day<6;$day++){
              $TimeTable[$time][$day]="";
			}
		}	

		$ClassID=$_SESSION['ClassID'];

		@$UserName=$_SESSION['UserName'];
		@$TeacherID=$_SESSION['ID'];					
		$ClassID=$_SESSION['ClassID'];
		
		$SQLPrioritySubject = "SELECT * FROM assignment WHERE (IsFirstSubjectParallel = '1' OR SubjectID='FAB' OR SubjectID='PHE') AND ClassID='$ClassID'";
			$SQLPrioritySubjectResult=mysql_query($SQLPrioritySubject);

		$SQLClass = "SELECT * FROM class WHERE ClassID!='ALL'AND ClassID!='$ClassID'";
			$SQLClassResult=mysql_query($SQLClass);

?>
<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Manual Generation</title>
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
<h1>Manual Generation</h1>
<div style="text-align: center; font-family: Arial; font-size:100%; ">
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<!-- <img src="teacherassignment.png"><img src="baka2.png" alt="" width="162" height="224"> -->
					<table background="backgroundforcontact2.png" style="background-size: 100% 100%; width:80%; height:475px;">
						<tr>
							<td align='center'>
								<table background="backgroundforcontact3.png" style=" height:90%; width: 95%; background-size: 100% 100%; ";>
									<tr>
										<td align='center'>									
											
												<img src="575346.gif" width="68" height="76">
											<table background="backgroundforcontact4.png "style=" height:80%; width: 85%; background-size: 100% 100%;";>
												<tr>
													<td align='center'>
														<table style="height: 20px;" align="center" bgcolor="">	
														<form action="PrioritySubjectMenu2.php" method="post">
														<tr>	
															<td>
																Priority Subject:
															</td>	
															<td>
																<select name='PrioritySubject'>
																<?php
																	while ($row = mysql_fetch_assoc($SQLPrioritySubjectResult)) {
																		$IsFirstSubjectParallel=$row['IsFirstSubjectParallel'];	
																		echo $row['IsFirstSubjectParallel'];
																		if($IsFirstSubjectParallel==1) {
																			$MergeInfo=$row['MergeInfo'];
																			$SQLCheckParallelSubject = "SELECT * FROM assignment WHERE MergeInfo='$MergeInfo' AND ClassID='$ClassID' AND IsFirstSubjectParallel='1'";
																				$SQLCheckParallelSubjectResult=mysql_query($SQLCheckParallelSubject);
																	   	while($db_field=mysql_fetch_assoc($SQLCheckParallelSubjectResult)) {	
																	   		$Periods=$db_field['Periods'];
																	   		$Subject=$db_field['SubjectID'];
																	  		}
																	  		$SQLCheckParallelSubjectPeriodAssignment = "SELECT * FROM periodassignment WHERE SubjectID='$Subject' AND ClassID='$ClassID'";
																	  			$SQLCheckParallelSubjectPeriodAssignmentResult=mysql_query($SQLCheckParallelSubjectPeriodAssignment);
   	 																	$ParallelSubjectRows = mysql_num_rows($SQLCheckParallelSubjectPeriodAssignmentResult);
																			//echo $SQLCheckParallelSubjectPeriodAssignment;
   	 																	if($ParallelSubjectRows!=$Periods) {
   	 														?>
   	 														<option value="<?php echo $row['MergeInfo'];?>"><?php echo $row['MergeInfo']; ?></option>   	 																	
   	 														<?php 
																			}
																		}
																		else {
																			$Subject=$row['SubjectID'];
																			
																			$SQLCheckNonParallelSubject = "SELECT * FROM assignment WHERE SubjectID='$Subject' AND ClassID='$ClassID'";
																				$SQLCheckNonParallelSubjectResult=mysql_query($SQLCheckNonParallelSubject);
																			$SQLCheckNonParallelSubjectResult;
																	   	while($db_field=mysql_fetch_assoc($SQLCheckNonParallelSubjectResult)) {	
																	   		$Periods=$db_field['Periods'];
																	   		$Subject=$db_field['SubjectID'];
																	  		}
	
																	  		$SQLCheckNonParallelSubjectPeriodAssignment = "SELECT * FROM periodassignment WHERE SubjectID='$Subject' AND ClassID='$ClassID'";
																	  			$SQLCheckNonParallelSubjectPeriodAssignmentResult=mysql_query($SQLCheckNonParallelSubjectPeriodAssignment);
   	 																	$NonParallelSubjectRows = mysql_num_rows($SQLCheckNonParallelSubjectPeriodAssignmentResult);
   	 																	if($NonParallelSubjectRows!=$Periods) {
   	 																		
   	 																	
																	 	
																	 																			   	 														
   	 														?>
   	 														<option value="<?php echo $row['SubjectID'];?>"><?php echo $row['SubjectID'];?></option>
																<?php				
																			}
																		}
																	}	
																?>
																</select>
															</td>		
														</tr>
														<tr>
															<td colspan="2">
															
															</td>														
														</tr>
														
														<tr>
															<td>
																Merge With:															
															</td>
															<td>
																<select name='MergeWith'>
																	<option value=""></option>	
																	<?php while ($row = mysql_fetch_assoc($SQLClassResult)) {	?>
   	 																<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
   	 																																				
																	<?php }?>																
																</select>
																<select name='MergeWith2'>	
																	<option value=""></option>	
																	<?php 
																	$SQLClass = "SELECT * FROM class WHERE ClassID!='ALL' AND ClassID!='$ClassID'";
																		$SQLClassResult=mysql_query($SQLClass);																	
																	while ($row = mysql_fetch_assoc($SQLClassResult)) {	?>
   	 																<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
   	 																																				
																	<?php }?>																
																</select>
																<select name='MergeWith3'>	
																	<option value=""></option>	
																	<?php 
																	$SQLClass = "SELECT * FROM class WHERE ClassID!='ALL' AND ClassID!='$ClassID'";
																		$SQLClassResult=mysql_query($SQLClass);																	
																	while ($row = mysql_fetch_assoc($SQLClassResult)) {	?>
   	 																<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
   	 																																				
																	<?php }?>															
																</select>
																<select name='MergeWith4'>	
																	<option value=""></option>	
																	<?php 
																	$SQLClass = "SELECT * FROM class WHERE ClassID!='ALL' AND ClassID!='$ClassID'";
																		$SQLClassResult=mysql_query($SQLClass);																	
																	while ($row = mysql_fetch_assoc($SQLClassResult)) {	?>
   	 																<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
   	 																																				
																	<?php }?>																																																																																
															</td>														
														</tr>
														<tr>
															<td colspan="2">
															
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
   	 															<option value="13">13</option>
   	 															<option value="14">14</option>
																</select>
															</td>
														</tr>	
														<tr>
															<td>		
																Period Day:
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
															<td colspan="2">
															
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

					   										</select>
					   									</td>
														</tr>
														<tr>
															<td>
						<?php 
			$SQLparallelsubject = "SELECT * FROM assignment WHERE IsFirstSubjectParallel = '1' AND ClassID='$ClassID'"; //Get Periods of Parallel Subject from the table assignment
			$parallelsubjectresult=mysql_query($SQLparallelsubject);
			$totalparallel=0;
			$num_rowsparallel=0;
			while ($row = mysql_fetch_assoc($parallelsubjectresult)) {
				$totalparallel=$totalparallel+$row['Periods'];
				$subject=$row["SubjectID"];
				$SQLPeriodAssignment = "SELECT * FROM periodassignment WHERE SubjectID = '$subject' AND ClassID='$ClassID'"; //Get SubjectID of Parallel Subject from the table periodassignment
					$SQLPeriodAssignmentResult=mysql_query($SQLPeriodAssignment);			
				$num_rowsparallel = mysql_num_rows($SQLPeriodAssignmentResult);
			}

			if(($num_rowsparallel==$totalparallel)&&($num_rowsparallel!=0)&&($totalparallel!=0)) {
   		$RowsGet = "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND SubjectID='PHE'";
				$RowsGetResult = mysql_query($RowsGet); 			
			$num_rows2 = mysql_num_rows($RowsGetResult);		//check number of the parallel subject exist
   		$SQLPeriods = "SELECT * FROM assignment WHERE SubjectID='PHE' AND ClassID='$ClassID'";
   			$PeriodsResult = mysql_query($SQLPeriods);
   		while($db_field=mysql_fetch_assoc($PeriodsResult)) {
   			$Periods=$db_field['Periods'];
   		}
				if($num_rows2==$Periods) {		
   			//	$RowsGet = "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND SubjectID='LIS'";
					//	$RowsGetResult = mysql_query($RowsGet); 			
				//	$num_rows3 = mysql_num_rows($RowsGetResult);		//check number of the parallel subject exist
   			//	$SQLPeriods2 = "SELECT * FROM assignment WHERE SubjectID='LIS' AND ClassID='$ClassID'";
   			//	$PeriodsResult2 = mysql_query($SQLPeriods2);
   			//	while($db_field=mysql_fetch_assoc($PeriodsResult2)) {
   			//		$Periods2=$db_field['Periods'];
   				}							
					//if($num_rows3==$Periods2) {
   					$RowsGet = "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND SubjectID='FAB'";
							$RowsGetResult = mysql_query($RowsGet); 			
						$num_rows4 = mysql_num_rows($RowsGetResult);		//check number of the parallel subject exist
   					$SQLPeriods3 = "SELECT * FROM assignment WHERE SubjectID='FAB' AND ClassID='$ClassID'";
   						$PeriodsResult3 = mysql_query($SQLPeriods3);
   					while($db_field=mysql_fetch_assoc($PeriodsResult3)) {
   					$Periods3=$db_field['Periods'];
   					}	
						
						if($num_rows4==$Periods3) {								
						
						?>															
										
		<?php 
						}else{
						echo '<input type="submit" value="Submit">';
						}
					}else{
						echo '<input type="submit" value="Submit">';
					}


		?>																		
															</td>
															<td>
																<a href="GenerationMenu.php"><button type="button">Return</button></a>																
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
		</td>
		</form>
		</td>
	</tr>
</table>
</table>	
<h2><center><?php echo 'Current Schedule: '.$ClassID.' ' ?></center></h2>
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

		echo "<tr><td align='center'>".$ClassID."</td>";
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