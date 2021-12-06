
<?php
ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');

if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['username']) && !empty($_POST['pin'])){
	require_once('../PDO_connect.php');
	$username = trim($_POST['username']);
	$pin = trim($_POST['pin']);
	$stmt = $pdo -> prepare("SELECT * FROM USER WHERE username = :username AND pin = :pin AND type = 'R'");
	$stmt -> bindParam(':username', $username);
	$stmt -> bindParam(':pin', $pin);

	$stmt -> execute();

	$count = $stmt->rowCount();

	if ($count == 1){
		$row = $stmt->fetch();
		$uid = $row['id'];
		$getCart = $pdo -> prepare("SELECT id from SHOPPING_CART WHERE SHOPPING_CART.user_id = $uid");
		$getCart -> execute();
		$cart_id = $getCart ->fetch();
		$_SESSION['cart_id'] = $cart_id['id'];
		$_SESSION['valid'] = true;
		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $uid;
		$_POST['username'] = "";
		$_POST['pin'] = "";
		$_SESSION['admin'] = false;
		$_SESSION['temp'] = false; 
		
	header("location: screen2.php");
    exit;
	}
	else
	echo "<script>console.log('login unsuccessful');</script>";
}


function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

//$username = $password = "";
//$username_err = $password_err = $login_err = "";

?>
<?
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>

<!DOCTYPE HTML>
<head>
<title>User Login</title>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<form method="post" id="login_screen">
		<tr>
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="username" id="username" value = <?php if(isset($_POST['username'])) echo $_POST['username']?>>
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
			<form action="" method="post" id="login_screen_cancel">
			<td align="right">
				<input type="submit" name="cancel" id="cancel" value="Cancel">
			</td>
			<?php if(isset($_POST['username'])) echo "<tr><td></td><td align = \"center\" colspan = \"2\" style = \"color:red\">ENTER A VALID USERNAME AND PASSWORD </td><td></td></tr>" ?>
			</form>
		</tr>
	</table>
</body>
</html>