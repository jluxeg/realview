<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_POST['user_id'])){
	header("Location: /");
	die();
}

include 'db_connection.php';
$conn = OpenCon();

$user_id = $_POST['user_id'];
$user_id = mysqli_real_escape_string($conn, $user_id);
$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	
$mysql = "DELETE FROM `rv_users` WHERE id = ".$user_id;

if (mysqli_query($conn, $mysql)) {
	$repsonse = 'delete-success';
} else {
	$repsonse = 'delete-fail';
}

CloseCon($conn);

header("Location: /?response=".$repsonse);
die();	
	
?>