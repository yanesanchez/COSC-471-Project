
<!-- Figure 3: Search Result Screen by Prithviraj Narahari, php coding: Alexander Martens -->

<?php
require_once('../PDO_connect.php');
ob_start();
session_start();
//echo "session : ".$_SESSION['valid']."search : ".$_GET['search'];
if(isset($_GET['searchfor'])){	

	if(isset($_SESSION['valid'])){
		$uid = $_SESSION['user_id'];
		//echo "uid : $uid";
		$stmt = $pdo -> prepare("SELECT isbn FROM CART_ITEM, SHOPPING_CART WHERE SHOPPING_CART.user_id = $uid AND CART_ITEM.cart_id = SHOPPING_CART.id");
		$stmt -> execute();
		$cart_contents = $stmt->fetchAll(PDO::FETCH_COLUMN);
		echo "cart contents: ";
		print_r($cart_contents);
	}
		else
		$uid = 'temp';
	if(!empty($_GET['cartisbn']) && !in_array(trim($_GET['cartisbn']), $cart_contents)){
		echo "cartisbn : ".$_GET['cartisbn'];
		$price = $_GET['price'];
		$isbn = $_GET['cartisbn'];
		$stmt = $pdo -> prepare("SELECT id from SHOPPING_CART WHERE SHOPPING_CART.user_id = $uid");
		$stmt->execute();
		$result = $stmt -> fetch();
		$cart_id = $result['id'];
		$stmt = $pdo -> prepare("INSERT INTO CART_ITEM (cart_id, isbn, price) VALUES (:cart_id, :isbn, :price)");
		echo "cart_id : $cart_id";
		$stmt -> bindParam(':cart_id', $cart_id);
		$stmt -> bindParam(':isbn', $isbn);
		$stmt -> bindParam(':price', $price);
		$stmt->execute();
		unset($_GET['cartisbn']);
	}
	}
	echo $_SESSION['username'];
	echo $_SESSION['user_id'];

	$searchfor = trim($_GET['searchfor']);
	$searchon = ($_GET['searchon']);
	$category = trim($_GET['category']);

	//echo "SEARCHON : $searchon";
	$pstmt = "select isbn as ISBN, title as Title, (select name from AUTHOR where BOOK.author_id = id) as Author, 
	(select name from CATEGORY where BOOK.category_id = id) as Category, 
	(select name from PUBLISHER where BOOK.publisher_id = id) as Publisher, price as Price, quantity from BOOK";
	$tables = "";
	$attr = "";
	$where = "";
	if(!is_array($searchon))
	$searchon = explode(',',$searchon);
	if($searchon[0] == 'anywhere'){
	$pstmt.= " WHERE BOOK.author_id in (select id from AUTHOR where name like '%$searchfor%') 
	OR BOOK.publisher_id in (select id from PUBLISHER where name like '%$searchfor%') 
	OR BOOK.title LIKE '%$searchfor%'";
	}
	else {
		foreach($searchon as $s){
		if($s == "title")
			$where .= "BOOK.title LIKE '%$searchfor%' ";
		if($s == "isbn")
			$where .= "BOOK.isbn LIKE '%$searchfor%' ";
		if($s == "author")
			$where .= "BOOK.author_id in (select id from AUTHOR where name like '%$searchfor%') ";
		if($s == "publisher")
			$where .= "BOOK.publisher_id in (select id from PUBLISHER where name like '%$searchfor%') ";
		if($s != $searchon[sizeof($searchon)-1])
			$where.="OR ";
	}
	$pstmt.=" WHERE ".$where;
	}
	if($category != "all")
	$pstmt.=" OR BOOK.category_id ".'='." $category";

	$stmt = $pdo->prepare("$pstmt");
	$stmt -> execute();

	$result = $stmt->fetchall(PDO::FETCH_ASSOC);

	//echo "$searchfor";




		$searchlist = '';
		foreach($searchon as $s)
		$searchlist.= $s.',';
		$searchlist = substr($searchlist, 0, -1);
		echo "searchlist: $searchlist ok";


function display_books($result, $cart_contents, $searchfor, $searchlist, $category){

	//echo "$searchfor";

foreach ($result as $row){

	$book_details = '<tr><td align = \'left\'><button name= \'btnCart\' id= \'btnCart\' onClick= \'cart( '.'"'.$row['ISBN'].'"'.', '.'"'.$searchfor.'"'.', '.'"'.$searchlist.'"'.', '.'"'.$category.'", '.'"'.$row['Price'].'"'.')\' ';
	
	if($cart_contents != 1){
	if(in_array(trim($row['ISBN']), $cart_contents) || $row['quantity'] < 1){
	$book_details .= ' disabled';
	}
	}

	$book_details .= '> Add to Cart</button></td><td rowspan= \'2\'  align= \'left\'> '.str_replace("'", "\'", $row['Title']).' </br>
		By '.$row['Author'].':</b> McGraw-Hill,</br><b>ISBN:</b> '.$row['ISBN'].'</t> <b>Price:</b> '.$row['Price'].'</td></tr><tr>
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
				
					<h6> <fieldset>Your Shopping Cart has 0 items</fieldset> </h6>
				
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
			if(count($result) > 0)
			display_books($result, $cart_contents, $searchfor, $searchlist, $category);
			else
			display_error($searchfor);
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
