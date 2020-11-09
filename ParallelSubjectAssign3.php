<?php
	session_start();
	$_SESSION['ClassID']=$_POST['ClassID'];
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);	
		
		$InsertionCheck="";
		$ErrorMessage="";
		$ErrorMessage1=$ErrorMessage2=$ErrorMessage3="";
		$ClassID = $_POST["ClassID"];
				

		$SQLparallelsubject = "SELECT * FROM subject WHERE Category = 'p' AND ClassID = '$ClassID'";
		$parallelsubjectresult=mysql_query($SQLparallelsubject);
		
		$FirstParallelSubject=$_POST['FirstParallelSubject'];
		$SecondParallelSubject=$_POST['SecondParallelSubject'];
		$ThirdParallelSubject=$_POST['ThirdParallelSubject'];	
		
		$FirstCombination2=$FirstParallelSubject.'-'.$SecondParallelSubject;
		$SecondCombination2=$SecondParallelSubject.'-'.$FirstParallelSubject;		
		
		$FirstCombination3=$FirstParallelSubject.'-'.$SecondParallelSubject.'-'.$ThirdParallelSubject;
		$SecondCombination3=$SecondParallelSubject.'-'.$FirstParallelSubject.'-'.$ThirdParallelSubject;
		$ThirdCombination3=$ThirdParallelSubject.'-'.$FirstParallelSubject.'-'.$SecondParallelSubject;

		$SQLCheckPresence = "SELECT * FROM assignment WHERE (SubjectID='$FirstParallelSubject' AND ClassID='$ClassID' AND MergeInfo!='') OR (SubjectID='$SecondParallelSubject' AND ClassID='$ClassID' AND MergeInfo!='') OR (SubjectID='$ThirdParallelSubject' AND ClassID='$ClassID'  AND MergeInfo!='')";
				    						$PresenceResult = mysql_query($SQLCheckPresence);
                                	$num_rows = mysql_num_rows($PresenceResult);             

		$PeriodRows1=0;
		$PeriodRows2=0;
		$PeriodRows3=0;
	
		$SQLCheckPeriods = "SELECT * FROM assignment WHERE (SubjectID='$FirstParallelSubject' AND ClassID='$ClassID' )" ;
				    						$PeriodsResult = mysql_query($SQLCheckPeriods);
		while($db_field=mysql_fetch_assoc($PeriodsResult)) {
			$PeriodRows1=$db_field['Periods'];		
		}
      $SQLCheckPeriods2= "SELECT * FROM assignment WHERE (SubjectID='$SecondParallelSubject' AND ClassID='$ClassID' )" ;   
				    						$PeriodsResult2 = mysql_query($SQLCheckPeriods2);
		while($db_field=mysql_fetch_assoc($PeriodsResult2)) {
			$PeriodRows2=$db_field['Periods'];		
		} 
      $SQLCheckPeriods3= "SELECT * FROM assignment WHERE (SubjectID='$ThirdParallelSubject' AND ClassID='$ClassID' )" ;   
				    						$PeriodsResult3 = mysql_query($SQLCheckPeriods3);
		while($db_field=mysql_fetch_assoc($PeriodsResult3)) {
			$PeriodRows3=$db_field['Periods'];		
		}

