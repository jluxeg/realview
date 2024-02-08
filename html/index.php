<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';
$conn = OpenCon();

$users = array();
$search_string = '';
$mysql = 'SELECT * FROM rv_users';

$user_actions = '<form action="/user.php" method="post"><input type="hidden" name="user_action" value="edit" /><input type="hidden" name="user_id" value="%user_id%" /><button>Edit User</button></form>';
$user_actions .= '<form action="/delete.php" method="post"><input type="hidden" name="user_id" value="%user_id%" /><button type="submit">Delete User</button></form>';

if(isset($_GET['search'])){
	$search_string = $_GET['search'];
	$search_string = mysqli_real_escape_string($conn, $search_string);
	$search_string = filter_var($search_string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$mysql = "SELECT * FROM rv_users WHERE CONCAT(first_name,last_name,email,phone,street,street_2,city,state,zip) LIKE '%".$search_string."%'";
}

$users_query = mysqli_query($conn, $mysql) or die(mysql_error());
while($row = mysqli_fetch_assoc($users_query)){
	$users[] = $row;
}
CloseCon($conn);

if(isset($_GET['response'])){
	$response = '';
	switch($_GET['response']){
		case 'add-success':
			$response = 'User added successfully.';
			break;
		case 'add-fail':
			$response = 'Failed to add user.';
			break;
		case 'edit-success':
			$response = 'User edited successfully.';
			break;
		case 'edit-fail';
			$response = 'Failed to edit user.';
			break;
		case 'delete-success';
			$response = 'User deleted successfully.';
			break;
		case 'delete-fail':
			$response = 'Failed to delete user.';
			break;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Users</title>
		<meta name="description" content="..." />
		<style>
			main {
				max-width: 780px;
				margin: 50px auto;
			}
			table {
				border-collapse: collapse;
				width: 100%;
			}
			th {
				background: #ccc;
				font-size: 18px;
				text-align: left;
				padding: 10px;
			}
			td {
				border: 1px solid #333;
				padding: 10px;
			}
			div {
				display: flex;
				justify-content: space-between;
			}
		</style>
	</head>
	<body>
		<main>
			
			<h1><a href="/">Users List:</a></h1>
			<div>
				<form action="/" method="get">
					<input type="search" id="search" name="search" value="<?php echo $search_string; ?>" />
					<input type="submit" value="Search Users"/>
				</form>
				
				<form action="/user.php" method="post">
					<input type="hidden" name="user_action" value="add" />
					<button>Add User</button>
				</form>
			</div>
			<hr/>
			
			<?php
				if(isset($_GET['response'])){
					echo '<h2>'.$response.'</h2>';
				}
			?>
			<table>
				<thead>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Address</th>
					<th>Actions</th>
				</thead>
				<tbody>
					<?php if(!$users) {
						echo '<tr><td colspan="6">No Results</td></tr>';
					} else {
						foreach($users as $user){
							foreach($user as $key => $value){
								$user[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
							}
							echo '<tr>';
							echo '<td>'.$user['first_name'].'</td>';
							echo '<td>'.$user['last_name'].'</td>';
							echo '<td>'.$user['email'].'</td>';
							echo '<td>'.$user['phone'].'</td>';
							echo '<td>'.$user['street'].'<br/>'.$user['street_2'].'<br/>'.$user['city'].', '.$user['state'].'  '.$user['zip'].'</td>';
							echo '<td><div>'.str_replace('%user_id%',$user['id'],$user_actions).'</div></td>';
							echo '</tr>';
						}
					} ?>
				</tbody>
			</table>
			
			
		</main>
	</body>
</html>

