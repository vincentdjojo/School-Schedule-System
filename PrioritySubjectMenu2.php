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
		$MergeWith=$_POST['MergeWith'];
		$MergeWith2=$_POST['MergeWith2'];
		$MergeWith3=$_POST['MergeWith3'];
		$MergeWith4=$_POST['MergeWith4'];				
		
		$ErrorMessage1=$ErrorMessage2=$ErrorMessage3='';		
		$OverlapError='';
		$ErrorMessage='';			
		$Error="";
		$CheckMergeAssignmentError=$CheckMergeAssignmentError2=$CheckMergeAssignmentError3=$CheckMergeAssignmentError4='';
		$CheckMergeAssignmentError=$CheckMerge2AssignmentError=$CheckMerge3AssignmentError=$CheckMerge4AssignmentError='';
		$CheckAssignmentError=$CheckAssignmentError2=$CheckAssignmentError3=$CheckAssignmentError4='';
		$SubjectLength=strlen($PrioritySubject); //Check Subject Length		
	
		for ($time=1;$time<17;$time++) {
     		for($day=1;$day<6;$day++){
              $TimeTable[$time][$day]="";
			}
		}

		$ClassError='';		
		
		if(($MergeWith==$MergeWith2)&&($MergeWith!='')&&($MergeWith2!='')) {
			$ClassError='You cannot have two or more classes which are the same';
		}
		if(($MergeWith==$MergeWith3)&&($MergeWith!='')&&($MergeWith3!='')) {
			$ClassError='You cannot have two or more classes which are the same';		
		}
		if(($MergeWith==$MergeWith4)&&($MergeWith!='')&&($MergeWith4!='')) {
			$ClassError='You cannot have two or more classes which are the same';				
		}
		if(($MergeWith2==$MergeWith4)&&($MergeWith2!='')&&($MergeWith4!='')) {
			$ClassError='You cannot have two or more classes which are the same';			
		}	
		if(($MergeWith3==$MergeWith4)&&($MergeWith3!='')&&($MergeWith4!='')) {
			$ClassError='You cannot have two or more classes which are the same';				
		}

