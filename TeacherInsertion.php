<html>
<body>
  <link href="MyStyle.css" type="text/css"
 rel="stylesheet">
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title>Data Insertion</title>
</head>
<body>
	<ul>	
 		<li2>
 			<img src="logo.png" height="46" width="40">
  		</li2>
  		<li><a href="home.php">Home</a></li>
  		<li><a class="active" href="InsertionMenu.php">Data Insertion</a></li>
		<li><a href="assignement.php">Teacher Assignment</a></li> 		
		<li><a href="ScheduleGeneration.php">Generate Schedule</a></li>
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
<h1>Data Insertion</h1>

</center>
<form action="TeacherInsertion2.php" method="post">
<table
 style="width: 100%; height: 516px;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
<tr>
	<td>
		<center>
		<div style="color: #603813;">
			<h2>
				Add a Teacher
			</h2>
		</div>
		</center>	
<table style="height: 20px;" align="center" bgcolor="#FFFFFF">
		<td>		
			TeacherID:
	 	</td>	
	 	<td>
	 		<input type="text" name="TeacherID" style="text-transform:uppercase" ><br>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			FirstName:
		</td>
		<td>	
		 <input type="text" name="FirstName"><br>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			LastName:
		</td>
		<td>	
		 <input type="text" name="LastName"><br>
		</td>
		<td>
		</td>
	</tr>	
	<tr>
		<td>	
			<input type="submit">
		</td>
		<td>
			<a href="InsertionMenu.php"><button type="button">Return</button></a>		
		</td>
	</tr>
</form>
</table>
<center>
	<h2>Rules for Teacher Insertion</h2>
</center>
<table align = "center" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
		<td>
			Name
		</td>
		<td>
			Validation		
		</td>	
	</tr>
	<tr>
		<td>
			TeacherID
		</td>	
		<td>
			1. TeacherID must always be 3 characters longs.
			<br>
			2. TeacherID must only contain letters.	
			<br>
			3. TeacherID must always be present.	
		</td>
	</tr>
	<tr>
		<td>
			FirstName		
		</td>	
		<td>
			1. FirstName must be less than or equal to 255 characters and greater than or equal to 3 characters
			<br>
			2. FirstName must only contain letters.
			<br>
			3. FirstName must always be present.		
		</td>
	</tr>
	<tr>
		<td>
			LastName
		</td>	
		<td>
			1. LastName must be less than or equal to 255 characters and greater than or equal to 3 characters
			<br>
			2. LastName must only contain letters.
			<br>
			3. LastName must always be present.			
		</td>
	</tr>
</table>
</table>
<center><h2>Teachers</h2></center>
<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
		
		$SQLteacher = "SELECT * FROM teacher WHERE TeacherID<>'ALL' AND TeacherID<>'ADM'";
   		$TeacherResult = mysql_query($SQLteacher);
   	
   	while($db_field=mysql_fetch_assoc($TeacherResult)) {
?>


	<table border="1" cellpadding="0" style="border-spacing: 0px;  height:40%; width: 50%;" align="center" bgcolor="#FFFFFF">
		<tr><td>TeacherID:</td><td align="center"><?php print $db_field['TeacherID'];?></td><td><a href="EditTeacherInsertion.php?tid=<?php print $db_field['TeacherID']?>&fn=<?php print $db_field['FirstName']?>&ln=<?php print $db_field['LastName']?>">Edit</a></td></tr>
		<tr><td>FirstName:</td><td align="center"><?php print $db_field['FirstName'];?></td></tr>
		<tr><td>LastName:</td><td align="center"><?php print $db_field['LastName'];?></td></tr>
	</table>
<?php
}
?>
</body>
</html>