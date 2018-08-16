<?php


error_reporting(0);
include("config.php");

$timeSO=$_POST["timeSO"];
$locationSO=$_POST["locationSO"];
$empid=$_POST["empid"];

$date=date("Y-m-d H:i:s");
session_start();
$dateonly=date("Y-m-d");
$id=$_SESSION["id"];
$fromPrd=$_SESSION["fromShuttleOutPrd"];
$fromPrd2=$_SESSION["fromShuttleOutPrd2"];


if (($timeSO=='999')||($locationSO=='999')||($empid=='')||($timeSO=='')||($locationSO=='')) {
	$_SESSION["submiterrorSO"]='1';
	if ($fromPrd>0) {
		//
		?>
		<script>
			window.location.replace("shuttleOutPrd.php");
		</script>
		<?php
	} if ($fromPrd2>0) {
		//
		?>
		<script>
			window.location.replace("shuttleOutPrd2.php");
		</script>
		<?php
	} else {
		//
		?>
		<script>
			window.location.replace("shuttleOut.php");
		</script>
		<?php
	}
	
} else {
	?>
	<font color="red">
	<?php
	
	if ($empid>0) {
		
		//user validation
		$sql = "SELECT * FROM mech_db where empID='$empid' AND disabled='0'";

		$result = $conn->query($sql);
		$row = $result->fetch_assoc(); 

		if ($result->num_rows > 0) {
			//
			$sqlemp = "SELECT * FROM kpi_mech.bussyslog_db WHERE empID='$empid' AND CAST(`modLog` AS DATE)='$dateonly'";
			
			$sql1 = "UPDATE kpi_mech.bussyslog_db SET destLoc='$locationSO',outTime='$timeSO',empIDrec='$id' WHERE empID='$empid' AND CAST(`modLog` AS DATE)='$dateonly'";
			
			$sql2 = "INSERT into kpi_mech.bussyslog_db (empID, empIDrec, destLoc, outTime) VALUES ('$empid','$id','$locationSO','$timeSO')";
		} else {
			//
			$_SESSION["submiterrorSOUser"]='1';
		}

	} else {
		//
		$sqlemp = "SELECT * FROM kpi_mech.bussyslog_db WHERE empID='$id' AND CAST(`modLog` AS DATE)='$dateonly'";
		
		$sql1 = "UPDATE kpi_mech.bussyslog_db SET destLoc='$locationSO',outTime='$timeSO' WHERE empID='$id' AND CAST(`modLog` AS DATE)='$dateonly'";
		
		$sql2 = "INSERT into kpi_mech.bussyslog_db (empID, destLoc, outTime) VALUES ('$id','$locationSO','$timeSO')";
	}
	
	//check if submitted already
	$resultemp = $conn->query($sqlemp);
	if ($resultemp->num_rows > 0) {

		if ($conn->query($sql1) === TRUE) {
			//header("location:home.php");
			$_SESSION["soUpdated"]='1';
			//echo "Shuttle Outgoing Record Successfully Updateder! ";

		} else {
			echo "Error: " . $sql1 . "<br>" . $conn->error;
		}

		} else {
			$_SESSION["testerror"]='1';
			//echo $sql1;

			if ($conn->query($sql2) === TRUE) {
				//header("location:home.php");
				$_SESSION["soSubmitted"]='1';
				//echo "Shuttle Outgoing Record Successfully Submitted! ";

			} else {
				echo "Error: " . $sql2 . "<br>" . $conn->error;
			}
		}
		if ($fromPrd>0) {
		//
			?>
			<script>
				window.location.replace("shuttleOutPrd.php");
			</script>
			<?php
		} if ($fromPrd2>0) {
			//
			?>
			<script>
				window.location.replace("shuttleOutPrd2.php");
			</script>
			<?php
		} else {
			//
			?>
			<script>
				window.location.replace("shuttleOut.php");
			</script>
			<?php
		}
		
	?>
	</font>
	<?php	
}
$conn->close();




?>
