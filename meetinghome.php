<html>
<head>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/submit.js"></script>

<center>
<font color="red"><b>
<?php
include("config.php");
session_start();
error_reporting(0);

if ($_SESSION["id"]==""){
	header('location:meeting.php');
}

if ($_SESSION["cPsuccess"]=="1"){
	echo "Password change successful. ";
	unset($_SESSION["cPsuccess"]);
}

//remove from memory
if (isset($_SESSION["fromShuttleOutPrd"])){
	unset($_SESSION["fromShuttleOutPrd"]);
}

//remove from memory
if (isset($_SESSION["fromsSp"])){
	unset($_SESSION["fromsSp"]);
}

?>
<br>
</head>
</b>
</font>
<body>

<br>
<?php

//source location for go back home/back redirect
//1 = home.php
//2 = meetinghome.php
$_SESSION["sourceLoc"]='2';

$userid=$_SESSION["id"];
$_SESSION["mechSvr"]='0';

//defines redirect source
$_SESSION["meetingOutSrc"]="1";

$sql = "SELECT * FROM usersdb where empID='$userid'";
$result = $conn->query($sql);
$row = $result->fetch_assoc(); 
if ($result->num_rows > 0) {
		
		echo "Hello! <b>";	
		echo $row["FirstName"];
		echo " ";		
		echo $row["LastName"]." - Emp ID: ".$userid."</b>";
		echo ",   ano ang gusto mo gawin ngayon ? :<br><br>";	
	
	//should be regular only
	if ($row["admin"]=='1'){
		?>
		<BR>
		<a href="attn.php">User Attendance</a><br><br>
		<?php
	}
	?>
	<BR><BR><a href="OutPrd.php">Monthly Training Quiz / Surveys</a><BR><BR>
	<BR><BR><a href="OutLog.php">Points History</a><BR><BR>
	<?php
}

if ($row["superSU"]=='1'){
	echo "<b>SuperUser Mode!</b><br><br>";
	?>
		<a href="userlogs.php">User Logs</a><BR><BR>
		<?php
}
?>

<?php
$conn->close();
?>
<br><br>
	
<a href="meetinglogout.php">Logout</a>
</center>


</body>
</html>