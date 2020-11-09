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

$CategoryError="";
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
$SubjectIDError = $SubjectNameError = "";
$SubjectID = $SubjectName = $Category ="";

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
		$SubjectID = $_POST['SubjectID'];
		$SubjectName = $_POST['SubjectName'];
		@$Category = $_POST['Category'];

		
		$SubjectID = htmlspecialchars($SubjectID);
		$SubjectName = htmlspecialchars($SubjectName);
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
		
		$IDLength = strlen($SubjectID);
		$NameLength = strlen($SubjectName);		
		
		if($IDLength == 3) {
					$SubjectIDError = "";
		}
		else {
					$SubjectIDError = $SubjectIDError."SubjectID must be 3 characters".
"<BR>";
		}
		
		if($NameLength >= 5 && $NameLength <= 50) {
					$SubjectNameError = "";
		}
		else {
					$SubjectNameError = $SubjectNameError."SubjectName must be less than or equal to 50 characters and greater than or equal to 5 characters".
"<BR>";
		}
		
		
"<BR>";
		
		
		//if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["Category"])) {
        $CategoryError = "You must select 1 option";
    }
    else {
        $Category = $_POST["Category"];
    }

     //$name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
    // if (!preg_match("/^[a-zA-Z ]*$/",$ClassID)) {
      // $ClassIDError = "Only letters and white space allowed"; 
     //}
  }
	
  if (empty($SubjectID)) {
    $SubjectIDError = "SubjectID is required";
    
  } else {
		$SubjectID = test_input($_POST["SubjectID"]);

     //$name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
    // if (!preg_match("/^[a-zA-Z ]*$/",$ClassID)) {
      // $ClassIDError = "Only letters and white space allowed"; 
     //}
  }
  
    if (empty($SubjectName)) {
    $SubjectNameError = "SubjectName is required";
    
  } else {
    $SubjectName = test_input($_POST["SubjectName"]);
    }

/*presence check */
 
  	//echo "Failed";
 // 	fclose($file);//
  
// test to see if $errorMessage is blank
//if it is, then we can go ahead with the rest of the code
// if it's not, we can display the error

		//==========================================================
		//			Write to the database
		//==========================================================

	if ($SubjectIDError == ""){
		if ($SubjectNameError == "") {
			if($CategoryError == "") {
										
			$user_name = "root";
			$pass_word = "";
			$database = "schoolschedule";
			$server = "127.0.0.1";
		
			$db_handle = mysql_connect($server,$user_name,$pass_word);
			$db_found = mysql_select_db($database,$db_handle);
		
			if($db_found) {
				
				$SubjectID = quote_smart($SubjectID,$db_handle);
				$SubjectName = quote_smart($SubjectName,$db_handle);

				
				
				//=======================================================
				//		CHECK THAT THE ClassID IS NOT TAKEN
				//=======================================================
				
				$SQL = "SELECT * FROM subject WHERE SubjectID = '$SubjectID'";
				    
                              	$result = mysql_query($SQL);
                                	$num_rows = mysql_num_rows($result);

           		if($num_rows>0) {
	    		 		$SubjectIDError = "SubjectID already taken";
           		}
					else {
						$InsertionCheck="Insertion Successful";
						$SQL = "INSERT INTO subject (SubjectID,SubjectName,Category)
                 		                      VALUES (UPPER('$SubjectID'),'$SubjectName','$Category')";
                    	                   
                       		                $result = mysql_query($SQL);
                          		             mysql_close($db_handle);
           			}
           		}	
				//}
			}
		}
	}

?>

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
			<font color="red"><?php echo $SubjectIDError?></font><font color = "green"><?php echo $InsertionCheck ?></font>
		</td>
	</tr>
	<tr>
		<td>
			SubjectName:
		</td>
		<td>	
		 <input type="text" name="SubjectName" ><br>
		</td>
		<td>
			<font color="red"><?php echo $SubjectNameError; ?></font>
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
      <td>
      	<font color="red"><?php echo $CategoryError;?></font>
      </td>
	</tr>
		
	<tr>
		<td>	
			<input type="submit">
		</td>
		<td>
			<a href="SubjectInsertion.php"><button type="button">Return</button></a>		
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