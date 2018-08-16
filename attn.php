<!DOCTYPE html>

<?php
$page = $_SERVER['PHP_SELF'];
$sec = "10";
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

<?php
include("config.php");
echo "<center>";
echo "<span style='font-size: 25pt'>";
//echo date("m/d/Y H:i:s");
//echo "<BR><b>Task Database</b><BR><BR>";
echo "</span>";

try {
	//Start connection
	
//	$sql = "SELECT * from mbreak_db";
		$sql = "SELECT usersdb.FirstName, usersdb.LastName, attnlog.num, attnlog.empID, attnlog.datetime, attnlog.datetimeOut, attnlog.status FROM attnlog inner JOIN usersdb ON attnlog.empID=usersdb.empID ORDER BY `num` DESC";

	$result = $conn->query($sql);
    		
	
	if ($result->num_rows > 0) {
		echo "<span style='font-size: 15pt'>";
		echo "<table style='border:4px solid black; width: 100%'>";
		//echo "<font size='30'>";
		echo "<tr><th>num</th><th>empID</th><th>FirstName</th><th>LastName</th><th>Date In</th><th>Date Out</th><th>Duration</th></tr>";
		echo "</span>";
		
		// <th>SpecialSerial</th><th>datetime</th><th>datetimeOut</th><th>Details</th>
		// output data of each row
		while($row = $result->fetch_assoc())
		{
			
			$to_time = strtotime($row["datetimeOut"]);
			$from_time = strtotime($row["datetime"]);
			$duration = round(abs($to_time - $from_time) / 60,2);

			
			echo "<tr>";
			echo "<td>".$row["num"]."</td>";
			echo "<td>".$row["empID"]."</td>";
			echo "<td>".$row["FirstName"]."</td>";
			echo "<td>".$row["LastName"]."</td>";
			echo "<td>".$row["datetime"]."</td>";
			echo "<td>".$row["datetimeOut"]."</td>";
		if (($duration >=60)&&($duration <1440)){
			$duration=$duration/60;
		
		if ($duration >1){
		echo "<td>".$duration."Hours</td>";
		}
		else{
		echo "<td>".$duration."Hour</td>";
			
		}
		}
		else if ($duration >= 1440) {
			$duration=$duration/1440;
			$dur =floor($duration);
		if ($dur<1){
		echo "<td>".$dur." Days</td>";
		}
		else{
		echo "<td>".$dur." Day</td>";
			
		}
			
		}
		else{
		if ($duration >1){
		echo "<td>".floor($duration)." Minutes</td>";
		
		}
		else{
		echo "<td>".floor($duration)." Minute</td>";
			
		}
		}
			
		
			echo "</tr>";
    		
			}
	
		echo "</table>";
		echo "</center>";
		echo "<BR><b>Attendance Records</b><BR><BR>";
	}
	else {
    		echo "No results";
	}
	
	
	
	
	
	
}
catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
}
$conn = null;
?>
<br>
<a href="meetinghome.php">Back to Main Menu</a><BR>
<a href="meetinglogout.php">Exit Session</a>
</body>
</html>
