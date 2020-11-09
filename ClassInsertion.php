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

<form action="ClassInsertion2.php" method="post">
<table
 style="width: 100%; height: 516px;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
<tr>
	<td>
		<center>
			<div style="color: #603813;">
			<h2>
				Add a Class
			</h2>
			</div>

		</center>	
<form action="ClassInsertion2.php" method="post">
<table style="height: 20px;" align="center" bgcolor="#FFFFFF">
	<tr>
		<td>
			ClassID:
	 	</td>	
	 	<td>
	 		<select name='Grade'>
				<option value=""></option>
				<option value="SC1">SC1</option>
				<option value="SC2">SC2</option>
				<option value="SC3">SC3</option>
				<option value="SC4">SC4</option>
				<option value="JC1">JC1</option>
				<option value="JC2">JC2</option>
			</select>
	 		<select name='Class'>
				<option value=""></option>
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="C">C</option>
				<option value="D">D</option>
				<option value="E">E</option>
				<option value="F">F</option>
				<option value="G">G</option>
				<option value="H">H</option>
				<option value="I">I</option>
				<option value="J">J</option>
				<option value="K">K</option>
				<option value="L">L</option>
				<option value="M">M</option>
				<option value="N">N</option>
				<option value="O">O</option>
				<option value="P">P</option>
				<option value="Q">Q</option>
				<option value="R">R</option>
				<option value="S">S</option>
				<option value="T">T</option>
				<option value="U">U</option>
				<option value="V">V</option>
				<option value="W">W</option>
				<option value="X">X</option>
				<option value="Y">Y</option>
				<option value="Z">Z</option>
			</select>	
			</td>
		<td>

		</td>
	</tr>
	<tr>
		<td>
			ClassName:
		</td>
		<td>	
		 <input type="text" name="ClassName"maxlength="20">
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
	<h2>Rules for Class Insertion</h2>
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
			ClassID	
		</td>	
		<td>
			1. ClassID must always have the same format. For example: JC2C or SC4C
			<br>
			2. ClassID must always be 4 characters long.
			<br>
			3. ClassID must only contain letters and numbers.	
			<br>
			4. ClassID must always be present.	
		</td>
	</tr>
	<tr>
		<td>
			ClassName		
		</td>	
		<td>
			1. ClassName must be less than or equal to 20 characters and greater than or equal to 5 characters.
			<br>
			2. ClassName must only contain letters and numbers.
			<br>
			3. ClassName must always be present.		
		</td>
	</tr>

</table>
	</td>
</tr>
</table>
</table>

<center><h2>Classes</h2></center>
<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
		
		$SQLclass = "SELECT * FROM class WHERE ClassID<>'ALL'";
   		$ClassResult = mysql_query($SQLclass);
   	
   	while($db_field=mysql_fetch_assoc($ClassResult)) {
?>


	<table border="1" cellpadding="0" style="border-spacing: 0px;  height:40%; width: 50%;" align="center" bgcolor="#FFFFFF">
		<tr><td>ClassID:</td><td align="center"><?php print $db_field['ClassID'];?></td><td><a href="EditClass.php?cid=<?php print $db_field['ClassID']?>&cn=<?php print $db_field['ClassName']?>">Edit</a></td></tr>
		<tr><td>ClassName:</td><td align="center"><?php print $db_field['ClassName'];?></td></tr>
	</table>
<?php
}
?>

</body>
</html>