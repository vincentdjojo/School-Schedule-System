<html>

	<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";


		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
	
	
		$TeacherID=$_GET["tid"];	
		$SubjectID=$_GET["sid"];
		$ClassID=$_GET["cid"];
		$MergeInfo=$_GET["MergeInfo"];		
		
		$_SESSION['TeacherID']=$TeacherID;
		$_SESSION['SubjectID']=$SubjectID;		
		$_SESSION['ClassID']=$ClassID;
		
		$SubjectIDError="";
		$InsertionCheck="";
		//$TeacherIDError= $SubjectIDError= $ClassIDError= "";
		
				//=======================================================
				//		CHECK THAT ANY FIELD IS NOT TAKEN
				//=======================================================
				
		 
		 			$SQLTeacherName = "SELECT * FROM teacher WHERE TeacherID='$TeacherID'";
   					$TeacherNameResult = mysql_query($SQLTeacherName);
				   $SQLteacher = "SELECT * FROM teacher WHERE TeacherID<>'ALL'";
   					$teacherresult = mysql_query($SQLteacher);
		   		$SQLsubject = "SELECT * FROM subject WHERE SubjectID != 'CHL' AND SubjectID!='MUS' AND SubjectID!='PE' AND SubjectID!='CPL' AND SubjectID!='ASS'";
   					$subjectresult = mysql_query($SQLsubject);
   				$SQLclass = "SELECT * FROM class WHERE ClassID<>'ALL'";
   					$classresult = mysql_query($SQLclass);
   				
   	 			while ($row = mysql_fetch_assoc($TeacherNameResult)) {		
   	 				$TeacherName=$row['FirstName'];
   	 			}			
   
   
	?>
<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Edit Parallel Subject</title>
</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a class="active" href="assignement.php">Teacher Assignment</a></li> 		
 		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
  		<li><a href="#contact">Contact</a></li>

	<ul style="float: right; list-style-type: none;">
		<li>
			<a href="#about">About</a></li>
		<li>
			<a href="#login">Login</a></li>
		</ul>
	</ul>
<div style="text-align: center; font-family: Arial;">
<h1>Teacher Assignment</h1>
<table
 style="width: 100%; height: 516px;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
<tr>
	<td>
	<center>
		<h2>Select Parallel Subject</h2>	

		<form action="ParallelSubjectAssign3.php" method="post">
	<center>
<table style="height: 20px;" align="center" bgcolor="#FFFFFF">	
	<tr>
		<td>Class:</td>
		<td><?php echo $_POST['ClassID']; ?></td>	
	</tr>
	<tr>
		<td>First Parallel Subject:</td>
		<td><?php echo $SubjectID?></td>
	</tr>	
	<tr>	
		<td>Second Parallel Subject:</td>	
		<td><select name='SecondParallelSubject'>
			
			<?php
					
   	 			while ($row = mysql_fetch_assoc($parallelsubjectresult)) {
   	 				?>
   	 				
   					<option value="<?php echo $row['SubjectID'];?>"><?php echo $row['SubjectID'];?></option>
<?php				
				} ?>
			</select></td>		
	</tr>
	<tr>
		<td>Third Parallel Subject:</td>	
		<td><select name='ThirdParallelSubject'>
			<option value="Null"> </option>
			<?php
			$SQLparallelsubject = "SELECT * FROM subject WHERE Category = 'p'";
			$parallelsubjectresult=mysql_query($SQLparallelsubject);
   	 		while ($row2 = mysql_fetch_assoc($parallelsubjectresult)) {
   	 				?>
   	 				
   					<option value="<?php echo $row2['SubjectID'];?>"><?php echo $row2['SubjectID'];?></option>
<?php				
				} ?>
			</select>
		</td>
	
	</tr>	
	<tr>
	<td>
		<input type="submit" value="Submit">
	</td>	
	<td>
			<a href="ParallelSubjectUndo.php"><button type="button">Undo</button></a>	
	</td>
	
	</tr>
</table>
	</center>
	<input type="hidden" name="SubjectID" value="<?php echo $_POST['SubjectID'];?>">
	<input type="hidden" name="ClassID" value="<?php echo $_POST['ClassID'];?>">
	<input type="hidden" name="FirstParallelSubject" value="<?php echo $FirstParallelSubject;?>">
		</form>
</table>
<center>
	<h2>Parallel Subjects</h2>
</center>
<?php
   	$SQLclass = "SELECT * FROM assignment WHERE IsFirstSubjectParallel='1' AND ClassID='$ClassID'";
   		$ParallelSubjectResult = mysql_query($SQLclass);
   	
   	while($db_field=mysql_fetch_assoc($ParallelSubjectResult)) {
?>


	<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">
		<tr><td align="center"><?php print $db_field['MergeInfo'];?></td></tr>
	</table>
<?php
}
?>	