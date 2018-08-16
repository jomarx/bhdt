<!DOCTYPE html>

<?php
$page = $_SERVER['PHP_SELF'];
$sec = "600";
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
session_start();

$style1 = "<td style = 'wlocationth: 150px; border: 4px solid black; background-color: #ff6666; ' align='center'>";//(red)
$style2 = "<td style = 'wlocationth: 150px; border: 4px solid black; background-color: #ffffff; ' align='center'>";//(white)
$style3 = "<td style = 'wlocationth: 150px; border: 4px solid black; background-color: #ffff00; ' align='center'>";//(yellow)
$style4 = "<td style = 'wlocationth: 150px; border: 4px solid black; background-color: #22CA2F; ' align='center'>";//(green)
$style5 = "<td style = 'wlocationth: 150px; border: 4px solid black; background-color: #82caff; ' align='center'>";//format if StartTime = 0 (sky blue)
$style6 = "<td style = 'wlocationth: 150px; border: 4px solid black; background-color: #FF5733; ' align='center'>";//format if StartTime = 0 (reddish kuno)

if ($_SESSION["id"]!="827000"){
	header('location:meeting.php');
}

echo "<center>";
echo "<span style='font-size: 25pt'>";
//echo date("m/d/Y H:i:s");
//echo "<BR><b>Task Database (for reports)</b><BR><BR>";
echo "</span>";

try {
		
//	$sql = "SELECT * from mbreak_db";
		$sql = "SELECT usersdb.FirstName, usersdb.LastName, logintrials_db.username, logintrials_db.password, logintrials_db.loginsrc, logintrials_db.type, logintrials_db.logdate, logintrials_db.auto_num FROM `logintrials_db` inner JOIN usersdb ON logintrials_db.username=usersdb.empID WHERE logintrials_db.auto_num > 0 ORDER by logintrials_db.logdate DESC limit 2000";

	$result = $conn->query($sql);
    		
	
	if ($result->num_rows > 0) {
		echo "<span style='font-size: 15pt'>";
		echo "<table style='border:4px solid black; width: 100%'>";
		//echo "<font size='30'>";
		echo "<tr><th>Login ID</th><th>First Name</th><th>Last Name</th><th>User ID</th><th>Password</th><th>Source Computer</th><th>Login Type</th><th>Log Date</th></tr>";
		echo "</span>";
		
		// <th>SpecialSerial</th><th>StartDate</th><th>EndDate</th><th>Details</th>
		// output data of each row
		while($row = $result->fetch_assoc()){
			
			if (($row["type"]=='0')&&($row["password"]=='kiosk')){
				$style=$style4;
			}
			else if (($row["type"]=='0')&&($row["password"]!='kiosk')) {
				$style=$style5;
			}
			else if ($row["type"]=='1') {
				$style=$style3;
			}
			else if ($row["type"]=='2'){
				$style=$style1;
			}
			else if ($row["type"]=='3'){
				$style=$style6;
			}
			else {
				$style=$style2;
			}
			
			echo "<tr>";
			echo $style.$row["auto_num"]."</td>";
			echo $style.$row["FirstName"]."</td>";
			echo $style.$row["LastName"]."</td>";
			echo $style.$row["username"]."</td>";
			echo $style.$row["password"]."</td>";
			if ($row["loginsrc"]=='192.168.143.206') {
				//
				echo $style."Lobby Kiosk"."</td>";
			} else if ($row["loginsrc"]=='192.168.143.205') {
				//
				echo $style."QCO Laptop"."</td>";
			} else if ($row["loginsrc"]=='192.168.143.204') {
				//
				echo $style."Plant D Kiosk"."</td>";
			} else {
				echo $style.$row["loginsrc"]."</td>";
			}
			if (($row["type"]=='0')&&($row["password"]=='kiosk')) {
				//
				echo $style."Successful login from kiosk"."</td>";
			} else if (($row["type"]=='0')&&($row["password"]!='kiosk')) {
				//
				echo $style."Successful login"."</td>";
			} else if ($row["type"]=='1') {
				//
				echo $style."Wrong Username/password"."</td>";
			} else if ($row["type"]=='2') {
				//
				echo $style."login of disabled user"."</td>";
			} else if ($row["type"]=='3') {
				//
				echo $style."change pasword"."</td>";
			} else {
				echo $style.$row["type"]."</td>";
				//echo "<td>"."Undefined"."</td>";
			}
			echo  $style.$row["logdate"]."</td>";
		
			echo "</tr>";
    		
			}
	
		echo "</table>";
		echo "</center>";
		echo "<BR><b>User logs </b><BR><BR>";
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

</body>
</html>
