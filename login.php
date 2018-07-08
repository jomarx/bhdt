<?php

error_reporting(0);
include("config.php");
$userid=$_POST["userid"];
session_start();

$sql = "SELECT * FROM `usersdb` where empID='$userid' AND status='1'";

$result = $conn->query($sql);
$row = $result->fetch_assoc(); 

if ($result->num_rows > 0) {
	
	$sqllogin = "SELECT * FROM `attnlog` where empID='$userid' AND status='1'";

	$result2 = $conn->query($sqllogin);
	$row2 = $result2->fetch_assoc(); 

	if ($result2->num_rows > 0) {

		$sqlok = "INSERT INTO `attnlog` (empID, datetime, status,type) VALUES ('$userid', curtime(),'0','0')";
		$result1 = $conn->query($sqlok);
		$_SESSION["InsertSuccessBye"]=1;
		$_SESSION["empID"]=$userid;
		
		$sqlok = "UPDATE attnlog SET status = 0 where empID='$userid' AND status='1'";
		$result1 = $conn->query($sqlok);
		?>
		<script>
			window.location.replace("index.php");
		</script>
		<?php
	} else {
		//
		$sqlok = "INSERT INTO `attnlog` (empID, datetime, status,type) VALUES ('$userid', curtime(),'1','1')";
		$result1 = $conn->query($sqlok);
		$_SESSION["InsertSuccessHi"]=1;
		$_SESSION["empID"]=$userid;
		
		?>
		<script>
			window.location.replace("index.php");
		</script>
		<?php
	}
} 
else {
	$_SESSION["InsertFailed"]=1;
	?>
	<script>
		window.location.replace("index.php");
	</script>
	<?php
//
}
$conn->close();

?>