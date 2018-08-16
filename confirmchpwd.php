<?php
if (isset($_POST["submit"])){
include("config.php");
$string1=$_POST["password1"];
$string2=$_POST["password2"];
session_start();
/*
if ($_SESSION["id"]==""){
	header("location:meeting.php");
}*/
echo "start2";
if(ctype_alnum($string1)){
	echo "Yes, It's an alphanumeric string/text";
	
	if ($string1==$string2) {
		//
		$_SESSION["cPsuccess"]="1";
		$id=$_SESSION["id"];
		$sql="UPDATE usersdb set password='$string1' WHERE empID='$id'";
		$conn->query($sql);
		header('location:meetinghome.php');

	} else {
		//sets error message, differnt password entered
		$_SESSION["cPsuccess"]="2";
		header("location:changepassword.php");
	}
	
	
}
else{
	$_SESSION["not"]="1";
	header("location:changepassword.php");
	echo "No, It's not an alphanumeric string/text";
}

$conn->close();
}
?>