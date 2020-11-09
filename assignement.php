<html>

	<?php
		session_start();
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
			
			//$SQLclear="SELECT * FROM assignment";
			//$clearresult=mysql_query('TRUNCATE TABLE assignment;');
		 
		   $SQLteacher = "SELECT * FROM teacher WHERE TeacherID<>'ALL' AND TeacherID<>'ADM'";
   			$teacherresult = mysql_query($SQLteacher);
		   $SQLsubject = "SELECT * FROM subject WHERE SubjectID != 'CHL' AND SubjectID!='MUS' AND SubjectID!='PE' AND SubjectID!='CPL' AND SubjectID!='ASS' AND SubjectID!='CCA'";
   			$subjectresult = mysql_query($SQLsubject);
   		$SQLclass = "SELECT * FROM class WHERE ClassID<>'ALL'";
   			$classresult = mysql_query($SQLclass);
   			
		@$UserName=$_SESSION['UserName'];
		@$TeacherID=$_SESSION['ID'];			
   
	?>
<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Teacher Assignment</title>
</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a href="InsertionMenu.php">Data Insertion</a></li>
		<li><a class="active" href="assignement.php">Teacher Assignment</a></li> 
		<li><a href="selectclassparallelsubject.php">Parallel Subject Assignment</a></li>			
		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
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
<h1>Teacher Assignment</h1>
<div style="text-align: center; font-family: Arial; font-size:100%; ">
<table style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;" background="tablebackground.png" border="1" cellpadding="0" cellspacing="0">

	<tr>
		<td>
			<table style="width:25%; height:516px;" background="backgroundforcontact.png" border="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'>
					<img src="teacherassignment.png"><img src="baka2.gif" alt="" width="162" height="224">
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
	
<form action="TeacherAssignment2.php" method="post">
	<center>
<table style="height: 20px;" align="center" bgcolor="">	
		<tr>			
			<td>
			Teacher:
			</td>
			<td>
			<select name='TeacherID'>
					<?php
   	 				while ($row = mysql_fetch_assoc($teacherresult)) {
   	 			?>
   	 		<option value="<?php echo $row['TeacherID'];?>"><?php echo $row['TeacherID'].'-'.$row['FirstName'];?></option>
			<?php				
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
				Subject:
			</td>
			<td>
				<select name='SubjectID'>
				<?php
   	 			while ($row = mysql_fetch_assoc($subjectresult)) {
   	 		?>
   	 				
   			<option value="<?php echo $row['SubjectID'];?>"><?php echo $row['SubjectID'].'-'.$row['SubjectName'];;?></option>
					<?php				
						} 
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Class:
			</td>
				<td>
					<select name='ClassID'>
				<?php
   	 			while ($row = mysql_fetch_assoc($classresult)) {
   	 		?>
   	 		<option value="<?php echo $row['ClassID'];?>"><?php echo $row['ClassID'].'-'.$row['ClassName'];?></option>
				<?php				
					}
				?>
					</select>
				</td>
		</tr>
		<tr>
			<td>
				Periods:
			</td>
			<td><select name='Periods'>
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
			</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="Submit">
			</td>
			<td>
				<a href="Home.php"><button type="button">Return</button></a>		
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
<h2>Assignments</h2>
		<?php
$SQLlist="SELECT*FROM assignment 
	INNER JOIN class 
		ON class.ClassID=assignment.ClassID
	INNER JOIN teacher
		ON teacher.TeacherID=assignment.TeacherID
	INNER JOIN subject
		ON subject.SubjectID=assignment.SubjectID	
	";
$listresult=mysql_query($SQLlist);



while($db_field=mysql_fetch_assoc($listresult)) {
?>

<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">
<?php
if(($db_field['SubjectID']!='ASS')&&($db_field['SubjectID']!='CPL') ){
 ?>
 <?php if($db_field['TeacherID']!='ALL'){
			if($db_field['ClassID']!='ALL'){ ?>
<tr><td>Teacher:</td><td><?php print $db_field['TeacherID'].'-'.$db_field['FirstName'];?></td>

<td><a href="DeleteAssignment.php?tid=<?php print $db_field['TeacherID']?>&sid=<?php print $db_field['SubjectID']?>&cid=<?php print $db_field['ClassID']?>&periods=<?php print $db_field['Periods']?>">Delete</a></td></tr>
<?php 	
		?>
<tr><td>Subject:</td><td><?php print $db_field['SubjectID'].'-'.$db_field['SubjectName'];?></td><td></td></tr>
<tr><td>Class:</td><td><?php print $db_field['ClassID'].'-'.$db_field['ClassName'];?></td></tr>
<tr><td>Periods:</td><td><?php print $db_field['Periods'];?></td></tr>
</table>

	<?php
				}
			}
		}
	}
	?>
	</body>
</html>

