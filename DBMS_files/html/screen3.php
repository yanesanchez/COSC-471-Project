
<!-- Figure 3: Search Result Screen by Prithviraj Narahari, php coding: Alexander Martens -->

<?php
require_once('../PDO_connect.php');
ob_start();
session_start();
//error_reporting(-1);
//ini_set('display_errors', 'On');

if(isset($_SESSION['valid']) && !empty($_SESSION['valid'])){		// registered user
	if(!empty($_SESSION['user_id'])){
		$stmt = $pdo -> prepare("SELECT id from SHOPPING_CART where user_id = ".$_SESSION['user_id']);
		$stmt -> execute();
		$cart_exists = $stmt -> fetch(PDO::FETCH_COLUMN);

		if($cart_exists > 0){							/// user alreaady has a cart
			$_SESSION['cart_id'] = $cart_exists;
			$stmt = $pdo -> prepare("SELECT isbn FROM CART_ITEM, SHOPPING_CART WHERE SHOPPING_CART.user_id = ".$_SESSION['user_id']." AND CART_ITEM.cart_id = SHOPPING_CART.id");
			$stmt -> execute();
			$cart_contents = $stmt->fetchAll(PDO::FETCH_COLUMN);
		}
		else{											// user needs a cart
			$stmt = $pdo -> prepare("INSERT INTO SHOPPING_CART (user_id) VALUES (:user_id)");
			$stmt ->bindParam(':user_id', $_SESSION['user_id']);
			$stmt ->execute();
			$stmt = $pdo -> prepare("SELECT id from SHOPPING_CART where user_id = ".$_SESSION['user_id']);
			$stmt -> execute();
			$_SESSION['cart_id'] = $stmt -> fetch(PDO::FETCH_COLUMN);
			$cart_contents = '';
		}
	}
}
else{
//	echo "new temp user";
	$stmt = $pdo -> prepare("INSERT INTO USER (type, username, pin, first_name, last_name, address, city, state, zip, credit_card, card_number, expiration) VALUES ('T', null, null, null, null, null, null, null, null, null, null, null)" );
	$stmt ->execute();
	$stmt = $pdo -> prepare("SELECT LAST_INSERT_ID()");
	$stmt ->execute();
	$temp_id = $stmt -> fetch(PDO::FETCH_COLUMN);
	$_SESSION['user_id'] = $temp_id;

	//	echo "new cart";
		$stmt = $pdo -> prepare("INSERT INTO SHOPPING_CART (user_id) VALUES (:user_id)");
		$stmt ->bindParam(':user_id', $_SESSION['user_id']);
		$stmt ->execute();
		$stmt = $pdo -> prepare("SELECT id from SHOPPING_CART where user_id = ".$_SESSION['user_id']);
		$stmt -> execute();
		$_SESSION['cart_id'] = $stmt -> fetch(PDO::FETCH_COLUMN);
	//	echo "cart id: ".$_SESSION['cart_id'];
		$cart_contents = '';
		$_SESSION['temp'] = true;
		$_SESSION['valid'] = true;
}


if(isset($_GET['cartisbn'])){
	if(!is_array($cart_contents) || !in_array($_GET['cartisbn'], $cart_contents)){
		$price = $_GET['price'];
		$isbn = $_GET['cartisbn'];
		$cart_id = $_SESSION['cart_id'];

	//$_SESSION['cart_has_items'] = true;
	$stmt = $pdo -> prepare("INSERT INTO CART_ITEM (cart_id, isbn, price) VALUES (:cart_id, :isbn, :price)");
//	echo "cart_id : $cart_id";
	$stmt -> bindParam(':cart_id', $cart_id);
	$stmt -> bindParam(':isbn', $isbn);
	$stmt -> bindParam(':price', $price);
	$stmt->execute();
	$stmt = $pdo -> prepare("SELECT isbn FROM CART_ITEM, SHOPPING_CART WHERE SHOPPING_CART.user_id = ".$_SESSION['user_id']." AND CART_ITEM.cart_id = SHOPPING_CART.id");
	$stmt -> execute();
	$cart_contents = $stmt->fetchAll(PDO::FETCH_COLUMN);
	//print_r($cart_contents);
	}
	
}

//echo "cart contents : ".print_r($cart_contents);
	
