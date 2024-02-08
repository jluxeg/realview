<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_POST['user_action'])){
	header("Location: /");
	die();
}
$user_action = $_POST['user_action'];
$user = array();

if($user_action == 'edit' && isset($_POST['user_id'])){
	include 'db_connection.php';
	$conn = OpenCon();
	
	$user_id = $_POST['user_id'];
	$user_id = mysqli_real_escape_string($conn, $user_id);
	$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	
	$mysql = 'SELECT * FROM rv_users WHERE `id` = '.$user_id;
	$users_query = mysqli_query($conn, $mysql) or die(mysql_error());
	$user = mysqli_fetch_assoc($users_query);
	CloseCon($conn);
	
	foreach($user as $key => $value){
		$user[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?php echo ucfirst($user_action); ?> User</title>
		<meta name="description" content="..." />
		<style>
			* {
				-webkit-box-sizing:border-box;
				box-sizing:border-box;
			}
			main {
				max-width: 780px;
				margin: 50px auto;
			}
			div {
				display: flex;
				justify-content: space-between;
			}
			form {
				width: 100%;
			}
			label {
				width: 100%;
				padding: 10px;
				display: block;
			}
			input {
				margin: 20px 0;
				width: 100%;
				padding: 5px;
			}
		</style>
	</head>
	<body>
		<main>
			<h1><?php echo ucfirst($user_action); ?> User:</h1>
			<div>
				<form action="/save.php" method="post">
					<input type="hidden" name="user_action" value="<?php echo $user_action; ?>" />
					<?php if($user_action == 'edit'){ ?>
						<input type="hidden" name="user_id" value="<?php echo $_POST['user_id']; ?>" />
					<?php } ?>
					<div>
						<label> First Name:
							<input type="text" name="first_name" value="<?php echo $user['first_name'] ?? '';?>" />
						</label>
						<label> Last Name:
							<input type="text" name="last_name" value="<?php echo $user['last_name'] ?? '';?>" />
						</label>
					</div>
					<div>
						<label> Email:
							<input type="text" name="email" value="<?php echo $user['email'] ?? '';?>" />
						</label>
						<label> Phone:
							<input type="text" name="phone" value="<?php echo $user['phone'] ?? '';?>" />
						</label>
					</div>
					<label> Street Address:
						<input type="text" name="street" value="<?php echo $user['street'] ?? '';?>" />
					</label>
					<label> Street Address 2:
						<input type="text" name="street_2" value="<?php echo $user['street_2'] ?? '';?>" />
					</label>
					<div>
						<label> City:
							<input type="text" name="city" value="<?php echo $user['city'] ?? '';?>" />
						</label>
						<label> State:
							<input type="text" name="state" value="<?php echo $user['state'] ?? '';?>" />
						</label>
						<label> Zip:
							<input type="text" name="zip" value="<?php echo $user['zip'] ?? '';?>" />
						</label>
					</div>
					<input type="submit" value="<?php echo ucfirst($user_action); ?> User" />
				</form>
			</div>
			<a href="/">Cancel</a>
		</main>
	</body>
</html>

