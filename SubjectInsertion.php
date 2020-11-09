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


<center>


</center>
<form action="SubjectInsertion2.php" method="post">
<table
 style="width: 100%; height: 516px;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
<tr>
	<td>
		<center>
		<div style="color: #603813;">
			<h2>
				Add a Subject
			</h2>
		</div>
		</center>	
<table style="height: 20px;" align="center" bgcolor="#FFFFFF">
	<tr>
		<td>
			SubjectID:
	 	</td>	
	 	<td>
	 		<input type="text" name="SubjectID" style="text-transform:uppercase"><br>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			SubjectName:
		</td>
		<td>	
		 <input type="text" name="SubjectName"><br>
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td>
			Category:
<?php
	$category = "";
?>
		</td>
		<td>	
			<input type="radio" name="Category" value="p">Parallel
			<input type="radio" name="Category" value="n">Non-Parallel
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
	<h2>Rules for Subject Insertion</h2>
</center>
<table align = "center" border="1" cellpadding="0" cellspacing="0"bgcolor="#FFFFFF">
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
			SubjectID	
		</td>	
		<td>
			1. SubjectID must only have 4 characters
			<br>
			2. SubjectID must only contain letters.
			<br>
			3. SubjectID must always be present.	
		</td>
	</tr>
	<tr>
		<td>
			SubjectName		
		</td>	
		<td>
			1. SubjectName must be less than or equal to 50 characters and greater than or equal to 5 characters.
			<br>
			2. SubjectName must only contain letters.
			<br>
			3. SubjectName must always be present.		
		</td>
	</tr>
</table>
</table>
<center><h2>Subjects</h2></center>
<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
		
		$SQLsubject = "SELECT * FROM subject WHERE SubjectID!='ASS' AND SubjectID!='CPL'";
   		$SubjectResult = mysql_query($SQLsubject);
   	
   	while($db_field=mysql_fetch_assoc($SubjectResult)) {
?>


	<table border="1" cellpadding="0" style="border-spacing: 0px;  height:40%; width: 50%;" align="center" bgcolor="#FFFFFF">
		<tr><td>SubjectID:</td><td align="center"><?php print $db_field['SubjectID'];?></td><td><a href="EditSubject.php?sid=<?php print $db_field['SubjectID']?>&sn=<?php print $db_field['SubjectName']?>&c=<?php print $db_field['Category']?>">Edit</a></td></tr>
		<tr><td>SubjectName:</td><td align="center"><?php print $db_field['SubjectName'];?></td></tr>
		<tr><td>Category:</td><td align="center"><?php if($db_field['Category']=='p'){ 
																	  	echo'Parallel Subject';
																	  }
																	  else if($db_field['Category']=='n') {
																	  	echo'Non-parallel Subject';		
																	  }?></td></tr>
	</table>
<?php
}
?>
</body>
</html>