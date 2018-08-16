<?php

include("config.php");
$userid=$_POST["userid"];
$password=$_POST["password"];
session_start();


$sql = "SELECT * FROM usersdb where empID='$userid' AND password='$password'";
$result = $conn->query($sql);
$row = $result->fetch_assoc(); 

$loginsrc1=gethostbyaddr($_SERVER['REMOTE_ADDR']);

if ($result->num_rows > 0) {
//valid account

	if ($row["disabled"]==1){
		//checks if disabled account
		$_SESSION["error2"]=1;
		
		//insert logs (login of disabled user = 2)
		$sql1 = "INSERT INTO logintrials_db (username, password, type, loginsrc) VALUES ('$userid','$password','2', '$loginsrc1')";
		
		$result1 = $conn->query($sql1);
		header("location:meeting.php");
		
	} else if ($row["empID"]==$row["password"]){
		//set logged user
		$_SESSION["id"]=$row["empID"];
		
		//insert logs (change pasword = 3)
		$sql1 = "INSERT INTO logintrials_db (username, password, type, loginsrc) VALUES ('$userid','$password', '3', '$loginsrc1')";
		$result1 = $conn->query($sql1);
		
		//change password site
		header("location:changepassword.php");
		
	} else {
		//set logged user
		$_SESSION["id"]=$row["empID"];
		
		//insert logs (successful login = 0)
		$sql1 = "INSERT INTO logintrials_db (username, password, type, loginsrc) VALUES ('$userid','$password', '0', '$loginsrc1')";
		$result1 = $conn->query($sql1);
		header("location:meetinghome.php");
	}
} else {
	$_SESSION["error1"]=1;
	
	//insert logs (wrong username/password = 1)
	$sql1 = "INSERT INTO logintrials_db (username, password, type, loginsrc) VALUES ('$userid','$password','1', '$loginsrc1')";
	$result1 = $conn->query($sql1);
	header("location:meeting.php");
}
$conn->close();


?>