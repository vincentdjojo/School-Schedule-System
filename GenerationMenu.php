<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		

		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
		
		$method = $_SERVER['REQUEST_METHOD'];
		
		if($method == 'POST') {
			$ClassID=$_POST['ClassID'];
		}
		else{
			$ClassID=$_SESSION["ClassID"];
	   }
?><html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Schedule Generation</title>
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
	<h1>Schedule Generation</h1>
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width: 100%; height: 100%; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">

				<tr>
				<td style="text-align: center;">
						<div style="color: #603813;">
							<h2>Manual Generation</h2>
						</div>
						<a href="PrioritySubjectMenu.php"><img style="border: 0px solid ; width: 328px; height: 326px;" alt="" src="PrioritySubject.png"></a><br>
				</td>
            <td style="text-align: center;">
					<td style="text-align: center;">
						<div style="color: #603813;">
							<h2>Automatic Generation</h2>
						</div>
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
						

   				$RowsGet = "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND SubjectID='FAB'";
						$RowsGetResult = mysql_query($RowsGet); 			
					$num_rows4 = mysql_num_rows($RowsGetResult);		//check number of the parallel subject exist
   				$SQLPeriods3 = "SELECT * FROM assignment WHERE SubjectID='FAB' AND ClassID='$ClassID'";
   					$PeriodsResult3 = mysql_query($SQLPeriods3);
   				while($db_field=mysql_fetch_assoc($PeriodsResult3)) {
   				$Periods3=$db_field['Periods'];
   				}	
					
					if($num_rows4==$Periods3) {								
						
						?><a href="GenerateSchedule.php">
		<?php 
					}
				}
			
			
		?>						
						<img style="border: 0px solid ; width: 328px; height: 326px;" alt="" src="generate.png"></a><br>
				</td>
				</tr>

				<tr>
					<td align='center'>
		<?php 		

			if(($num_rowsparallel==$totalparallel)&&($num_rowsparallel!=0)&&($totalparallel!=0)) {
				if($num_rows2==$Periods) {	
					//if($num_rows3==$Periods2){
						if($num_rows4==$Periods3) {					
		?>
					 		<img src="check-mark.png " height="80" width="80" >	
		<?php 
						}else {
					 		echo '<img src="uncheck.png " height="80" width="80" >';								
						}
					}else {
				 		echo '<img src="uncheck.png " height="80" width="80" >';							
					}
				}else {
				 		echo '<img src="uncheck.png " height="80" width="80" >';			
				}
		//	}else{
			//	 		echo '<img src="uncheck.png " height="80" width="80" >';					
		//	}		
		?>				
					</td>
					<td align='center'>
						<a href="SelectClass.php"><img style="width: 100px; height: 100px;" alt="" src="back-icon-clipart-1.png"></a>			
					</td>
					<td style="text-align: center;">
		<?php 
			if(($num_rowsparallel==$totalparallel)&&($num_rowsparallel!=0)&&($totalparallel!=0)) {
				if($num_rows2==$Periods) {	
					//if($num_rows3==$Periods2){
						if($num_rows4==$Periods3) {					
		?>
						<a href="SelectClass.php">
						<img style="width:  height="80" width="80"" alt="" src="this.png"></a>
		<?php 
						}else {
					 		echo '<img src="cross.png " height="80" width="80" >';								
						}
					}else {
				 		echo '<img src="cross.png " height="80" width="80" >';							
					}
				}else {
				 		echo '<img src="cross.png " height="80" width="80" >';			
				}
		//	}else{
			//	 		echo '<img src="cross.png " height="80" width="80" >';					
			//}		
		?>
					</td>

				</tr>

			</table>
		</td>
	</tr>

</table>
</div>


</body>
</html>