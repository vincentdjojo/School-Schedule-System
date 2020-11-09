<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";


		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);
	

?>

<center>
<font  color="red"><h2>Warning</h2></font>
<br>
<table>
<tr>
	<td>
		<a href="AssemblyChapel.php"><button type="button" style="height:50px; width:50px">Proceed</button></a>
	</td>
</tr>
<tr>
	<td>
		<a href="InsertionMenu.php"><button type="button" style="height:50px; width:50px">Cancel</button></a>
	</td>
</tr>
</table>
</center>
