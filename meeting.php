<html>
<?php
$page = $_SERVER['PHP_SELF'];
$sec = "3600";
include("config.php");
session_start();
error_reporting(0);

if ($_SESSION["id"]!=""){
	header('location:meetinghome.php');
}
?>
<body>
<center><b>
<img src="captiveportal-logo.jpg">
<BR><p>Beauty Herbs Health and Wellness Hub<BR><BR>Multi System Login</p>
</b>
<form action="meetinglogin.php" method="POST" id="myform">
<input type="text" name="userid" id="userid" placeholder="User ID"><BR><BR>
<input type="password" name="password" id="password" placeholder="Password"><BR><BR>

<font color="red">
<?php
if (isset($_SESSION["error1"])){
	echo "Wrong username and/or password!<br><br>";
	unset($_SESSION["error1"]);
}
if (isset($_SESSION["error2"])){
	echo "Your userid is currently disabled<br><br>";
	unset($_SESSION["error2"]);
}
?>
</font>
<input type="submit" value="submit" name="submit" id="submit" ><br><br>

<?php

$sql = "SELECT * FROM `db_annc` where `status`='1' ORDER BY `id` DESC";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo "<span style='font-size: 15pt'>";
		echo "<table align='center', style='border:4px solid black; width: 50%'>";
		//echo "<font size='30'>";
		echo "<tr><th style = 'background-color: #ffff00;'>Announcements</th></tr>";
		
		// <th>SpecialSerial</th><th>StartDate</th><th>EndDate</th><th>Details</th>
		// output data of each row
		while($row = $result->fetch_assoc()) {
	
			echo "<tr>";
			echo "<td align='center'>".$row["content"]."</td>";
			echo "</tr>";	
	}
	echo "</span>";
	echo "</table>";
	} else {
		echo ":D";
	}

?>

</center>


</form>
</body>
</html>