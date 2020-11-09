<?php 
	session_start();
	$user_name = "root";
	$pass_word = "";
	$database = "schoolschedule";
	$server = "127.0.0.1";
	$db_handle = mysql_connect($server,$user_name,$pass_word);
	$db_found = mysql_select_db($database,$db_handle); $SQLclass = "SELECT * FROM class";
	$classresult = mysql_query($SQLclass);
	
	@$UserName=$_SESSION['UserName'];
	@$TeacherID=$_SESSION['ID'];	
?>
<html>
<head>
<link href="MyStyle.css" type="text/css" rel="stylesheet">
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><title>Schedule Generation</title>

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
		<li><a class="active"  href="ScheduleGeneration.php">Generate Schedule</a></li>
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
<h1>Generate Schedule</h1>
<table
 style="width: 100%; height: 516px; text-align: left; margin-left: auto; margin-right: auto;"
 background="tablebackground.png" border="1"
 cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td><br>
      <table
 style="width: 100%; height: 100%; text-align: left; margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td style="text-align: center;">
            <div style="color: rgb(96, 56, 19);">
            <h2>Assembly, Chapel and CCA</h2>
            </div>
<?php //========================== Check that the user assigned the subject Assembly=====================================================
	$SQLAssCpl = "SELECT * FROM assignment WHERE SubjectID='ASS' OR SubjectID='CPL'"; 
		$SQLAssCplResult = mysql_query($SQLAssCpl);
	$RowsOfAssCpl = mysql_num_rows($SQLAssCplResult);
	if($RowsOfAssCpl==0) { ?>
            <div style="position: absolute; top: 336px; left: 12px;">
            <font size="3">Click This! </font></div>
            <img src="animated-arrow-image-0506.gif"
 style="position: absolute; top: 330px; left: 88px;"><a
 href="AssCplWarning.php"><img
 style="border: 0px solid ; width: 328px; height: 326px;" alt=""
 src="AssemblyChapel.png"></a><br>
<?php 
	}else if($RowsOfAssCpl==2){
?>
            <img
 style="border: 0px solid ; width: 328px; height: 326px;" alt=""
 src="AssemblyChapel.png"><?php }
//==================================================================================================================================
?> </td>
            <td>
            <table
 style="width: 100%; height: 100%; text-align: left; margin-left: auto; margin-right: auto;"
 border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td style="text-align: center;">
                  <div style="color: rgb(96, 56, 19);">
                  <h2>Music</h2>
                  </div>
<?php 
	$SQLMusAss = "SELECT * FROM assignment WHERE SubjectID='MUS'";
		$SQLMusAssResult = mysql_query($SQLMusAss);
	$RowsOfMusinAss = mysql_num_rows($SQLMusAssResult);
	$SQLClass = "SELECT * FROM class WHERE ClassID<>'ALL'";
		$SQLClassResult = mysql_query($SQLClass);
	$RowsOfClasses = mysql_num_rows($SQLClassResult); if($RowsOfAssCpl==0){
?>
                  <img
 style="border: 0px solid ; width: 328px; height: 326px;" alt=""
 src="mus.png">
 <?php 
 } else if(($RowsOfClasses!=$RowsOfMusinAss)&&($RowsOfAssCpl==2)) { ?>
                  <div
 style="position: absolute; top: 336px; left: 31%;"> <font
 size="3">Click This! </font></div>
                  <img src="animated-arrow-image-0506.gif"
 style="position: absolute; top: 330px; left: 36.5%;"><a
 href="Music.php"><img
 style="border: 0px solid ; width: 328px; height: 326px;" alt=""
 src="mus.png"></a><br>
<?php 
	}else if($RowsOfClasses==$RowsOfMusinAss) {
?>
                  <img
 style="border: 0px solid ; width: 328px; height: 326px;" alt=""
 src="mus.png"><?php } ?> </td>
                </tr>
              </tbody>
            </table>
            </td>
            <td style="text-align: center;">
            <div style="color: rgb(96, 56, 19);">
            <h2 style="">Schedule Generation</h2>
            </div>
<?php //========================== Check that the user assigned the subjects Assembly, Music and Chapel===================================
	$SQLMusAss = "SELECT * FROM assignment WHERE SubjectID='MUS'"; 
		$SQLMusAssResult = mysql_query($SQLMusAss);
	$RowsOfMusinAss = mysql_num_rows($SQLMusAssResult);
	$SQLClass = "SELECT * FROM class WHERE ClassID<>'ALL'";
		$SQLClassResult = mysql_query($SQLClass);
	$RowsOfClasses = mysql_num_rows($SQLClassResult); 
	$SQLAssCpl = "SELECT * FROM assignment WHERE SubjectID='ASS' OR SubjectID='CPL'";
		$SQLAssCplResult = mysql_query($SQLAssCpl);
	$RowsOfAssCpl = mysql_num_rows($SQLAssCplResult); 
	if($RowsOfAssCpl==2) {
		if($RowsOfClasses==$RowsOfMusinAss) { //==================================================================================================================================
?>
            <div style="position: absolute; top: 336px; left: 64%;">
            <font size="3">Click This! </font></div>
            <img src="animated-arrow-image-0506.gif"
 style="position: absolute; top: 330px; left: 69.5%;"> <a
 href="ScheduleGenerationWarning.php"><img
 style="border: 0px solid ; width: 328px; height: 326px;" alt=""
 src="GenerateSchedule.png"></a>
 <?php 
 		}else {
?>
            <img
 style="border: 0px solid ; width: 328px; height: 326px;" alt=""
 src="GenerateSchedule.png">
 <?php }
	}else {
?>
            <img
 style="border: 0px solid ; width: 328px; height: 326px;" alt=""
 src="GenerateSchedule.png">
 <?php 
 } 
 ?>
            </td>
          </tr>
          <tr>
            <td style="text-align: center;"><a
 href="ResetSchedule.php"><button type="button"
 style="height: 75px; width: 150px;">Reset Class Schedule</button></a></td>
            <td style="text-align: center;"><a
 href="home.php"><img
 style="border: 0px solid ; width: 100px; height: 100px;" alt=""
 src="back-icon-clipart-1.png"></a></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
  </tbody>
</table>
</div>
</body>
</html>