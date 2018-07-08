<html>
<head>
</head>
<?php
$page = $_SERVER['PHP_SELF'];
$sec = "3600";
include("config.php");
session_start();
error_reporting(0);
?>
<body>
<b><center><br><img src="captiveportal-logo.jpg">
<p>Attendance System<br><BR>Please Scan your ID : </p>
<form action="login.php" method="post" id="myform">
<input type="password" name="userid" id="userid" placeholder="userid" autofocus>

<button id="submit" >SUBMIT</button>
<br>
<br>
<br>


</form>
<font color="red">
<?php
if (isset($_SESSION["InsertSuccessHi"])){
	echo "Login successful!<br>";
	$userid=$_SESSION["empID"];
	
	$sql = "SELECT * FROM `usersdb` where empID='$userid'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc(); 
	if ($result->num_rows > 0) {
			echo "<br>Hello! <b>";	
			echo $row["FirstName"];
			echo " ";		
			echo $row["LastName"]." </b>";	
	}
	unset($_SESSION["InsertSuccessHi"]);
}

if (isset($_SESSION["InsertSuccessBye"])){
	echo "Login successful!<br>";
	$userid=$_SESSION["empID"];
	
	$sql = "SELECT * FROM `usersdb` where empID='$userid'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc(); 
	if ($result->num_rows > 0) {
			echo "<br>Goodbye! <b>";	
			echo $row["FirstName"];
			echo " ";		
			echo $row["LastName"]." </b>";	
	}
	unset($_SESSION["InsertSuccessBye"]);
}

if (isset($_SESSION["InsertFailed"])){
	echo "<br>Login Failed! Please try again";
	unset($_SESSION["InsertFailed"]);
}
//session_destroy();
?>
</font></center></b>
</body>
</html>