//============================================Checks if parallel subject has been assigned===============================================	
      $CheckFirstSubject= "SELECT * FROM assignment WHERE (SubjectID='$FirstParallelSubject' AND ClassID='$ClassID' )" ;   
				    						$CheckFirstSubjectResult = mysql_query($CheckFirstSubject);
		$FirstSubjectRows=mysql_num_rows($CheckFirstSubjectResult); 

      $CheckSecondSubject= "SELECT * FROM assignment WHERE (SubjectID='$SecondParallelSubject' AND ClassID='$ClassID' )" ;   
				    						$ChecksSecondSubjectResult = mysql_query($CheckSecondSubject);
		$SecondSubjectRows=mysql_num_rows($ChecksSecondSubjectResult); 
	
		if(($ThirdParallelSubject!='')&&($ThirdParallelSubject!='NULL')) {
      $CheckThirdSubject= "SELECT * FROM assignment WHERE (SubjectID='$ThirdParallelSubject' AND ClassID='$ClassID' )" ;   
				    						$CheckThirdSubjectResult = mysql_query($CheckThirdSubject);
		$ThirdSubjectRows=mysql_num_rows($CheckFirstSubjectResult); 
		}
		
		if($FirstSubjectRows==0) {
			$ErrorMessage1=$FirstParallelSubject.' has not been assigned';
		}
		if($SecondSubjectRows==0) {
			$ErrorMessage2=$SecondParallelSubject.' has not been assigned';
		}
		if(($ThirdSubjectRows==0)&&($ThirdParallelSubject=='NULL')) {
			$ErrorMessage3=$ThirdParallelSubject.' has not been assigned';
		}
