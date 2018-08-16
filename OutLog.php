<!DOCTYPE html>

<?php
$page = $_SERVER['PHP_SELF'];
$sec = "30";
include("config.php");
session_start();
?>
<html>
    <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
	<style>
	td {
		
		border:1px solid black;
		font-size: 15px	;
	}
		th {
		font-size: 15px	;
		border:1px solid black;
	}

	</style>
<body>
<BR>
<?php
//logout auto menu
if ($_SESSION["sourceLoc"]=='2') {
	//from meetinghome
	?>
	<a href="meetinghome.php">Back to Main Menu</a><BR>
	<a href="meetinglogout.php">Exit Session</a>
	<?php
} else if ($_SESSION["sourceLoc"]=='1') {
	//from home
	?>
	<a href="home.php">Back to Main Menu</a><BR>
	<a href="signout.php">Exit Session</a>
	<?php
} else {
	//javascript back
	echo "<a href='javascript:history.back(1);'>Back to main menu</a>";
}
?>
<?php
echo "<center><br>";
echo "<span style='font-size: 25pt'>";
//echo date("m/d/Y H:i:s");
//echo "<BR><b>Mechanic Status</b><BR><BR>";
echo "</span>";



		$sql = "SELECT * FROM `bussyslog_db` INNER JOIN `mech_db` on `bussyslog_db`.`empID`=`mech_db`.`empID` where `bussyslog_db`.`num`>'0' ORDER BY `bussyslog_db`.`num` DESC";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo "<span style='font-size: 15pt'>";
		echo "<table style='border:4px solid black; width: 100%'>";
		//echo "<font size='30'>";
		echo "<tr><th>movement ID</th><th>Encoder</th><th>First Name</th><th>Last Name</th><th>Destination</th><th>Time</th><th>Source</th></tr>";
		echo "</span>";
		
		// <th>SpecialSerial</th><th>StartDate</th><th>EndDate</th><th>Details</th>
		// output data of each row
		while($row = $result->fetch_assoc()) {
			
			//$to_time = $row["status"];
	
			echo "<tr>";
			echo "<td>".$row["num"]."</td>";
			echo "<td>".$row["empIDrec"]."</td>";
			echo "<td>".$row["FirstName"]."</td>";
			echo "<td>".$row["LastName"]."</td>";
			
			if ($row["destLoc"]=='999') { echo "<td>"."Error"."</td>"; }
			else if ($row["destLoc"]=='1') { echo "<td>"."Alabang"."</td>"; }
			else if ($row["destLoc"]=='2') { echo "<td>"."Carmona"."</td>"; }
			else if ($row["destLoc"]=='3') { echo "<td>"."San Pedro"."</td>"; }
			else if ($row["destLoc"]=='4') { echo "<td>"."Pavillion"."</td>"; }
			else if ($row["destLoc"]=='5') { echo "<td>"."Balibago"."</td>"; }
			else if ($row["destLoc"]=='6') { echo "<td>"."Cabuyao"."</td>"; }
			else if ($row["destLoc"]=='7') { echo "<td>"."Mamatid"."</td>"; }
			else if ($row["destLoc"]=='8') { echo "<td>"."Calamba"."</td>"; }
			else if ($row["destLoc"]=='9') { echo "<td>"."Mamplasan"."</td>"; }
			else { echo "<td>".$row["destLoc"]."</td>"; }
			
			if ($row["outTime"]=='999') { echo "<td>"."Error"."</td>"; }
			else if ($row["outTime"]=='1') { echo "<td>"."2PM"."</td>"; }
			else if ($row["outTime"]=='2') { echo "<td>"."5PM"."</td>"; }
			else if ($row["outTime"]=='3') { echo "<td>"."6PM"."</td>"; }
			else if ($row["outTime"]=='4') { echo "<td>"."6AM"."</td>"; }
			else if ($row["outTime"]=='5') { echo "<td>"."10PM"."</td>"; }
			else if ($row["outTime"]=='6') { echo "<td>"."3PM"."</td>"; }
			else if ($row["outTime"]=='7') { echo "<td>"."4PM"."</td>"; }
			else if ($row["outTime"]=='8') { echo "<td>"."7PM"."</td>"; }
			else if ($row["outTime"]=='9') { echo "<td>"."8PM"."</td>"; }
			else if ($row["outTime"]=='10') { echo "<td>"."9PM"."</td>"; }
			else if ($row["outTime"]=='11') { echo "<td>"."4AM"."</td>"; }
			else if ($row["outTime"]=='12') { echo "<td>"."5AM"."</td>"; }
			else { echo "<td>".$row["outTime"]."</td>"; }
			
			echo "<td>".$row["modLog"]."</td>";	
			echo "</tr>";
    		
	}
	
		echo "</table>";
		echo "</center>";
		echo "<BR><b>Shuttle Scheduling Movement</b><BR><BR>";
} else {
    		echo "No results";
}
$conn->close();
?>

</body>
</html>