//=============================================		
		if(($SubjectLength==7)||($SubjectLength==11)) {				
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

	
		
		$FirstSubject=substr($MergeInfo,0,3);
		$SecondSubject=substr($MergeInfo,4,3);
		$ThirdSubject=substr($MergeInfo,8,3);

 
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

		$CheckMergeRow = $CheckMergeRow2 = $CheckMergeRow3 = $CheckMergeRow4 = 0;
		$CheckMergeAssignmentRow = $CheckMerge2AssignmentRow = $CheckMerge3AssignmentRow = $CheckMerge4AssignmentRow = 0;				
		
		$CheckMergeAssignment = "SELECT * FROM assignment WHERE ClassID='$MergeWith' AND MergeInfo='$PrioritySubject'";	 //Checks the table assignment to see if the subject exists for that class
   		$CheckMergeAssignmentResult = mysql_query($CheckMergeAssignment);			
		$CheckMergeAssignmentRow = mysql_num_rows($CheckMergeAssignmentResult);			
		
		$CheckMerge2Assignment = "SELECT * FROM assignment WHERE ClassID='$MergeWith2' AND MergeInfo='$PrioritySubject'";	 //Checks the table assignment to see if the subject exists for that class
   		$CheckMerge2AssignmentResult = mysql_query($CheckMerge2Assignment);		
		$CheckMerge2AssignmentRow = mysql_num_rows($CheckMerge2AssignmentResult);
		
		$CheckMerge3Assignment = "SELECT * FROM assignment WHERE ClassID='$MergeWith3' AND MergeInfo='$PrioritySubject'";	 //Checks the table assignment to see if the subject exists for that class
   		$CheckMerge3AssignmentResult = mysql_query($CheckMerge3Assignment);		
		$CheckMerge3AssignmentRow = mysql_num_rows($CheckMerge3AssignmentResult);		
			
		$CheckMerge4Assignment = "SELECT * FROM assignment WHERE ClassID='$MergeWith4' AND MergeInfo='$PrioritySubject'";	 //Checks the table assignment to see if the subject exists for that class
   		$CheckMerge4AssignmentResult = mysql_query($CheckMerge4Assignment);			
		$CheckMerge4AssignmentRow = mysql_num_rows($CheckMerge4AssignmentResult);

		$CheckMergeAssignmentError=$CheckMerge2AssignmentError=$CheckMerge3AssignmentError=$CheckMerge4AssignmentError='';
		
		if($MergeWith!='') {	
			if($CheckMergeAssignmentRow==0) {
				$CheckMergeAssignmentError=$PrioritySubject.' has not been assigned for '.$MergeWith;		//Error if assignment does not exist
			}
		}

		if($MergeWith2!='') {	
			if($CheckMerge2AssignmentRow==0) {
				$CheckMerge2AssignmentError=$PrioritySubject.' has not been assigned for '.$MergeWith2;		//Error if assignment does not exist
			}	
		}
		
		if($MergeWith3!='') {			
			if($CheckMerge3AssignmentRow==0) {
				$CheckMerge3AssignmentError=$PrioritySubject.' has not been assigned for '.$MergeWith3;		//Error if assignment does not exist
			}		
		}							

		if($MergeWith4!='') {	
			if($CheckMerge4AssignmentRow==0) {
				$CheckMerge4AssignmentError=$PrioritySubject.' has not been assigned for '.$MergeWith4;		//Error if assignment does not exist
			}		
		}		
		
		if($MergeWith!='') {	
			$CheckMerge = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$MergeWith'";	 //Checks if the other class has another subject on the period time and day
   			$CheckMergeResult = mysql_query($CheckMerge);
			$CheckMergeRow = mysql_num_rows($CheckMergeResult);
	
			$CheckPeriods = "SELECT * FROM assignment WHERE ClassID='$MergeWith' AND SubjectID='$PrioritySubject'";	 //Checks the periods of the other class
   				$CheckPeriodsResult = mysql_query($CheckPeriods);
			while($db_field=mysql_fetch_assoc($CheckPeriodsResult)) {
				$MergePeriods=$db_field['Periods'];
			}				
		}
		
		if($MergeWith2!='') {	
			$CheckMerge2 = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$MergeWith2'";	 //Checks if the other class has another subject on the period time and day
   			$CheckMergeResult2 = mysql_query($CheckMerge2);
			$CheckMergeRow2 = mysql_num_rows($CheckMergeResult2);	
		}
		
		if($MergeWith3!='') {	
			$CheckMerge3 = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$MergeWith3'";	 //Checks if the other class has another subject on the period time and day
   			$CheckMergeResult3 = mysql_query($CheckMerge3);
			$CheckMergeRow3 = mysql_num_rows($CheckMergeResult3);	
		}
		
		if($MergeWith4!='') {		
			$CheckMerge4 = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$MergeWith4'";	 //Checks if the other class has another subject on the period time and day
   			$CheckMergeResult4 = mysql_query($CheckMerge4);
			$CheckMergeRow4 = mysql_num_rows($CheckMergeResult4);	
		}
		
		$FirstSubjectTest=substr($MergeInfo, 0, 3);		
//==========Check if a teacher assigned to the parallel class has another class and that time and day=====================================		
		$CheckPeriodsPerDay = "SELECT * FROM assignment, periodassignment WHERE periodassignment.PeriodDay='$PeriodDay' AND assignment.ClassID='$ClassID' AND periodassignment.ClassID='$ClassID' AND assignment.MergeInfo='$MergeInfo' AND assignment.SubjectID='$FirstSubjectTest' AND periodassignment.SubjectID='$FirstSubjectTest'";	 //Checks if the other class has another subject on the period time and day		
   		$CheckPeriodsPerDayResult = mysql_query($CheckPeriodsPerDay);
		$CheckPeriodsPerDayRows = mysql_num_rows($CheckPeriodsPerDayResult);			
//=========================================================================================================================================	
//==========Output Error Message if a teacher assigned to the parallel class has another class and that time and day=======================
				if($FirstTeacherRowCheck!=0){		
					$ErrorMessage1="<br>".$FirstTeacher." has another class";
				}
				
				if($SecondTeacherRowCheck!=0) {
					$ErrorMessage2="<br>".$SecondTeacher." has another class";					
				}
				if($ThirdTeacherRowCheck!=0) {
					$ErrorMessage3="<br>".$ThirdTeacher." has another class";					
				}
//==========================================================================================================================================		

		if($CheckPeriodsPerDayRows!=2) {
		if($ClassError=='') {
		if(($CheckMergeAssignmentError=="")&&($CheckMerge2AssignmentError=="")&&($CheckMerge3AssignmentError=="")&&($CheckMerge4AssignmentError=="")) {	
			if(($CheckMergeRow==0)&&($CheckMergeRow2==0)&&($CheckMergeRow3==0)&&($CheckMergeRow4==0)) {		
				if($FirstTeacherRowCheck==0) {
					if($SecondTeacherRowCheck==0) {
						if($ThirdTeacherRowCheck==0) {			
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
												$_SESSION['MergeWith']=$_SESSION['MergeWith2']=$_SESSION['MergeWith3']=$_SESSION['MergeWith4']='';   													
												for($x=$PeriodTime;$x<$PeriodTest;$x++) {   			
   											
											
   												
   													$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$ClassID'";
   													$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);	
	
   													while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {
															$SubjectOne=$db_field['SubjectID'];
															$TeacherOne=$db_field['TeacherID'];   						
   													}
	
														$_SESSION['CurrentClass']=$ClassID;

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
      											
      												if($MergeWith!='') {
   											
   														$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$MergeWith'";
   														$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);	
	
   														while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {
																$SubjectOne=$db_field['SubjectID'];
																$TeacherOne=$db_field['TeacherID'];   						
   														}

															$_SESSION['MergeWith']=$MergeWith;      										
      										
      													$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      													VALUES ('$FirstSubject','$MergeWith','$TeacherOne','$x','$PeriodDay')";        
      														$result = mysql_query($SQLWriteFirstSubject);      					
      					
   														$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$MergeWith'";
   															$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   														while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
																$SubjectTwo=$db_field['SubjectID'];
																$TeacherTwo=$db_field['TeacherID'];   						
   														}

															$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      													VALUES ('$SubjectTwo','$MergeWith','$TeacherTwo','$x','$PeriodDay')";        
      														$result = mysql_query($SQLWriteSecondSubject);
      												}
      											
      												if($MergeWith2!='') {
   											
   														$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$MergeWith2'";
   														$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);	
	
   														while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {
																$SubjectOne=$db_field['SubjectID'];
																$TeacherOne=$db_field['TeacherID'];   						
   														}
      													
															$_SESSION['MergeWith2']=$MergeWith2;      													
      													
      													$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      													VALUES ('$FirstSubject','$MergeWith2','$TeacherOne','$x','$PeriodDay')";        
      														$result = mysql_query($SQLWriteFirstSubject);      					
      					
   														$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$MergeWith2'";
   															$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   														while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
																$SubjectTwo=$db_field['SubjectID'];
																$TeacherTwo=$db_field['TeacherID'];   						
   														}

															$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      													VALUES ('$SubjectTwo','$MergeWith2','$TeacherTwo','$x','$PeriodDay')";        
      														$result = mysql_query($SQLWriteSecondSubject);
      												} 
      										
      												if($MergeWith3!='') {
   											
   														$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$MergeWith3'";
   														$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);	
	
   														while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {
																$SubjectOne=$db_field['SubjectID'];
																$TeacherOne=$db_field['TeacherID'];   						
   														}
      										
      													$_SESSION['MergeWith3']=$MergeWith3;
      										
      													$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      													VALUES ('$FirstSubject','$MergeWith3','$TeacherOne','$x','$PeriodDay')";        
      														$result = mysql_query($SQLWriteFirstSubject);      					
      					
   														$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$MergeWith3'";
   															$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   														while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
																$SubjectTwo=$db_field['SubjectID'];
																$TeacherTwo=$db_field['TeacherID'];   						
   														}

															$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      													VALUES ('$SubjectTwo','$MergeWith3','$TeacherTwo','$x','$PeriodDay')";        
      														$result = mysql_query($SQLWriteSecondSubject);
      												}  
      										
      												if($MergeWith4!='') {
   											
   														$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$MergeWith4'";
   														$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);	
	
   														while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {
																$SubjectOne=$db_field['SubjectID'];
																$TeacherOne=$db_field['TeacherID'];   						
   														}
      										
															$_SESSION['MergeWith4']=$MergeWith4;      										
      										
      													$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      													VALUES ('$FirstSubject','$MergeWith4','$TeacherOne','$x','$PeriodDay')";        
      														$result = mysql_query($SQLWriteFirstSubject);      					
      					
   														$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$MergeWith4'";
   															$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   														while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
																$SubjectTwo=$db_field['SubjectID'];
																$TeacherTwo=$db_field['TeacherID'];   						
   														}

															$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      													VALUES ('$SubjectTwo','$MergeWith4','$TeacherTwo','$x','$PeriodDay')";        
      														$result = mysql_query($SQLWriteSecondSubject);
      												
      													
      												}         										     										
      												
   											}
												if(($MergeWith!='')||($MergeWith2!='')||($MergeWith3!='')||($MergeWith4!='')) {
   												header("location: PrioritySubjectMenu3.php");
   											}
   										}
   										else {//Insert parallel subject into table periodassignment
												$_SESSION['MergeWith']=$_SESSION['MergeWith2']=$_SESSION['MergeWith3']=$_SESSION['MergeWith4']='';   	   											
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
   												
													$_SESSION['CurrentClass']=$ClassID;   												
   												
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
      									
													$_SESSION['PrioritySubject']=$PrioritySubject;      									
      									
      											if($MergeWith!='') {
   													$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$MergeWith'";
   													$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);

   													while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {	
															$SubjectOne=$db_field['SubjectID'];
															$TeacherOne=$db_field['TeacherID'];   						
   													}

														$_SESSION['MergeWith']=$MergeWith;

														$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$FirstSubject','$MergeWith','$TeacherOne','$x','$PeriodDay')";        
      													$result = mysql_query($SQLWriteFirstSubject);      						
   													$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$MergeWith'";
   													$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   													while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
															$SubjectTwo=$db_field['SubjectID'];
															$TeacherTwo=$db_field['TeacherID'];   						
   													}
														$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$SubjectTwo','$MergeWith','$TeacherTwo','$x','$PeriodDay')";        
      													$result = mysql_query($SQLWriteSecondSubject);
      					
   													$SQLGetThirdPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$ThirdSubject' AND ClassID='$MergeWith'";
   													$GetThirdPrioritySubjectResult = mysql_query($SQLGetThirdPrioritySubject);
												
	
   													while($db_field=mysql_fetch_assoc($GetThirdPrioritySubjectResult)) {
															$SubjectThree=$db_field['SubjectID'];
															$TeacherThree=$db_field['TeacherID'];   						
   													}
														$SQLWriteThirdSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$SubjectThree','$MergeWith','$TeacherThree','$x','$PeriodDay')";        
      												$result = mysql_query($SQLWriteThirdSubject);      										
      											}
      									
      											if($MergeWith2!='') {
   													$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$MergeWith2'";
   													$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);

   													while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {	
															$SubjectOne=$db_field['SubjectID'];
															$TeacherOne=$db_field['TeacherID'];   						
   													}
														
														$_SESSION['MergeWith2']=$MergeWith2;

														$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$FirstSubject','$MergeWith2','$TeacherOne','$x','$PeriodDay')";        
      													$result = mysql_query($SQLWriteFirstSubject);      						
   													$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$MergeWith2'";
   													$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   													while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
															$SubjectTwo=$db_field['SubjectID'];
															$TeacherTwo=$db_field['TeacherID'];   						
   													}
														$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$SubjectTwo','$MergeWith2','$TeacherTwo','$x','$PeriodDay')";        
      												$result = mysql_query($SQLWriteSecondSubject);
      					
   													$SQLGetThirdPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$ThirdSubject' AND ClassID='$MergeWith2'";
   													$GetThirdPrioritySubjectResult = mysql_query($SQLGetThirdPrioritySubject);
												
	
   													while($db_field=mysql_fetch_assoc($GetThirdPrioritySubjectResult)) {
															$SubjectThree=$db_field['SubjectID'];
															$TeacherThree=$db_field['TeacherID'];   						
   													}
														$SQLWriteThirdSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$SubjectThree','$MergeWith2','$TeacherThree','$x','$PeriodDay')";        
      												$result = mysql_query($SQLWriteThirdSubject);      										
      											}      									
      									
      											if($MergeWith3!='') {
   													$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$MergeWith3'";
   													$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);
	
   													while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {	
															$SubjectOne=$db_field['SubjectID'];
															$TeacherOne=$db_field['TeacherID'];   						
   													}

														$_SESSION['MergeWith3']=$MergeWith3;

														$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$FirstSubject','$MergeWith3','$TeacherOne','$x','$PeriodDay')";        
      													$result = mysql_query($SQLWriteFirstSubject);      						
   													$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$MergeWith3'";
   													$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   													while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
															$SubjectTwo=$db_field['SubjectID'];
															$TeacherTwo=$db_field['TeacherID'];   						
   													}
														$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$SubjectTwo','$MergeWith3','$TeacherTwo','$x','$PeriodDay')";        
      													$result = mysql_query($SQLWriteSecondSubject);
      					
   													$SQLGetThirdPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$ThirdSubject' AND ClassID='$MergeWith3'";
   													$GetThirdPrioritySubjectResult = mysql_query($SQLGetThirdPrioritySubject);
												
	
   													while($db_field=mysql_fetch_assoc($GetThirdPrioritySubjectResult)) {
															$SubjectThree=$db_field['SubjectID'];
															$TeacherThree=$db_field['TeacherID'];   						
   													}
														$SQLWriteThirdSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$SubjectThree','$MergeWith3','$TeacherThree','$x','$PeriodDay')";        
      													$result = mysql_query($SQLWriteThirdSubject);      										
      											} 
      									
      											if($MergeWith4!='') {
   													$SQLGetFirstPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$FirstSubject' AND ClassID='$MergeWith4'";
   													$GetFirstPrioritySubjectResult = mysql_query($SQLGetFirstPrioritySubject);

   													while($db_field=mysql_fetch_assoc($GetFirstPrioritySubjectResult)) {	
															$SubjectOne=$db_field['SubjectID'];
															$TeacherOne=$db_field['TeacherID'];   						
   													}

														$_SESSION['MergeWith4']=$MergeWith4;

														$SQLWriteFirstSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$FirstSubject','$MergeWith4','$TeacherOne','$x','$PeriodDay')";        
      													$result = mysql_query($SQLWriteFirstSubject);      						
   													$SQLGetSecondPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$SecondSubject' AND ClassID='$MergeWith4'";
   													$GetSecondPrioritySubjectResult = mysql_query($SQLGetSecondPrioritySubject);

   													while($db_field=mysql_fetch_assoc($GetSecondPrioritySubjectResult)) {
															$SubjectTwo=$db_field['SubjectID'];
															$TeacherTwo=$db_field['TeacherID'];   						
   													}
														$SQLWriteSecondSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$SubjectTwo','$MergeWith4','$TeacherTwo','$x','$PeriodDay')";        
      												$result = mysql_query($SQLWriteSecondSubject);
      					
   													$SQLGetThirdPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$ThirdSubject' AND ClassID='$MergeWith4'";
   													$GetThirdPrioritySubjectResult = mysql_query($SQLGetThirdPrioritySubject);
												
	
   													while($db_field=mysql_fetch_assoc($GetThirdPrioritySubjectResult)) {
															$SubjectThree=$db_field['SubjectID'];
															$TeacherThree=$db_field['TeacherID'];   						
   													}
														$SQLWriteThirdSubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      												VALUES ('$SubjectThree','$MergeWith4','$TeacherThree','$x','$PeriodDay')";        
      													$result = mysql_query($SQLWriteThirdSubject);      										
      											}         									        									
      									
      										}		
											} 
											if(($MergeWith!='')||($MergeWith2!='')||($MergeWith3!='')||($MergeWith4!='')) {											
																								
												header("location: PrioritySubjectMenu3.php");
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
							$ErrorMessage3=$ThirdTeacher." has another class";				
						}
					}else {
				$ErrorMessage2=$SecondTeacher." has another class";										
					}
				}else {
					$ErrorMessage1=$FirstTeacher." has another class";			
				}
			}
			else{
		
				$Error=''; 
				$Error2='';
				$Error3='';
				$Error4='';
		
				if($CheckMergeRow>0) { //Check which class has the period time and day taken
					$Error=$MergeWith;
				}

				if($CheckMergeRow2>0) {
					$Error2=$MergeWith2;		
				}
		
				if($CheckMergeRow3>0) {
					$Error3=$MergeWith3;		
				}
			
				if($CheckMergeRow4>0) {
					$Error4=$MergeWith4;		
				}
		
				if(($CheckMergeRow>0)||($CheckMergeRow2>0)||($CheckMergeRow3>0)||($CheckMergeRow4>0)) {		
					$ErrorMessage=$Error." ".$Error2." ".$Error3." ".$Error4." have/has a class during that Period Time and Day";
				}
			
			}
		}
		
			$SQLparallelsubject = "SELECT * FROM assignment WHERE IsFirstSubjectParallel = '1'"; //Get MergeInfo from the table assignment
			$parallelsubjectresult=mysql_query($SQLparallelsubject);
		}
	}else {
		$ErrorMessage='You must only put two periods a day for each Priority Subject';	
	}
