<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
	
include 'db_connection.php';
$conn = OpenCon();

$fields = array('first_name','last_name','email','phone','street','street_2','city','state','zip');
foreach($fields as $field){
	$param = $_POST[$field];
	$param = mysqli_real_escape_string($conn, $param);
	if($field == 'email'){
		$param = filter_var($param, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH);
	} else {
		$param = filter_var($param, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	}
	//field validation would be good to add, skipping over for now in this quick example project
	$$field = $param;
}

if($_POST['user_action'] == 'add'){
	$placeholders = '';
	foreach($fields as $field){
		$placeholders .= '?,';
	}
	$placeholders = rtrim($placeholders, ',');
	
	$mysql = "INSERT INTO `rv_users` (".implode(',', $fields).") VALUES(".$placeholders.")";
	
} else if($_POST['user_action'] == 'edit'){
	$user_id = $_POST['user_id'];
	$user_id = mysqli_real_escape_string($conn, $user_id);
	$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	
	$placeholders = '';
	foreach($fields as $field){
		$placeholders .= $field.'=?, ';
	}
	$placeholders = rtrim($placeholders, ', ');
	
	$mysql = "UPDATE `rv_users` SET ".$placeholders." WHERE id = ".$user_id;
}

$stmt = $conn->prepare($mysql);
$stmt->bind_param('sssssssss', $first_name, $last_name, $email, $phone, $street, $street_2, $city, $state, $zip);
$stmt->execute();

if(!$stmt->error){
	$repsonse = $_POST['user_action'].'-success';
} else {
	$repsonse = $_POST['user_action'].'-fail';
}

$stmt->close();
CloseCon($conn);

header("Location: /?response=".$repsonse);
die();

	
?>