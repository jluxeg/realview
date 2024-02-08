<?php
function OpenCon(){
	$dbhost = "realview-db-1";
	$dbuser = "root";
	$dbpass = "root";
	$dbname = "realviewdb";
	
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die("Connect failed: %s\n". $conn -> error);
	return $conn;
}
function CloseCon($conn){
	$conn -> close();
}
?>