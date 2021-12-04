<?php
require_once('../PDO_connect.php');

ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');


if(isset($_GET['addType'])){
	if($_GET['addType'] == 'author')
		$values = "(first_name, last_name) values ('".$_GET['addValue']."', '".$_GET['addLName']."');";
	else 
	$values = "(name) values ('".$_GET['addValue']."');";
	$type = strtoupper($_GET['addType']);
	$addStmt = $pdo -> prepare('insert into '.$type.$values);
	$addStmt->execute();
}
if(isset($_GET['delType'])){

	if($_GET['delType'] = 'book'){
		$idType = "isbn";
		$delId = "'".$_GET['delId']."'";
	}
	else{
		$idType = "id";
		$delId = $_GET['delId'];
	}

	$type = strtoupper($_GET['delType']);
	$delStmt = $pdo->prepare("delete from $type where ".$idType." = ".$delId);
	$delStmt->execute();

}
if(isset($_GET['isbn'])){
	$title = $_GET['title'];
	$isbn = $_GET['isbn'];
	$author = $_GET['author'];
	$category = $_GET['category'];
	$publisher = $_GET['publisher'];
	$price = $_GET['price'];

	$addStmt = $pdo -> prepare('insert into BOOK(isbn, title, author_id, category_id, publisher_id, price, quantity)
								values ("'.$isbn.'", "'.$title.'", '.$author.', '.$category.', '.$publisher.', '.$price.', 10)');
								$addStmt->execute();
							
}
$getBooks = $pdo->prepare("select isbn as ISBN, title as Title, 
(select first_name from AUTHOR where BOOK.author_id = id) as Author_fname, 
(select last_name from AUTHOR where BOOK.author_id = id) as Author_lname, 
(select name from CATEGORY where BOOK.category_id = id) as Category, 
(select name from PUBLISHER where BOOK.publisher_id = id) as Publisher, price as Price, quantity from BOOK");
$getAuthors = $pdo->prepare("select * from AUTHOR");
$getCategories = $pdo->prepare("select * from CATEGORY");
$getPublishers = $pdo->prepare("select * from PUBLISHER");

$getBooks ->execute();
$getAuthors ->execute();
$getCategories ->execute();
$getPublishers ->execute();

$getBooks = $getBooks->fetchAll(PDO::FETCH_ASSOC);
$getAuthors = $getAuthors->fetchAll(PDO::FETCH_ASSOC);
$getCategories = $getCategories->fetchAll(PDO::FETCH_ASSOC);
$getPublishers = $getPublishers->fetchAll(PDO::FETCH_ASSOC);
//print_r($_GET);
//print_r($_POST);



function display_books($getBooks){
	foreach ($getBooks as $row){
	echo '<tr><td><button name=\'delete\' id=\'delete\' onClick=\'del("book", '.'"'.$row['ISBN'].'"'.');return false;\'>Delete Item</button></td><td>'.$row['Title'].'</br>
	<b>By</b>'.$row['Author_fname'].' '.$row['Author_lname'].'</br><b>Publisher:</b> '.$row['Publisher'].'</td><td>'.$row['Price'].'</td></tr>';
	}
}
function display_authors($getAuthors){
	foreach ($getAuthors as $row){
		echo '<tr><td><button name=\'delete\' id=\'delete\' onClick=\'del("author", '.'"'.$row['id'].'"'.');return false;\'>Delete Item</button></td><td>'.$row['first_name'].'</td>
		<td>'.$row['last_name'].'</td><td>'.$row['id'].'</td></tr>';
	}
}
function display_categories($getCategories){
	foreach ($getCategories as $row){
	echo '<tr><td><button name=\'delete\' id=\'delete\' onClick=\'del("category", '.'"'.$row['id'].'"'.');return false;\'>Delete Item</button></td><td>'.$row['name'].'</td><td>'.$row['id'].'</td></tr>';
	}
}
function display_publishers($getPublishers){
	foreach ($getPublishers as $row){
		echo '<tr><td><button name=\'delete\' id=\'delete\' onClick=\'del("publisher", '.'"'.$row['id'].'"'.');return false;\'>Delete Item</button></td><td>'.$row['name'].'</td><td>'.$row['id'].'</td></tr>';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title> BOOKSTORE CATALOG </title>


	<script>
	function add(type, value, lname){
		window.location.href="manage_bookstorecatalog.php?addType="+ type + "&addValue=" + value+ "&addLName=" + lname;
	}
	function del(type, id){
		window.location.href="manage_bookstorecatalog.php?delType="+ type + "&delId=" + id;
	}
	function add_book(title, isbn, author, category, publisher, price){
		window.location.href="manage_bookstorecatalog.php?isbn="+ isbn + "&title=" + title + "&author=" + author + "&category=" + category + "&publisher=" + publisher + "&price=" + price;
	}

	</script>
		<header align="center"><h1>Catalog Manager</h1></header> 
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td  colspan="">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:500px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th>Remove</th><th width='60%'>Book Description</th><th width='10%'>Price</th>
						<?php display_books($getBooks);?>
					</table>
				</div>
			</td>
			<td  colspan="">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:300px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th>Remove</th><th>First Name</th><th>Last Name</th><th>ID</th>
						<?php display_authors($getAuthors);?>
					</table>
				</div>
			</td>
			<td  colspan="">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:300px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th>Remove</th><th>Category</th><th>ID</th>
						<?php display_categories($getCategories);?>
					</table>
				</div>
			</td>
			<td  colspan="">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:300px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th>Remove</th><th>Publisher</th><th>ID</th>
						<?php display_publishers($getPublishers);?>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">
				&nbsp;
			</td>
		</tr>
		<tr>
		<td colspan="" align="left">New Book
			</td>
			<td colspan="" align="left">New Author
			</td>		
			<td colspan="" align="left">New Category
			</td>		
			<td colspan="" align="left">New Publisher
			</td>
</tr>
<tr>
<td rowspan="4" align="left">
<table style="border:2px solid gray;">
<tr>
<td>
	<input type="text" id="title" name="title" placeholder="Title">
</td>
<td>
	<input type="text" id="auth_id" name="auth_id" placeholder="Author ID">
</td>
</tr>
<tr>
	<td>
<input type="text" id="cat_id" name="cat_id" placeholder="Category ID">
</td>
<td>
<input type="text" id="pub_id" name="pub_id" placeholder="Publisher ID">
</td>
<tr><td>
<input type="text" id="isbn" name="isbn" placeholder="ISBN"></td>
<td>
<input type="text" id="price" name="price" placeholder="Price">
</td>
</tr>
<tr><td align = "center" colspan = "2">
<button name="add_book" id="add_book" onClick="add_book(document.getElementById('title').value, document.getElementById('isbn').value, 
													    document.getElementById('auth_id').value, document.getElementById('cat_id').value,
														document.getElementById('pub_id').value,document.getElementById('price').value,);return false;">Go!</button>
</td>
</tr>
</table>
			<td valign = "top">
				<table style="border:2px solid gray;">
				<tr><td>
				<input type="text" id="authorf" name="authorf" placeholder="First name">
				</td></tr>
				<tr><td>
				<input type="text" id="authorl" name="authorl" placeholder="Last name">
				</td></tr>
				<tr><td>
				<button name="add_auth" id="add_auth" onClick="add('author', document.getElementById('authorf').value, document.getElementById('authorl').value);return false;">Go!</button>
				</td></tr>
				</table>	
			</td>
			<td valign = "top">
				<table style="border:2px solid gray;">
				<tr><td>
				<input type="text" id="cat" name="cat" placeholder="Category name">
				</td></tr>
				<tr><td>
				<button name="add_cat" id="add_cat" onClick="add('category', document.getElementById('cat').value, '');return false;">Go!</button>
				</td></tr>
				</table>	
			</td>
			<td valign = "top">
				<table style="border:2px solid gray;">
				<tr><td>
				<input type="text" id="pub" name="pub" placeholder="Publisher name">
				</td></tr>
				<tr><td>
				<button name="add_pub" id="add_pub" onClick="add('publisher', document.getElementById('pub').value, '');return false;">Go!</button>
				</td></tr>
				</table>
			</td>
			<td>		

			</td>
		</tr>
		<tr>



	</table>
</body>
</html>

