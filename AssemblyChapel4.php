<?php
		$user_name = "root";
		$pass_word = "";
		$database = "schoolschedule";
		$server = "127.0.0.1";
		
		$db_handle = mysql_connect($server,$user_name,$pass_word);
		$db_found = mysql_select_db($database,$db_handle);

		$SQL = "SELECT * FROM assignment WHERE SubjectID = 'ASS'";
		$result=mysql_query($SQL);		
		
		while($db_field=mysql_fetch_assoc($result)) {
			$ASS=$db_field["SubjectID"];
			$AssPeriodDay=$db_field["PeriodDay"];
			$AssPeriodTime=$db_field["PeriodTime"];
		
				
?>
<center>
	<h2>
		Results for Assembly and Chapel	
	</h2>
	<table>
		<tr>
			<td>
				<a href="AssemblyChapel.php"><button type="button">Reset</button></a> 		
			</td>
			<td>
				<a href="SelectClass.php"><button type="button">Select Class</button></a> 				
			</td>		
		</tr>
				
	</table>
	<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center">
		<div align="center" style="font-family: Arimo;">
			<tr>
				<td>
					Subject:
				</td>
				<td>
					<?php echo $ASS?>
				</td>
			</tr>
			<tr>
				<td>
					Day
				</td>
				<td>
					<?php echo $AssPeriodDay;?>
				</td>
			</tr>
			<tr>
				<td>
					Period Time:
				</td>
				<td>
					<?php echo $AssPeriodTime; ?>
				</td>
			</tr>
		</div>
	</table>
</center>			

<?php 
}		

		$SQL = "SELECT * FROM assignment WHERE SubjectID = 'CPL'";
		$result=mysql_query($SQL);		
		while($db_field=mysql_fetch_assoc($result)) {
			$CPL=$db_field["SubjectID"];
			$CPLPeriodDay=$db_field["PeriodDay"];
			$CPLPeriodTime=$db_field["PeriodTime"];
		
				
?>

	<table border="1" cellpadding="0" style="border-spacing: 0px; height: 40%; width: 50%;" align="center">
		<div align="center" style="font-family: Arimo;">
			<tr>
				<td>
					Subject:
				</td>
				<td>
					<?php echo $CPL?>
				</td>
			</tr>
			<tr>
				<td>
					Day
				</td>
				<td>
					<?php echo $CPLPeriodDay;?>
				</td>
			</tr>
			<tr>
				<td>
					Period Time:
				</td>
				<td>
					<?php echo $CPLPeriodTime; ?>
				</td>
			</tr>
		</div>
	</table>
<?php
		}
?>