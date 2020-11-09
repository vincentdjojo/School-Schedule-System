<html>
<body>
<?php
//$ClassID=$_POST['ClassID'];
//$ClassName=$_POST['ClassName'];
//$ErrorMessage="";
//if (strlen($ClassID)>5) {
//  $ErrorMessage="ClassID is too long";
//}
//else
//if (strlen($ClassID)<4) {
//  $ErrorMessage="ClassID is too short";
//}
//else {
//  $ErrorMessage="";
//}
//if (strlen($ClassName)>20) {
//  $ErrorMessage="ClassName is too long";
//}
//else
//if (strlen($ClassID)<5) {
//  $ErrorMessage="ClassName is too short";
//}
//}
//else {
//  $ErrorMessage="";
//}

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
$TeacherIDError = $FirstNameError = $LastNameError = "";
$TeacherID = $FirstName = $LastName = "";

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
		

		$TeacherID = $_POST['TeacherID'];
		$FirstName = $_POST['FirstName'];
		$LastName = $_POST['LastName'];
		
		$PreviousTeacherID= $_POST["tid"];
		$PreviousFirstName= $_POST["fn"];
		$PreviousLastName= $_POST["ln"];
		
		$TeacherID = htmlspecialchars($TeacherID);
		$FirstName = htmlspecialchars($FirstName);
		$LastName = htmlspecialchars($LastName); 

		
		$IDLength = strlen($TeacherID);
		$FirstNameLength = strlen($FirstName);
		$LastNameLength = strlen($LastName);
		
		if($IDLength == 3) {
					$TeacherIDError = "";
		}
		else {
					$TeacherIDError = $TeacherIDError."TeacherID must be 3 characters".
"<BR>";
		}
		
		if($FirstNameLength >= 3 && $FirstNameLength <= 255) {
					$FirstNameError = "";
		}
		else {
					$FirstNameError = $FirstNameError."FirstName must be less than or equal to 255 characters and greater than or equal to 3 characters".
"<BR>";
		}
		
		
"<BR>";

		if($LastNameLength >= 3 && $LastNameLength <= 255) {
					$LastNameError = "";
		}
		else {
					$LastNameError = $LastNameError."LastName must be less than or equal to 255 characters and greater than or equal to 3 characters".
"<BR>";
		}
		
		
		//if ($_SERVER["REQUEST_METHOD"] == "POST") {
	


     //$name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
    // if (!preg_match("/^[a-zA-Z ]*$/",$ClassID)) {
      // $ClassIDError = "Only letters and white space allowed"; 
     //}
  }
  
	if (ctype_alpha(str_replace(' ', '', $TeacherID)) === false) {
  		$TeacherIDError = 'TeacherID must contain letters only';
	}
	if (ctype_alpha(str_replace(' ', '', $FirstName)) === false) {
  		$FirstNameError = 'FirstName must contain letters only';
	}
	if (ctype_alpha(str_replace(' ', '', $LastName)) === false) {
  		$LastNameError = 'LastName must contain letters only';
	}

  if (empty($TeacherID)) {
    $TeacherIDError = "TeacherID is required";
    
  } else {
		$TeacherID = test_input($_POST["TeacherID"]);
	}
    if (empty($FirstName)) {
    $FirstNameError = "FirstName is required";
    
  } else {
    $FirstName = test_input($_POST["FirstName"]);
 	 }
 	 
     if (empty($LastName)) {
    $LastNameError = "LastName is required";
    
  	} else {
    $LastName = test_input($_POST["LastName"]);
    
  	 }



   // if (ctype_alpha($TeacherID)) {	// Check that the fields TeacherID, FirstName and LastName have only letters
   //     $TeacherIDError = "";
   // } else {
   //     $TeacherIDError = "TeacherID can only have letters.";
   // }
   // if (ctype_alpha($FirstName)) {
   //     $FirstNameError = "";
   // } else {
    //    $FirstNameError = "FirstName can only have letters.";
    //}
   // if (ctype_alpha($TeacherID)) {
    //    $LastNameError = "";
    //} else {
    //    $LastNameError = "LastName can only have letters.";
    //}    
	
/*presence check */
 
  	//echo "Failed";
 // 	fclose($file);//
  
// test to see if $errorMessage is blank
//if it is, then we can go ahead with the rest of the code
// if it's not, we can display the error

		//==========================================================
		//			Write to the database
		//==========================================================

if ($TeacherIDError == ""){
	if ($FirstNameError == "") {
		if($LastNameError == "") {
										
			$user_name = "root";
			$pass_word = "";
			$database = "schoolschedule";
			$server = "127.0.0.1";
		
			$db_handle = mysql_connect($server,$user_name,$pass_word);
			$db_found = mysql_select_db($database,$db_handle);
		
			if($db_found) {
				
				$TeacherID = quote_smart($TeacherID,$db_handle);
				$FirstName = quote_smart($FirstName,$db_handle);
				$LastName = quote_smart($LastName,$db_handle);
				
				
				//=======================================================
				//		CHECK THAT THE TeacherID IS NOT TAKEN
				//=======================================================
				

                                

					$InsertionCheck="Update Successful";
					$SQLwrite = "UPDATE teacher SET TeacherID='$TeacherID' , FirstName='$FirstName' , LastName='$LastName' 
						WHERE TeacherID='$PreviousTeacherID' AND FirstName='$PreviousFirstName' AND LastName='$PreviousLastName'";  

   				$TeacherResult = mysql_query($SQLwrite);
            }
			}
		}
	}	

?>

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
<form action="EditTeacherInsertion3.php" method="post">
<table
 style="width: 100%; height: 516px;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
<tr>
	<td>
		<center>
			<h2>
				<div style="color: #603813;">
				Add a Teacher
				</div>
			</h2>
		</center>	
<table style="height: 20px;" align="center" bgcolor="#FFFFFF">
		<td>		
			TeacherID:
	 	</td>	
	 	<td>
	 		<input type="text" name="TeacherID"style="text-transform:uppercase"><br>
		</td>
		<td>
			<font color="red"><?php echo $TeacherIDError;?></font><font color = "green"><?php echo $InsertionCheck ?></font>
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
			<font color="red"><?php echo $FirstNameError; ?></font>
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
			<font color="red"><?php echo $LastNameError;?></font>
		</td>
	</tr>	
	<tr>
		<td>

			<input type="hidden" name="tid" value="<?php echo $PreviousTeacherID; ?>">
			<input type="hidden" name="fn" value="<?php echo $PreviousFirstName; ?>">
			<input type="hidden" name="ln" value="<?php echo $PreviousLastName; ?>">
			<input type="submit">
		</td>
		<td>
		<?php
			if ($InsertionCheck=='Update Successful'){
			
					
		 ?>
			<a href="TeacherInsertion.php"><button type="button">Return</button></a>
		 <?php	
			}else {}		 
		 ?>		
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
<h2><center>Previous Teacher Info</center></h2>
<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center" bgcolor="#FFFFFF">	
<tr>
	<td >
		TeacherID: 
	</td>
	<td align='center'>
		<?php echo $PreviousTeacherID; ?>	
	</td>
</tr>
<tr>
	<td>
		LastName:	
	</td>
	<td align='center'>
		<?php echo $PreviousLastName; ?>	
	</td>
</tr>
<tr>
	<td >
		FirstName:	
	</td>
	<td align='center'>
		<?php echo $PreviousFirstName; ?>	
	</td>
</tr>