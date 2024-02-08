<?php
function OpenCon(){
	$dbhost = "realview-db-1"; //if pulling directly from github  this could be "realview-master-db-1", double check with docker ps on the correct name to use
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