//====================================Insertion for non parallel subjects==========================================================		
		}else {
				
				$CheckMergeRow = $CheckMergeRow2 = $CheckMergeRow3 = $CheckMergeRow4 = 0;
   			
   			$SQLPeriods = "SELECT * FROM assignment WHERE SubjectID='$PrioritySubject' AND ClassID='$ClassID'";
   				$PeriodsResult = mysql_query($SQLPeriods);
   	
   			while($db_field=mysql_fetch_assoc($PeriodsResult)) {
					$TeacherID=$db_field['TeacherID'];
					$SubjectID=$db_field['SubjectID'];   		
   				$Periods=$db_field['Periods'];
   				$MergeInfo=$db_field['MergeInfo'];
   				$IsFirstSubjectParallel=$db_field['IsFirstSubjectParallel'];
   				$IsSubjectForAllClasses=$db_field['IsSubjectForAllClasses'];
   			}	

				$SQLCheck = "SELECT * FROM periodassignment WHERE (PeriodTime = '$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='$ClassID') OR (PeriodTime = '$PeriodTime' AND PeriodDay='$PeriodDay' AND ClassID='ALL')"; //Check if there is a subject in the PeriodTime and PeriodDay
					$result = mysql_query($SQLCheck);
   			$num_rows = mysql_num_rows($result);
   			$SQLGetPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$PrioritySubject' AND ClassID='$ClassID'";
   				$GetPrioritySubjectResult = mysql_query($SQLGetPrioritySubject);	
				while($db_field=mysql_fetch_assoc($GetPrioritySubjectResult)) {
					$TeacherOne=$db_field['TeacherID'];   						
  			 	}
   	
			  $CheckAssignmentResultRow=$CheckAssignmentResultRow2=$CheckAssignmentResultRow3=$CheckAssignmentResultRow4=0; 
  
   			if($MergeWith!='') {
					$CheckAssignment = "SELECT * FROM assignment WHERE ClassID='$MergeWith' AND SubjectID='$PrioritySubject'";	 //Checks the table assignment to see if the subject exists for that class
   					$CheckAssignmentResult = mysql_query($CheckAssignment);			
					$CheckAssignmentResultRow = mysql_num_rows($CheckAssignmentResult);;	  
   			}
   	
   			if($MergeWith2!='') {
					$CheckAssignment2 = "SELECT * FROM assignment WHERE ClassID='$MergeWith2' AND SubjectID='$PrioritySubject'";	 //Checks the table assignment to see if the subject exists for that class
   					$CheckAssignmentResult2 = mysql_query($CheckAssignment2);			
					$CheckAssignmentResultRow2 = mysql_num_rows($CheckAssignmentResult2);	   	
  			 	}   	
   	
   			if($MergeWith3!='') {
					$CheckAssignment3 = "SELECT * FROM assignment WHERE ClassID='$MergeWith3' AND SubjectID='$PrioritySubject'";	 //Checks the table assignment to see if the subject exists for that class
   					$CheckAssignmentResult3 = mysql_query($CheckAssignment3);			
					$CheckAssignmentResultRow3 = mysql_num_rows($CheckAssignmentResult3);	   	
 			 	}
   	
  		 	  if($MergeWith4!='') {
					$CheckAssignment4 = "SELECT * FROM assignment WHERE ClassID='$MergeWith4' AND SubjectID='$PrioritySubject'";	 //Checks the table assignment to see if the subject exists for that class
   					$CheckAssignmentResult4 = mysql_query($CheckAssignment4);			
					$CheckAssignmentResultRow4 = mysql_num_rows($CheckAssignmentResult4);	   	
   		  } 
   	

   	
				if($MergeWith!='') {	
					if($CheckAssignmentResultRow==0) {
						echo $CheckAssignmetnResultRow;
						$CheckAssignmentError=$PrioritySubject.' has not been assigned for '.$MergeWith;		//Outputs an error message if assignment is not set for the class
					}
				}

				if($MergeWith2!='') {	
					if($CheckAssignmentResultRow2==0) {
						$CheckAssignmentError2=$PrioritySubject.' has not been assigned for '.$MergeWith2;		
					}	
				}
		
				if($MergeWith3!='') {			
					if($CheckAssignmentResultRow3==0) {
						$CheckAssignmentError3=$PrioritySubject.' has not been assigned for '.$MergeWith3;		
					}		
				}							

				if($MergeWith4!='') {	
					if($CheckAssignmentResultRow4==0) {
						$CheckAssignmentError4=$PrioritySubject.' has not been assigned for '.$MergeWith4;		
					}		
				}	  	
		

				$CheckPeriodTimeTeacher = "SELECT * FROM periodassignment WHERE PeriodTime='$PeriodTime' AND PeriodDay='$PeriodDay' AND TeacherID='$TeacherOne'";	 
   				$FirstTeacherTimeResult = mysql_query($CheckPeriodTimeTeacher);
				$FirstTeacherRowCheck = mysql_num_rows($FirstTeacherTimeResult);	
			
			if($ClassError=='') {
			if(($CheckAssignmentError=="")&&($CheckAssignmentError2=="")&&($CheckAssignmentError3=="")&&($CheckAssignmentError4=="")) {		
				if($FirstTeacherRowCheck==0) {
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
							$SQLPeriodCheck = "SELECT * FROM periodassignment WHERE SubjectID='$PrioritySubject' AND ClassID='$ClassID'"; //Check if there is a subject in the PeriodTime and PeriodDay
								$result = mysql_query($SQLPeriodCheck);
   						$num_rows = mysql_num_rows($result);
   						if($num_rows < $Periods) {
   							if(($DayPeriods+$num_rows)<=$Periods) {
     								$PeriodTest=$PeriodTime+$DayPeriods;
										$_SESSION['MergeWith']=$_SESSION['MergeWith2']=$_SESSION['MergeWith3']=$_SESSION['MergeWith4']='';   	
										for($x=$PeriodTime;$x<$PeriodTest;$x++) {   			
   										$SQLGetPrioritySubject = "SELECT * FROM assignment WHERE SubjectID='$PrioritySubject' AND ClassID='$ClassID'";
   											$GetPrioritySubjectResult = mysql_query($SQLGetPrioritySubject);	
	
   									while($db_field=mysql_fetch_assoc($GetPrioritySubjectResult)) {
											$TeacherOne=$db_field['TeacherID'];   						
   									}
										
										$_SESSION['PrioritySubject']=$PrioritySubject;
										$_SESSION['CurrentClass']=$ClassID;
										$_SESSION['MergeWith']=$MergeWith;
										$_SESSION['MergeWith2']=$MergeWith2;
										$_SESSION['MergeWith3']=$MergeWith3;										
										$_SESSION['MergeWith4']=$MergeWith4;											
										
										$SQLWritePrioritySubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$PrioritySubject','$ClassID','$TeacherOne','$x','$PeriodDay')";        
      									$result = mysql_query($SQLWritePrioritySubject);
      									
      								if($MergeWith!='') { 
											$SQLWritePrioritySubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$PrioritySubject','$MergeWith','$TeacherOne','$x','$PeriodDay')";        
      										$result = mysql_query($SQLWritePrioritySubject);											      								
      								}
      								if($MergeWith2!='') { 
											$SQLWritePrioritySubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$PrioritySubject','$MergeWith2','$TeacherOne','$x','$PeriodDay')";        
      										$result = mysql_query($SQLWritePrioritySubject);											      								
      								}   
      								if($MergeWith3!='') { 
											$SQLWritePrioritySubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$PrioritySubject','$MergeWith3','$TeacherOne','$x','$PeriodDay')";        
      										$result = mysql_query($SQLWritePrioritySubject);											      								
      								}     
      								if($MergeWith4!='') { 
											$SQLWritePrioritySubject = "INSERT INTO periodassignment (SubjectID,ClassID,TeacherID,PeriodTime,PeriodDay)
      									VALUES ('$PrioritySubject','$MergeWith4','$TeacherOne','$x','$PeriodDay')";        
      										$result = mysql_query($SQLWritePrioritySubject);											      								
      								}     								 								   								     					
						}
						if(($MergeWith!='')||($MergeWith2!='')||($MergeWith3!='')||($MergeWith4!='')) {					
							header("location: PrioritySubjectMenu3.php");
							echo 'test';
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
				}
			}else {
							$ErrorMessage=$TeacherOne." has another class";		
			}
					
		}
					else{
		
				$Error=''; 
				$Error2='';
				$Error3='';
				$Error4='';
		
				if($CheckMergeRow>0) { //Check which class has the period time and day taken
					$Error=$MergeWith;
				}

				if($CheckMergeRow2>0) {
					$Error2=$MergeWith2;		
				}
	
				if($CheckMergeRow3>0) {
					$Error3=$MergeWith3;		
				}
			
				if($CheckMergeRow4>0) {
					$Error4=$MergeWith4;		
				}
				
				if(($CheckMergeRow>0)||($CheckMergeRow2>0)||($CheckMergeRow3>0)||($CheckMergeRow4>0)) {		
					$ErrorMessage=$Error." ".$Error2." ".$Error3." ".$Error4." have/has a class during that Period Time and Day";
				}
			}
		}
	}
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
																	$SQLPrioritySubject = "SELECT * FROM assignment WHERE (IsFirstSubjectParallel = '1' OR SubjectID='FAB' OR SubjectID='PHE') AND ClassID='$ClassID'";
																		$SQLPrioritySubjectResult=mysql_query($SQLPrioritySubject);														
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
																	  		$SQLCheckNonParallelSubjectPeriodAssignment = "SELECT * FROM periodassignment WHERE SubjectID='$Subject'";
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
																<br><font color='red' size='0.5'><?php echo $ErrorMessage; echo $ErrorMessage1; echo $ErrorMessage2; echo $ErrorMessage3?></font>
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
																	<?php 
																	$SQLClass = "SELECT * FROM class WHERE ClassID!='ALL' AND ClassID!='$ClassID'";
																		$SQLClassResult=mysql_query($SQLClass);																	
																	while ($row = mysql_fetch_assoc($SQLClassResult)) {	?>
   	 																<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
   	 																																				
																	<?php }?>															
																</select>
																<br> <font color='red' size='0.5'><?php echo $CheckMergeAssignmentError; ?><?php echo $CheckAssignmentError; ?></font>
																<select name='MergeWith2'>	
																	<option value=""></option>	
																	<?php 
																	$SQLClass = "SELECT * FROM class WHERE ClassID!='ALL' AND ClassID!='$ClassID'";
																		$SQLClassResult=mysql_query($SQLClass);																	
																	while ($row = mysql_fetch_assoc($SQLClassResult)) {	?>
   	 																<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
   	 																																				
																	<?php }?>																
																</select>
																<br> <font color='red' size='0.5'><?php echo $CheckMerge2AssignmentError; ?><?php echo $CheckAssignmentError2; ?></font>																
																<select name='MergeWith3'>	
																	<option value=""></option>	
																	<?php 
																	$SQLClass = "SELECT * FROM class WHERE ClassID!='ALL' AND ClassID!='$ClassID'";
																		$SQLClassResult=mysql_query($SQLClass);																	
																	while ($row = mysql_fetch_assoc($SQLClassResult)) {	?>
   	 																<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
   	 																																				
																	<?php }?>															
																</select>
																<br> <font color='red' size='0.5'><?php echo $CheckMerge3AssignmentError; ?><?php echo $CheckAssignmentError3; ?></font>																
																<select name='MergeWith4'>	
																	<option value=""></option>	
																	<?php 
																	$SQLClass = "SELECT * FROM class WHERE ClassID!='ALL' AND ClassID!='$ClassID'";
																		$SQLClassResult=mysql_query($SQLClass);																	
																	while ($row = mysql_fetch_assoc($SQLClassResult)) {	?>
   	 																<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
   	 																																				
																	<?php }?>
																 </select>
																<br> <font color='red' size='0.5'><?php echo $CheckMerge4AssignmentError; ?><?php echo $CheckAssignmentError4; ?><?php echo $ClassError; ?></font>																 																																																																																
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
															<td colspan="2">
																<font color="red" size='0.5'><?php echo $OverlapError; ?></font>															
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
   				//$RowsGet = "SELECT * FROM periodassignment WHERE ClassID='$ClassID' AND SubjectID='LIS'";
					//	$RowsGetResult = mysql_query($RowsGet); 			
				//	$num_rows3 = mysql_num_rows($RowsGetResult);		//check number of the parallel subject exist
   			//	$SQLPeriods2 = "SELECT * FROM assignment WHERE SubjectID='LIS' AND ClassID='$ClassID'";
   			//	$PeriodsResult2 = mysql_query($SQLPeriods2);
   			//	while($db_field=mysql_fetch_assoc($PeriodsResult2)) {
   			//		$Periods2=$db_field['Periods'];
   			//	}							
				//	if($num_rows3==$Periods2) {
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
<h2><center>Current Schedule: <?php echo $ClassID.' ' ?>Schedule</center></h2>
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