
<?php
ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');

if(isset($_POST['adminname']) && !empty($_POST['adminname']) && !empty($_POST['pin'])){
	require_once('../PDO_connect.php');

	$username = trim($_POST['adminname']);
	$pin = trim($_POST['pin']);
	$stmt = $pdo -> prepare("SELECT * FROM ADMIN WHERE username = :username AND pin = :pin");
	$stmt -> bindParam(':username', $username);
	$stmt -> bindParam(':pin', $pin);

	$stmt -> execute();

	$count = $stmt->rowCount();

	if ($count == 1){

	//$row = $stmt->fetch();
	//$uid = $row['id'];

	//$getCart = $pdo -> prepare("SELECT id from SHOPPING_CART WHERE SHOPPING_CART.user_id = $uid");
	//$getCart -> execute();
	//$cart_id = $getCart ->fetch();
	//$_SESSION['cart_id'] = $cart_id['id'];
	$_SESSION['valid'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['user_id'] = $uid;

	header("location: admin_tasks.php");
    exit;
	}
	else
	echo "<script>console.log('login unsuccessful');</script>";
}

?>

<!DOCTYPE HTML>
<head>
<title>Admin Login</title>
</head>

<body>
<table align="center" style="border:2px solid blue;">
		<form action="admin_tasks.php" method="post" id="adminlogin_screen">
		<tr>
			<td align="right">
				Adminname<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="adminname" id="adminname">
			</td>
			<td align="right">
				<input type="submit" name="login" id="login" value="Login">
			</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" name="pin" id="pin">
			</td>
			</form>
			<form action="index.php" method="post" id="login_screen">
			<td align="right">
				<input type="submit" name="cancel" id="cancel" value="Cancel">
			</td>
			</form>
		</tr>
	</table>
</body>



</html>
