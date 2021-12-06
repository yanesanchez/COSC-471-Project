<?php
require_once('../PDO_connect.php');
ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');
print_r($_SESSION);
if(!empty($_SESSION['user_id']) && (!empty($_SESSION['temp']) || $_SESSION['temp'] == false || !isset($_SESSION['temp']))){
$stmt = $pdo -> prepare("select * from USER where id = ".trim($_SESSION['user_id']));
$stmt -> execute();
$user_info = $stmt -> fetch(PDO::FETCH_ASSOC);
//echo "user : ";
//print_r($user_info);
$stmt = $pdo -> prepare("select title, 	
(select first_name from AUTHOR where BOOK.author_id = id) as Author_fname, 
(select last_name from AUTHOR where BOOK.author_id = id) as Author_lname, 
(select name from CATEGORY where BOOK.category_id = id) as Category, 
(select name from PUBLISHER where BOOK.publisher_id = id) as Publisher, sum(CART_ITEM.price * CART_ITEM.quantity) as Price, CART_ITEM.quantity as qty from BOOK, CART_ITEM
where CART_ITEM.cart_id = ".$_SESSION['cart_id']." and BOOK.isbn = CART_ITEM.isbn
group by title, Author_fname, Author_lname, Category, Publisher, CART_ITEM.quantity");
$stmt -> execute();
$cart = $stmt -> fetchAll(PDO::FETCH_ASSOC);
}
else
$user_info = array("first_name"=>'register', "last_name"=>'register', "address"=>'register', "city"=>'register', "zip"=>'register', "state"=>'register', "card_number"=>'register');

//print_r($cart);
$subtotal = 0;
$shipping = 2;
foreach($cart as $s)
$subtotal += $s['Price'];
function display_cart($cart){
	foreach($cart as $c){
		echo '<tr><td>'.$c['title'].'</br><b>By</b> '.$c['Author_fname'].' '.$c['Author_lname'].'</br><b>Publisher:</b> '.$c['Publisher'].'</td><td>'.$c['qty'].'</td><td>$'.$c['Price'].'</td></tr>';
	}
}
?>
<!DOCTYPE HTML>
<head>
	<title>CONFIRM ORDER</title>
	<header align="center">Confirm Order</header>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
	<form id="buy" action="proof_purchase.php" method="post">
	<tr>
	<td>
	Shipping Address:
	</td>
	</tr>
	<td colspan="2">
	<?php echo $user_info['first_name'].' '.$user_info['last_name']; ?>	</td>
	<td rowspan="3" colspan="2">
		<input type="radio" name="cardgroup" value="profile_card" checked>Use Credit card on file<br /><?php echo $user_info['card_number']; ?><br />
		<input type="radio" name="cardgroup" value="new_card">New Credit Card<br />
				<select id="credit_card" name="credit_card">
					<option selected disabled>select a card type</option>
					<option>VISA</option>
					<option>MASTER</option>
					<option>DISCOVER</option>
				</select>
				<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
				<br />Exp date<input type="text" id="card_expiration" name="card_expiration" placeholder="mm/yyyy">
	</td>
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
		<?php display_cart($cart); ?>	</table>
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
			<input type= <?php if(isset($_SESSION['temp']) && $_SESSION['temp'] == 1)echo "button"; else echo "submit"; ?> id="buyit" name="btnbuyit" value="BUY IT!" <?php if(isset($_SESSION['temp']) && $_SESSION['temp'] == 1) echo 'onClick = "register_alert()"'; ?>>
		</td>
		</form>
		<td align="right">
			<form id="update" action="update_customerprofile.php" method="post">
			<input type=<?php if(isset($_SESSION['temp']) && $_SESSION['temp'] == 1) echo "button"; else echo "submit"; ?> id="update_customerprofile" name="update_customerprofile" value="Update Customer Profile"<?php if(isset($_SESSION['temp']) && $_SESSION['temp'] == 1) echo 'onClick = "register_alert2()"'; ?>>
			</form>
		</td>
		<td align="left">
			<form id="cancel" action="index.php" method="post">
			<input type= "submit" id= "cancel" name="cancel" value="Cancel" >
			</form>
		</td>
	</tr>
	</table>
	<script>
        function register_alert() {
            alert("You must be registered to place an order");
			window.location.href="screen2.php";
        }
		function register_alert2() {
            alert("You must be registered to update your profile");
			window.location.href="screen2.php";
        }
    </script>
		<script>
			function register_alert2() {
            alert("You must be registered to update your profile");
			window.location.href="screen2.php";
        }
    </script>
</body>
</HTML>
