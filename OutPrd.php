<html>
<head>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/submit.js"></script>
</head>
<center>
<body>
<style>
body{
	font-size: 13pt;	
}
table {
    border-collapse: collapse;
	width: 50%;
}
tr:hover {
	background-color: #99ccff;
	}
tr {
	font-size: 13pt;	
	border-style: solid;
	border: 2px solid black;
}
th {
	font-size: 13pt;	
	border-style: solid;
	border: 2px solid black;
}
td {
	border-style: solid;
	border: 2px solid black;
}
</style>
<b>
<font color=red>
<?php
error_reporting(0);
session_start();
include("config.php");

$style1 = "<td style = 'wlocationth: 150px; border: 4px solid black; background-color: #ff6666; font-size: 25px; ' align='center'>";//format if StartTime exceed $limit in minutes (red)

$userid=$_SESSION["id"];

if ($_SESSION["id"]==""){
	header('location:meeting.php');
}

//set source from PRD
$_SESSION["fromShuttleOutPrd"]='1';

if (isset($_SESSION["submiterrorSO"])){
	echo "Wrong data encoded, please try again!<br>";
	unset($_SESSION["submiterrorSO"]);
}

if (isset($_SESSION["submiterrorSOUser"])){
	echo "Wrong user encoded, please try again!<br>";
	unset($_SESSION["submiterrorSOUser"]);
}

if (isset($_SESSION["soUpdated"])){
	echo "Shuttle Outgoing Record Successfully Updated! ";
	unset($_SESSION["soUpdated"]);
}
if (isset($_SESSION["soSubmitted"])){
	echo "Shuttle Outgoing Record Successfully Submitted! ";
	unset($_SESSION["soSubmitted"]);
}

$mechSvr=$_SESSION["mechSvr"];
//echo "mechSvr: ".$mechSvr;
//$NotifNo=$_SESSION["NotifNoRp"];

//time settings
//https://stackoverflow.com/questions/15911312/how-to-check-if-time-is-between-two-times-in-php
//https://stackoverflow.com/questions/38377537/check-time-between-two-times
//cutoff settings
//12/11 - added additional 1 hour grace period
$out2pmBefore = new DateTime('11:30');
$out6pmBefore = new DateTime('15:30');
$out5pmBefore = new DateTime('14:30');
$out3pmBefore = new DateTime('12:30');
$out10pmBefore = new DateTime('19:30');
$out6amBefore = new DateTime('3:30');
$out6amBefore1 = new DateTime('20:00');
$no1wkuno = new DateTime('03:31');
$nowkuno = new DateTime();

if (($nowkuno <= $out2pmBefore)||($nowkuno <= $out6pmBefore)||($nowkuno <= $out5pmBefore)||($nowkuno <= $out10pmBefore)||($nowkuno <= $out6amBefore)||($nowkuno >= $out6amBefore1)) {
	//
	?>
	</font><br>
	<?php
	$sql = "SELECT * FROM mech_db where empID='$userid'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc(); 
	if ($result->num_rows > 0) {
			echo "Hello! <b>";	
			echo $row["FirstName"];
			echo " ";		
			echo $row["LastName"]." - Emp ID: ".$userid."</b>";
	}

	?>
	<p>Destination :</p>
	<form action="soReport.php" method="post" id="myform">

	<select name="locationSO" id="locationSO">
	<option value="999">SELECT</option>
	<?php
	$sql = "SELECT * FROM bussysdest_db";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		?>
		<option value="<?php echo $row["num"] ?>"><?php echo $row["location"] ?></option>
		<?php
	}

	?>

	</select>
	<br>
	<p>Outgoing Time :</p>
	<select name="timeSO" id="timeSO">
		<option value="999">SELECT</option>
		<?php
		if ($nowkuno <= $out2pmBefore) {
			//output
			?>
				<option value="1">2PM</option>
			<?php
		}
		if ($nowkuno <= $out3pmBefore) {
			//output
			?>
				<option value="6">3PM</option>
			<?php
		}
		if ($nowkuno <= $out5pmBefore) {
			//output
			?>
				<option value="2">5PM</option>
			<?php
		}
		if ($nowkuno <= $out6pmBefore) {
			//output
			?>
				<option value="3">6PM</option>
			<?php
		}
		if ($nowkuno <= $out10pmBefore) {
			//output
			?>
				<option value="5">10PM</option>
			<?php
		}
		if (($nowkuno <= $out6amBefore)||($nowkuno >= $out6amBefore1)) {
			//output
			?>
				<option value="4">6AM</option>
			<?php
		}
		echo "wee";
		?>

	</select>
	<br>
	<p>Employee ID :</p>
	<input type="text" name="empid" id="empid" placeholder="ID number" autofocus>
	<br><br>
	<button name="submit" id="submit" >SUBMIT</button>
<?php

} else {
	echo "<br><br><p>No available Shuttle slots, please try again earlier next time</p>";
}

?>
<script>

$('#myform').submit(function(){
 return false;
});
 
$('#submit').click(function(){


 $.post( 
 $('#myform').attr('action'),
 $('#myform :input').serializeArray(),
 function(result){
 $('#result1').html(result);
 }
 );

 
});

</script>
 

 <p class="alert alert-success" id='result1'></p>



</form></b>
<table>
<tr style="background-color: #663399; color: white;">
	<th> </th>
	<th>Employee Registration Cut-off</th>
	<th>Security shuttle request Cut-off time to Shuttle company</th>
</tr>
<tr>
	<th>Outgoing 2PM</th>
	<th>1030AM</th>
	<th>12PM</th>
</tr>
<tr>
	<th>[Friday] Outgoing 3PM</th>
	<th>1130AM</th>
	<th>1PM</th>
</tr>
<tr>
	<th>Outgoing 5PM</th>
	<th>130PM</th>
	<th>3PM</th>
</tr>
<tr>
	<th>Outgoing 6PM</th>
	<th>230PM</th>
	<th>4PM</th>
</tr>
<tr>
	<th>Outgoing 10PM</th>
	<th>630PM</th>
	<th>8PM</th>
</tr>
<tr>
	<th>Outgoing 6AM</th>
	<th>230AM</th>
	<th>4AM</th>
</tr>
</table>
<BR>
<?php
//logout auto menu
if ($_SESSION["sourceLoc"]=='2') {
	//from meetinghome
	?>
	<a href="meetinghome.php">Back to Main Menu</a><BR>
	<a href="meetinglogout.php">Exit Session</a>
	<?php
} else if ($_SESSION["sourceLoc"]=='1') {
	//from home
	?>
	<a href="home.php">Back to Main Menu</a><BR>
	<a href="signout.php">Exit Session</a>
	<?php
} else {
	//javascript back
	echo "<a href='javascript:history.back(1);'>Back to main menu</a>";
}
$conn->close();
?>
<BR>
</center>
</body>
</html>
