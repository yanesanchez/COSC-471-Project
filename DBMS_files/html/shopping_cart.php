<?php
ob_start();
session_start();

require_once('../PDO_connect.php');
if(isset ($_POST['recalculate_payment'])){
	if(!empty($_SESSION['user_id'])){
	$qty = $_POST['qty'];
	print_r($qty);
	$stmt1 = $pdo -> prepare("SELECT distinct isbn from CART_ITEM, SHOPPING_CART WHERE cart_id = ".$_SESSION['cart_id']);
	$stmt1 -> execute();
	$result = $stmt1 -> fetchall(PDO::FETCH_COLUMN);
	echo "**RESULT BEGINS**";
	print_r($result);
	echo "**RESULT ENDS**";
	echo "result: ".print_r($result);

	foreach ($result as $row){
		echo $row;
		$stmt2 = $pdo -> prepare("UPDATE CART_ITEM SET quantity = ".$qty[$row]." where cart_id = ".$_SESSION['cart_id']." AND isbn = '".$row."'");
		$stmt2 -> execute();
	}
	}
else if(!empty($_SESSION['temp_id'])){
		$qty = $_POST['qty'];
		print_r($qty);
		$stmt1 = $pdo -> prepare("SELECT distinct isbn from TEMP_CART_ITEM, TEMP_SHOPPING_CART WHERE cart_id = ".$_SESSION['cart_id']);
		$stmt1 -> execute();
		$result = $stmt1 -> fetchall(PDO::FETCH_COLUMN);
		echo "**RESULT BEGINS**";
		print_r($result);
		echo "**RESULT ENDS**";
		echo "result: ".print_r($result);
	
		foreach ($result as $row){
			echo $row;
			$stmt2 = $pdo -> prepare("UPDATE TEMP_CART_ITEM SET quantity = ".$qty[$row]." where cart_id = ".$_SESSION['cart_id']." AND isbn = '".$row."'");
			$stmt2 -> execute();
		}
		}

}

if(isset($_GET['delIsbn'])){
	if(!empty($_SESSION['user_id'])){
		$del_isbn = $_GET['delIsbn'];
		$delStmt = $pdo -> prepare('delete from CART_ITEM where isbn = '.'"'.$del_isbn.'"'." and cart_id = ".$_SESSION['cart_id']);
		$delStmt -> execute();
	}
else if(!empty($_SESSION['temp_id'])){
		$del_isbn = $_GET['delIsbn'];
		$delStmt = $pdo -> prepare('delete from TEMP_CART_ITEM where isbn = '.'"'.$del_isbn.'"'." and cart_id = ".$_SESSION['cart_id']);
		$delStmt -> execute();
		}
}
if(!empty($_SESSION['user_id'])){
$stmt = $pdo -> prepare("select BOOK.isbn as ISBN, title as Title, (select name from AUTHOR where BOOK.author_id = id) as Author, 
(select name from CATEGORY where BOOK.category_id = id) as Category, 
(select name from PUBLISHER where BOOK.publisher_id = id) as Publisher, BOOK.price as Price, CART_ITEM.quantity as qty from BOOK, SHOPPING_CART, CART_ITEM 
WHERE CART_ITEM.isbn = BOOK.isbn AND CART_ITEM.cart_id = SHOPPING_CART.id AND user_id = ".$_SESSION['user_id']);
}
else if(!empty($_SESSION['temp_id'])){
	$stmt = $pdo -> prepare("select BOOK.isbn as ISBN, title as Title, (select name from AUTHOR where BOOK.author_id = id) as Author, 
	(select name from CATEGORY where BOOK.category_id = id) as Category, 
	(select name from PUBLISHER where BOOK.publisher_id = id) as Publisher, BOOK.price as Price, TEMP_CART_ITEM.quantity as qty from BOOK, TEMP_SHOPPING_CART, TEMP_CART_ITEM 
	WHERE TEMP_CART_ITEM.isbn = BOOK.isbn AND TEMP_CART_ITEM.cart_id = TEMP_SHOPPING_CART.id AND user_id = ".$_SESSION['temp_id']);
	}
$stmt -> execute();
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
if(!empty($_SESSION['user_id'])){
	$total_stmt = $pdo -> prepare("SELECT sum(price * quantity) from CART_ITEM, SHOPPING_CART WHERE cart_id = SHOPPING_CART.id AND user_id = ".$_SESSION['user_id']);
}
else if(!empty($_SESSION['temp_id'])){
	$total_stmt = $pdo -> prepare("SELECT sum(price * quantity) from TEMP_CART_ITEM, TEMP_SHOPPING_CART WHERE cart_id = TEMP_SHOPPING_CART.id AND user_id = ".$_SESSION['temp_id']);
	}
$total_stmt -> execute();
$subtotal = $total_stmt->fetch(PDO::FETCH_COLUMN);

function display($result){
		//	echo $row['Title'].": ".$row['ISBN'];
	foreach ($result as $row){
	echo '<tr><td><button name=\'delete\' id=\'delete\' onClick=\'del('.'"'.$row['ISBN'].'"'.');return false;\'>Delete Item</button></td><td>'.$row['Title'].'</br>
	<b>By</b>'.$row['Author'].'</br><b>Publisher:</b> '.$row['Publisher'].'</td><td><input id= \'qty['.$row['ISBN'].']\' name=\'qty['.$row['ISBN'].']\' value=\''.$row['qty'].'\' size=\'1\' /></td><td>'.$row['Price'].'</td></tr>';
	}
}
?>
<!DOCTYPE HTML>
<head>
	<title>Shopping Cart</title>
	<script>
	//remove from cart
	function del(isbn){
		window.location.href="shopping_cart.php?delIsbn="+ isbn;
	}
	function recalculate(){}
	</script>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="center">
				<form id="checkout" action="confirm_order.php" method="get">
					<input type="submit" name="checkout_submit" id="checkout_submit" value="Proceed to Checkout">
				</form>
			</td>
			<td align="center">
				<form id="new_search" action="screen2.php" method="post">
					<input type="submit" name="search" id="search" value="New Search">
				</form>								
			</td>
			<td align="center">
				<form id="exit" action="index.php" method="post">
					<input type="submit" name="exit" id="exit" value="EXIT 3-B.com">
				</form>					
			</td>
		</tr>
		<tr>
				<form id="recalculate" name="recalculate" action="" method="post">
			<td  colspan="3">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th width='10%'>Remove</th><th width='60%'>Book Description</th><th width='10%'>Qty</th><th width='10%'>Price</th>
						<?php display($result) ?>
					<!--	<tr><td><button name='delete' id='delete' onClick='del("123441");return false;'>Delete Item</button></td><td>iuhdf</br><b>By</b> Avi Silberschatz</br><b>Publisher:</b> McGraw-Hill</td><td><input id='txt123441' name='txt123441' value='1' size='1' /></td><td>12.99</td></tr> -->					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">				
					<input type="submit" name="recalculate_payment" id="recalculate_payment" value="Recalculate Payment">
				</form>
			</td>
			<td align="center">
				&nbsp;
			</td>
			<td align="center">			
				<?php echo "Subtotal : ".$subtotal?> </td>
		</tr>
	</table>
</body>
