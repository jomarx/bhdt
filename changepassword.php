<html>
<body>
<center>
<!DOCTYPE html>

<?php
include("config.php");
session_start();
error_reporting(0);

if ($_SESSION["id"]==""){
	header('location:meeting.php');
}

$userid=$_SESSION["id"];
$sql = "SELECT * FROM usersdb where empID='$userid'";
$result = $conn->query($sql);
$row = $result->fetch_assoc(); 
if ($result->num_rows > 0) {
	//
	echo "<b>Hello! ";	
		echo $row["FirstName"];
		echo " ";		
		echo $row["LastName"]." - Emp ID: ".$userid."</b>";
}
//
?>
<form action="confirmchpwd.php" method="POST" id="myformer">
	<b><p>Please change your Password Below :</p></b><br>
	<b><p>Rules :</p></b>
	<i><p>Letters and numbers only </p></i>
	<i><p>No Special characters</p></i>
	<i><p>Minimum 5, maximum 8 characters </p></i><br>
	<input type="password" minlength="5" maxlength="8" name="password1" id="password1" placeholder="New password " required ><br><br>
	<input type="password" minlength="5" maxlength="8" name="password2" id="password2" placeholder="Retype new password " required ><br><br>
	<input type="submit" value="Submit" name="submit" id="submit" >
</form>
<b>
<font color="red">
<?php
//

if ($_SESSION["cPsuccess"]=="2"){
	echo "Password change unsuccessful, password entered not the same. Please try again. ";
	unset($_SESSION["cPsuccess"]);
}
?>
</font></b>
</center>
</body>
</html>

