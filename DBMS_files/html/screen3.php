
<!-- Figure 3: Search Result Screen by Prithviraj Narahari, php coding: Alexander Martens -->

<?php
require_once('../PDO_connect.php');
if(isset($_GET['search'])){

	$searchfor = trim($_GET['searchfor']);
	$search_in = ($_GET['searchon']);
	$category = trim($_GET['category']);

	echo "$category";

	$no_attributes = sizeof($search_in)-1;
	$title_exists = 0;
	$isbn_exists = 0;
	$pstmt = "select isbn as ISBN, title as Title, (select name from AUTHOR where BOOK.author_id = id) as Author, (select name from CATEGORY where BOOK.category_id = id) as Category, (select name from PUBLISHER where BOOK.publisher_id = id) as Publisher, price as Price from BOOK";
	$attr = 0;
	$title = FALSE;
	$isbn = FALSE;
	$author = FALSE;
	$publisher = FALSE;
	$tables = "";
	$attr = "";
	$where = "";
	if($search_in[0] == 'anywhere'){
	$pstmt.= " WHERE BOOK.author_id in (select id from AUTHOR where name like '%$searchfor%') 
	OR BOOK.publisher_id in (select id from PUBLISHER where name like '%$searchfor%') 
	OR BOOK.title LIKE '%$searchfor%'";
	}
	else {
		foreach($search_in as $s){
		if($s == "title")
			$where .= "BOOK.title LIKE '%$searchfor%' ";
		if($s == "isbn")
			$where .= "BOOK.isbn LIKE '%$searchfor%' ";
		if($s == "author")
			$where .= "BOOK.author_id in (select id from AUTHOR where name like '%$searchfor%') ";
		if($s == "publisher")
			$where .= "BOOK.publisher_id in (select id from PUBLISHER where name like '%$searchfor%') ";
		if($s != $search_in[sizeof($search_in)-1])
			$where.="OR ";


	}
	$pstmt.=" WHERE ".$where;
	}
	if($category != "all")
	$pstmt.=" OR BOOK.category_id ".'='." $category";

	echo "$pstmt";

	$stmt = $pdo->prepare("$pstmt");
	$stmt -> execute();

	$result = $stmt->fetchall(PDO::FETCH_ASSOC);

}


function display_books($result){

foreach ($result as $row){
	echo '<tr><td align='.'left'.'><button name='.'btnCart'. 'id='.'btnCart' .'onClick='.'cart("'.$row['ISBN'].'", "", '."Array".', "all")'.'>Add to Cart</button></td><td rowspan='.'2' .'align='.'left'.'>'.$row['Title'].'</br>
		By '. $row['Author'].':</b> McGraw-Hill,</br><b>ISBN:</b> '.$row['ISBN'].'</t> <b>Price:</b> '.$row['Price'].'</td></tr><tr>
		<td align='.'left'.'><button name='.'review'.' id='.'review'.' onClick='.'review("'.$row['ISBN'].'", "'.$row['Title'].'")'.'>Reviews</button></td></tr><tr>
		<td colspan='.'2'.'><p>_______________________________________________</p></td></tr>';
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
	function cart(isbn, searchfor, searchon, category){
		window.location.href="screen3.php?cartisbn="+ isbn + "&searchfor=" + searchfor + "&searchon=" + searchon + "&category=" + category;
	}
	function add_to_cart(isbn){
		
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
			display_books($result);
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