//========================================================================================================================================			
	
                             	
      if($num_rows>0) {
      
      	$ErrorMessage='One of the selected subjects is already parallel with another subject';
      }    
      else if(($PeriodRows1==$PeriodRows2)&&($PeriodRows1==$PeriodRows3))  {
      	if(($ErrorMessage1=='')&&($ErrorMessage2=='')&&($ErrorMessage3=='')) {
      	$InsertionCheck = 'Insertion Successful';			
		
			if($ThirdParallelSubject=="Null") {
				$SQLwrite = " UPDATE assignment SET MergeInfo='$FirstCombination2'WHERE SubjectID='$FirstParallelSubject' AND ClassID='$ClassID'";       
         	                               $result = mysql_query($SQLwrite);
				
				$SQLwrite = " UPDATE assignment SET MergeInfo='$FirstCombination2'WHERE SubjectID='$SecondParallelSubject' AND ClassID='$ClassID'";      
                                        	$result = mysql_query($SQLwrite);
				$SQLBoolFirstParallelSubject = " UPDATE assignment SET IsFirstSubjectParallel='1'WHERE SubjectID='$FirstParallelSubject'"; /*Update the field IsFirstParallelSubjectParallel into 'true' so that only one MergeInfo will appear in the page called PrioritySubject.php */    
                                        	$UpdateParallel = mysql_query($SQLBoolFirstParallelSubject);
			
			} else{
				$SQLwrite = " UPDATE assignment SET MergeInfo='$FirstCombination3'WHERE SubjectID='$FirstParallelSubject' AND ClassID='$ClassID'";       
                                        	$result = mysql_query($SQLwrite);	
				$SQLwrite = " UPDATE assignment SET MergeInfo='$FirstCombination3'WHERE SubjectID='$SecondParallelSubject' AND ClassID='$ClassID'";       
                                        	$result = mysql_query($SQLwrite);		
				$SQLwrite = " UPDATE assignment SET MergeInfo='$FirstCombination3'WHERE SubjectID='$ThirdParallelSubject' AND ClassID='$ClassID'";       
                                        	$result = mysql_query($SQLwrite);		
				$SQLBoolFirstParallelSubject = " UPDATE assignment SET IsFirstSubjectParallel='1'WHERE SubjectID='$FirstParallelSubject' AND ClassID='$ClassID'"; /*Update the field IsFirstParallelSubjectParallel into 'true' so that only one MergeInfo will appear in the page called PrioritySubject.php */       
                                        	$UpdateParallel = mysql_query($SQLBoolFirstParallelSubject);
		
			}
		}else {
			if(($PeriodRows1!=$PeriodRows2)&&($PeriodRows2!=$PeriodRows3)) {
				$ErrorMessage=$FirstParallelSubject.', '.$SecondParallelSubject.', '.$ThirdParallelSubject.' all do not have the same number of Periods. You can change the Periods at the tab Teaceher Assignment';			
			}
			if($PeriodRows1!=$PeriodRows2) {	
				$ErrorMessage=$FirstParallelSubject.' does not have the same Periods as '. $SecondParallelSubject.' <br>You can change the Periods at the tab Teaceher Assignment';			
			}else if($PeriodRows1!=$PeriodRows3) {
				$ErrorMessage=$FirstParallelSubject.' does not have the same Periods as '. $ThirdParallelSubject.' <br>You can change the Periods at the tab Teaceher Assignment';					
			
			}else if($PeriodRows2!=$PeriodRows3) {
				$ErrorMessage=$SecondParallelSubject.' does not have the same Periods as '. $ThirdParallelSubject.' <br>You can change the Periods at the tab Teaceher Assignment';					
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
  <title>Select Parallel Subject</title>
</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li>
		<li><a class="active" href="selectclassparallelsubject.php">Parallel Subject Assignment</a></li>		 		
 		<li><a  href="ScheduleGeneration.php">Generate Schedule</a></li>
  		<li><a  href="search.php">Search Schedule</a></li>
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
	<center>
		<h1>Parallel Subject Assignment</h1>	
	</center>
<div style="text-align: center; font-family: Arial; font-size:100%; ">
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<img src="selectparallelsubject.png"><img src="baka2.png" alt="" width="162" height="224">
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

		<form action="selectclassparallelsubject.php" method="post">
	<center>
<table style="height: 20px;" align="center" bgcolor="">	
	<tr>
		<td><font size='1.5'>Class:</font></td>
		<td>
			<font size='1.5'><?php echo $_POST['ClassID']; ?></font>
		</td>
		<td>
		
		</td>	
	</tr>
	<tr>
		<td colspan="2">
				<font color="green" size='0.1'><?php echo $InsertionCheck; ?></font><font color="red" size='0.1'><?php echo $ErrorMessage; ?></font>	
		</td>	
	</tr>
	<tr>
		<td><font size='1.5'>First Parallel Subject:</font></td>
		<td><font size='1.5'><?php echo $FirstParallelSubject;?></font>
		<br><font size='1.5' color='red'><?php echo $ErrorMessage1; ?><?font></td>

	</tr>	
	<tr>	
		<td><font size='1.5'>Second Parallel Subject:</font></td>	
		<td>
			<font size='1.5'><?php echo $SecondParallelSubject;?></font>
		<br><font size='1.5' color='red'><?php echo $ErrorMessage2; ?><?font>					
		</td>		
	</tr>
	<tr>
		<td><font size='1.5'>Third Parallel Subject:</font></td>	
		<td>
			<font size='1.5'><?php echo $ThirdParallelSubject;?></font>
			<br><font size='1.5' color='red'><?php echo $ErrorMessage3; ?><?font>
		</td>
	
	</tr>	
	<tr>
	<td>
<a href="selectclassparallelsubject.php"><button type="button" style="height:40px;width:100px"><font size='0.5'>Add Parallel Subject for Another Class</font></button></a>
	</td>	
	<td>
		<a href="ParallelSubjectAssign.php"><input type="submit" style="height:40px;width:110px;font-size:10;" value="Add Parallel Subject">
		<input type="hidden" name="cid" value="<?php echo $ClassID; ?>">	
	</td>
	<td>
		<a href="ScheduleGeneration.php"><button type="button" style="height:40px;"><font size='0.1'>Done</font>	</button></a>	
	</td>
	</tr>
</table>
	</center>

	<input type="hidden" name="ClassID" value="<?php echo $_POST['ClassID'];?>">

		</form>
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
</table>
</div>
</body>
<center>
	<h2>Parallel Subjects</h2>
</center>
<?php
   	$SQLclass = "SELECT * FROM assignment WHERE IsFirstSubjectParallel='1' AND ClassID='$ClassID'";
   		$ParallelSubjectResult = mysql_query($SQLclass);
   	
   	while($db_field=mysql_fetch_assoc($ParallelSubjectResult)) {
?>


	<table border="1" cellpadding="0" style="border-spacing: 0px;height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">
		<tr><td align="center"><?php print $db_field['MergeInfo'];?></td></tr>
	</table>
<?php
}
?>
	
</body>
</html>	