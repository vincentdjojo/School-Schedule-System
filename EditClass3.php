
<?php
$errorMessage = "";
$num_rows = 0;
$InsertionCheck="";

function quote_smart($value,$handle) {
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);	
	}
	
	if(!is_numeric($value)) {
		$value = "".mysql_real_escape_string($value,$handle)."";	
	}
	return $value;
}
$ClassIDError = $ClassNameError = "";
$ClassID = $ClassName ="";

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		//===================================================================
		//		GET THE CHOSEN ClassID AND ClassName, AND CHECK IT FOR DANGEROUS CHARACTERS
		//===================================================================
		$ClassID = $_POST['Grade'].$_POST['Class'];
		$ClassName = $_POST['ClassName'];
		
		$PreviousClassID=$_POST["cid"];
		$PreviousClassName=$_POST['cn'];
		
		$ClassID = htmlspecialchars($ClassID);
		$ClassName = htmlspecialchars($ClassName);
		//====================================================================
		//		CHECK THAT ClassID is in the correct format
		//====================================================================
//		$IDFrontCheck = substr($ClassID, 0, 3);
//		$IDBackCheck = substr($ClassID, 3, 1);
//		$FrontNumericCheck = intval(substr($ClassID, 2, 1));
//		$ClassIDArray = str_split($ClassID);
//		echo $IDFrontCheck."<br>"; 
//		echo $IDBackCheck."<br>";
//		echo $FrontNumericCheck;
//		for($x=0;$x<2;$x++) {
//			if(is_numeric($ClassIDArray[$x]) == 1 && $ClassIDArray[$x] > 0){
//				$ClassIDError="The first two characters in ClassID must be letters";
//			}
//		}
//		echo $ClassIDError;
//			
//		for($x=3;$x<4;$x++) {
//			if(is_numeric($ClassIDArray[$x]) == 1 && $ClassIDArray[$x] > 0){
//				$ClassIDError="The last character in ClassID must be letters";
//			}
//		}
//		echo $ClassIDError;
//		if(is_numeric($FrontNumericCheck) == 0 && $FrontNumericCheck > 0) {
//			$ClassIDError= "The third character in ClassID must be a number";
//		}
//		echo $ClassIDError;
			
		//====================================================================
		//		CHECK TP SEE IF ClassID AND ClassName ARE OF THE CORRECT LENGTH
		//		A MALICIOUS USER MIGHT TRY TO PASS A STRING THAT IS TOO LONG
		//		if no errors occur, then $errorMessage will be blank
		//====================================================================
		
		$IDLength = strlen($ClassID);
		$NameLength = strlen($ClassName);		
		
		if($IDLength == 4) {
					$ClassIDError = "";
		}
		else {
					$ClassIDError = $ClassIDError."ClassID must be 4 characters".
"<BR>";
		}
		
		if($NameLength >= 5 && $NameLength <= 20) {
					$ClassNameError = "";
		}
		else {
					$ClassNameError = $ClassNameError."ClassName must be less than or equal to 20 characters and greater than or equal to 5 characters".
"<BR>";
		}
		
		
"<BR>";
		
		
		//if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if (empty($ClassID)) {
    $ClassIDError = "ClassID is required";
    
  } else {
		$ClassID = test_input($ClassID);

     //$name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
    // if (!preg_match("/^[a-zA-Z ]*$/",$ClassID)) {
      // $ClassIDError = "Only letters and white space allowed"; 
     //}
  }
  
    if (empty($ClassName)) {
    	$ClassNameError = "ClassName is required";
    
  } else {
    	$ClassName = test_input($_POST["ClassName"]);
    
     if (empty($ClassName)) {
    	$ClassNameError = "ClassName is required";
    
  } else {
    	$ClassName = test_input($_POST["ClassName"]);
    
  }}

/*presence check */
 
  	//echo "Failed";
 // 	fclose($file);//
  
// test to see if $errorMessage is blank
//if it is, then we can go ahead with the rest of the code
// if it's not, we can display the error

		//==========================================================
		//			Write to the database
		//==========================================================

	if ($ClassIDError == ""){
		if ($ClassNameError == "") {
										
			$user_name = "root";
			$pass_word = "";
			$database = "schoolschedule";
			$server = "127.0.0.1";
		
			$db_handle = mysql_connect($server,$user_name,$pass_word);
			$db_found = mysql_select_db($database,$db_handle);
		
			if($db_found) {
				
				$ClassID = quote_smart($ClassID,$db_handle);
				$ClassName = quote_smart($ClassName,$db_handle);

				
				
				//=======================================================
				//		CHECK THAT THE ClassID IS NOT TAKEN
				//=======================================================
				
				$SQL = "SELECT * FROM class WHERE ClassID = '$ClassID' AND ClassID!='$PreviousClassID' ";
				    
                              	$result = mysql_query($SQL);
                                	$num_rows = mysql_num_rows($result);
                 
				//if($num_rows2>0){
 				//	$ClassNameError = "ClassName already taken"; 
 				if($num_rows==0) {         
					$InsertionCheck='Update Successful';
						$SQLwrite = "UPDATE class SET ClassID='$ClassID' , ClassName='$ClassName'
							WHERE ClassID='$PreviousClassID' AND ClassName='$PreviousClassName'";    
					$result = mysql_query($SQLwrite);

				}
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


<table
 style="width: 100%; height: 516px;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
<tr>
	<td>
		<center>
			<div style="color: #603813;">
			<h2>
				Edit a Class
			</h2>
			</div>

		</center>	
<form action="EditClass3.php" method="post">
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
			<font color='red'><?php echo $ClassIDError; ?></font><font color='green'><?php echo $InsertionCheck; ?></font>
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
			<font color='red'><?php echo $ClassNameError ?></font>
		</td>
	</tr>
	<tr>
		<td>
			<input type="hidden" name="cid" value="<?php echo $PreviousClassID; ?>">
			<input type="hidden" name="cn" value="<?php echo $PreviousClassName; ?>">
			<input type="submit">


		</td>
		<td>
<?php 
	if($InsertionCheck!="") {
?>	
			<a href="ClassInsertion.php"><button type="button">Return</button></a>
<?php
	}else if($InsertionCheck='Update Successful') {
	}
 ?>		
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
			ClassID:	
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
			ClassName:		
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
</table>
<h2><center>Previous Class Info</center></h2>
<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">	
<tr>
	<td>
		ClassID: 
	</td>
	<td>
		<?php echo $PreviousClassID; ?>	
	</td>
</tr>
<tr>
	<td>
		ClassName:	
	</td>
	<td>
		<?php echo $PreviousClassName; ?>	
	</td>
</tr>

</body>
</html>