//	echo $_SESSION['username'];
//	echo $_SESSION['user_id'];

	$searchfor = trim($_GET['searchfor']);
	$searchon = ($_GET['searchon']);
	$category = trim($_GET['category']);
	//echo $category;

	//echo "SEARCHON : $searchon";
	$pstmt = "select isbn as ISBN, title as Title, 
	(select first_name from AUTHOR where BOOK.author_id = id) as Author_fname, 
	(select last_name from AUTHOR where BOOK.author_id = id) as Author_lname, 
	(select name from CATEGORY where BOOK.category_id = id) as Category, 
	(select name from PUBLISHER where BOOK.publisher_id = id) as Publisher, price as Price, quantity from BOOK";
	$tables = "";
	$attr = "";
	$where = "";
	if(!is_array($searchon))
	$searchon = explode(',',$searchon);
	if($searchon[0] == 'anywhere'){
	//	echo "anywhere";
	$pstmt.= " WHERE (BOOK.author_id in (select id from AUTHOR where first_name like '%$searchfor%' or last_name like '%$searchfor%') 
	OR BOOK.publisher_id in (select id from PUBLISHER where name like '%$searchfor%') 
	OR BOOK.title LIKE '%$searchfor%')";
	}
	else {
	//	echo "not anywhere";
		foreach($searchon as $s){
		if($s == "title")
			$where .= "BOOK.title LIKE '%$searchfor%' ";
		if($s == "isbn")
			$where .= "BOOK.isbn LIKE '%$searchfor%' ";
		if($s == "author")
			$where .= "BOOK.author_id in (select id from AUTHOR where first_name like '%$searchfor%' or last_name like '%$searchfor%') ";
		if($s == "publisher")
			$where .= "BOOK.publisher_id in (select id from PUBLISHER where name like '%$searchfor%') ";
		if($s != $searchon[sizeof($searchon)-1])
			$where.="OR ";
	}
	$pstmt.=" WHERE ".$where;
	}
	if($category != "all")
	$pstmt.=" AND BOOK.category_id ".'='." $category";

	//echo $pstmt;
	$stmt = $pdo->prepare("$pstmt");
	$stmt -> execute();

	$result = $stmt->fetchall(PDO::FETCH_ASSOC);

	//echo "result : ".print_r($result);

	$cart_items = $pdo -> prepare("SELECT count(isbn) from CART_ITEM where cart_id = ".$_SESSION['cart_id']);
	$cart_items -> execute();
	$cart_items = $cart_items -> fetch(PDO::FETCH_COLUMN);

	//echo "$searchfor";

		$searchlist = '';
		foreach($searchon as $s)
		$searchlist.= $s.',';
		$searchlist = substr($searchlist, 0, -1);
	//	echo "searchlist: $searchlist";

//print_r($cart_contents);
//echo $_GET['cartisbn'];

function display_books($result, $cart_contents, $searchfor, $searchlist, $category){
	//echo "$searchfor";

foreach ($result as $row){
	$book_details = '<tr><td align = \'left\'><button name= \'btnCart\' id= \'btnCart\' onClick= \'cart( '.'"'.$row['ISBN'].'"'.', '.'"'.$searchfor.'"'.', '.'"'.$searchlist.'"'.', '.'"'.$category.'", '.'"'.$row['Price'].'"'.')\' ';
	
	if($cart_contents == 1)
	echo "CART CONTENTS IS 1";
		if (isset($_GET['cartisbn']) && $_GET['cartisbn'] == $row['ISBN'])
			$book_details .= ' disabled';
		else if(is_array($cart_contents) && in_array($row['ISBN'], $cart_contents) || $row['quantity'] < 1)
			$book_details .= ' disabled';

	$book_details .= '> Add to Cart</button></td><td rowspan= \'2\'  align= \'left\'> '.str_replace("'", "\'", $row['Title']).' </br>
		By '.$row['Author_fname'].' '.$row['Author_lname'].':</b> '.$row['Publisher'].',</br><b>ISBN:</b> '.$row['ISBN'].'</t> <b>Price: </b> '.'$'.$row['Price'].'</td></tr><tr>
		<td align= \'left\'><button name= \'review\' id= \'review\' onClick= \'review("'.$row['ISBN'].'", "'.$row['Title'].'")\''.'>Reviews</button></td></tr><tr>
		<td colspan= \'2\'><p>_______________________________________________</p></td></tr>';

	echo $book_details;
}
}
function display_error($searchfor){
	echo 'No Results found for "'.$searchfor.'"';
}
?>
<html>
<head>
	<title> Search Result - 3-B.com </title>
	<script>
	//redirect to reviews page
	function review(isbn, title){
		window.location.href="screen4.php?isbn="+ isbn + "&title=" + title;
	}
	//add to cart
	function cart(isbn, searchfor, searchon, category, price){
		window.location.href="screen3.php?cartisbn="+ isbn + "&searchfor=" + searchfor + "&searchon=" + searchon + "&category=" + category + "&price=" + price;
	}

	</script>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="left">
				
					<h6> <fieldset>Your Shopping Cart has <?php echo $cart_items.' item'; if($cart_items > 1) echo 's'; ?></fieldset> </h6>
				
			</td>
			<td>
				&nbsp
			</td>
			<td align="right">
				<form action="shopping_cart.php" method="post">
					<input type="submit" value="Manage Shopping Cart">
				</form>
			</td>
		</tr>	
		<tr>
		<td style="width: 350px" colspan="3" align="center">
			<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;background-color:LightBlue">
			<table>
			<?php
			// error checking -----------
			if(count($result) > 0)
				display_books($result, $cart_contents, $searchfor, $searchlist, $category);
			// else
			// display_error($searchfor);
			?>
			</table>
			</div>
			
			</td>
		</tr>
		<tr>
			<td align= "center">
				<form action="confirm_order.php" method="get">
					<input type="submit" value="Proceed To Checkout" id="checkout" name="checkout">
				</form>
			</td>
			<td align="center">
				<form action="screen2.php" method="post">
					<input type="submit" value="New Search">
				</form>
			</td>
			<td align="center">
				<form action="index.php" method="post">
					<input type="submit" name="exit" value="EXIT 3-B.com">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>