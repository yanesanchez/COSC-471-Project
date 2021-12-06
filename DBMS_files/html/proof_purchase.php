<?php
require_once('../PDO_connect.php');
ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');
//print_r($_SESSION);

if($_POST['cardgroup'] == 'new_card'){
	$credit_card = $_POST['credit_card'];
	$card_number = $_POST['card_number'];
	$card_exp = $_POST['card_expiration'];
	$stmt = $pdo -> prepare("UPDATE USER 
							 SET credit_card = '$credit_card', card_number = $card_number, expiration =  '$card_exp'
							 WHERE id = ".$_SESSION['user_id']);
					$stmt -> execute();
}

$stmt = $pdo -> prepare("SELECT * from USER where id = ".trim($_SESSION['user_id']));
$stmt -> execute();
$user_info = $stmt -> fetch(PDO::FETCH_ASSOC);
//echo "user : ";
//print_r($user_info);
$stmt = $pdo -> prepare("SELECT title, CART_ITEM.isbn as isbn, CART_ITEM.price as p, 
(select first_name from AUTHOR where BOOK.author_id = id) as Author_fname, 
(select last_name from AUTHOR where BOOK.author_id = id) as Author_lname,  
(select name from CATEGORY where BOOK.category_id = id) as Category, 
(select name from PUBLISHER where BOOK.publisher_id = id) as Publisher, sum(CART_ITEM.price * CART_ITEM.quantity) as Price, CART_ITEM.quantity as qty from BOOK, CART_ITEM
where CART_ITEM.cart_id = ".$_SESSION['cart_id']." and BOOK.isbn = CART_ITEM.isbn
group by title, Author_fname, Author_lname, isbn, p, Category, Publisher, CART_ITEM.quantity");
$stmt -> execute();
$rowcount = $stmt -> rowCount();
if($rowcount > 0){
$cart = $stmt -> fetchAll(PDO::FETCH_ASSOC);

//print_r($cart);
$subtotal = 0;
$shipping = 2;
foreach($cart as $s)
$subtotal += $s['Price'];
//print_r($cart);
$date = date('Y-m-d');
$time = date('H:i:s');
$insert_date = date('Y-m-d H:i:s');
if($_POST['cardgroup'] == 'new_card'){
	$credit_card = $_POST['credit_card'];
	$card_number = $_POST['card_number'];
	$card_exp = $_POST['card_expiration'];
}
else{
	$credit_card = $user_info['credit_card'];
	$card_number = $user_info['card_number'];
	$card_exp = $user_info['expiration'];
}


$stmt = $pdo -> prepare("INSERT into ORDER_PLACED (user_id, total, date) 
						VALUES (".trim($_SESSION['user_id']).", $subtotal+$shipping, '$insert_date')");
$stmt -> execute();
$stmt = $pdo -> prepare("SELECT LAST_INSERT_ID()");
$stmt -> execute();
$order_id = $stmt -> fetchALL(PDO::FETCH_COLUMN);
$order_id = $order_id[0];
//print_r($order_id);
foreach($cart as $c){

	$stmt = $pdo -> prepare('insert into CART_ITEM (cart_id , isbn, price, quantity)
							values ('.$order_id.', \''.$c['isbn'].'\', '.$c['p'].', '.$c['qty'].')');
							$stmt -> execute();
}

$stmt = $pdo -> prepare("delete from CART_ITEM where cart_id = ".$_SESSION['cart_id']);
$stmt -> execute();
$stmt = $pdo -> prepare("delete from SHOPPING_CART  where user_id = ".$_SESSION['user_id']);
$stmt -> execute();

function display_order($cart){
	require_once('../PDO_connect.php');

	foreach($cart as $c){
		echo '<tr><td>'.$c['title'].'</br><b>By</b> '.$c['Author_fname'].' '.$c['Author_lname'].'</br><b>Publisher:</b> '.$c['Publisher'].'</td><td>'.$c['qty'].'</td><td>$'.$c['Price'].'</td></tr>';
	}
}
}
?>

<!DOCTYPE HTML>
<head>
	<title>Proof purchase</title>
	<header align="center">Proof purchase</header> 
</head>
<body>
	<table align="center" style="border:2px solid blue;">
	<form id="buy" action="" method="post">
	<tr>
	<td>
	Shipping Address: <?php echo $user_info['address']; ?>
	</td>
	</tr>
	<td colspan="2">
	<?php echo $user_info['first_name'].' '.$user_info['last_name']; ?>	</td>
	<td rowspan="3" colspan="2">
		<b>UserID:</b><?php echo $user_info['username'];?><br />
		<b>Date:</b><?php echo $date?><br />
		<b>Time:</b><?php echo $time?><br />
		<b>Card Info:</b><?php echo $credit_card.'<br />'.$card_exp.' - '.$card_number?></td>
	<tr>
	<td colspan="2">
	<?php echo $user_info['address']; ?>	</td>		
	</tr>
	<tr>
	<td colspan="2">
	<?php echo $user_info['city']; ?>	</td>
	</tr>
	<tr>
	<td colspan="2">
	<?php echo $user_info['state'].', '. $user_info['zip']; ?>	</td>
	</tr>
	<tr>
	<td colspan="3" align="center">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:520px;border:1px solid black;">
	<table border='1'>
		<th>Book Description</th><th>Qty</th><th>Price</th>
		<?php display_order($cart); ?>
			</table>
	</div>
	</td>
	</tr>
	<tr>
	<td align="left" colspan="2">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:260px;border:1px solid black;background-color:LightBlue">
	<b>Shipping Note:</b> The book will be </br>delivered within 5</br>business days.
	</div>
	</td>
	<td align="right">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:260px;border:1px solid black;">
	<?php echo "SubTotal: $".$subtotal; ?> </br>Shipping_Handling: $<?php echo $shipping;?></br>_______</br>Total: $<?php echo $subtotal + $shipping;?>	</div>
	</td>
	</tr>
	<tr>
		<td align="right">
			<input type="submit" id="buyit" name="btnbuyit" value="Print" disabled>
		</td>
		</form>
		<td align="right">
			<form id="update" action="screen2.php" method="post">
			<input type="submit" id="update_customerprofile" name="update_customerprofile" value="New Search">
			</form>
		</td>
		<td align="left">
			<form id="cancel" action="index.php" method="post">
			<input type="submit" id="exit" name="exit" value="EXIT 3-B.com">
			</form>
		</td>
	</tr>
	</table>
</body>
</HTML>