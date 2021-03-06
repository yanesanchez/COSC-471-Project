<?php
require_once('../PDO_connect.php');

ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');
//print_r($_GET);

if(isset($_GET['addType'])){			// different format for authors - (first_name, last_name) vs (name) 
	if($_GET['addType'] == 'author')
		$values = "(first_name, last_name) values ('".$_GET['addValue']."', '".$_GET['addLName']."');"; // second half of insert statement in author format
	else 
	$values = "(name) values ('".$_GET['addValue']."');";   // second half of insert statement in category/publisher format
	$type = strtoupper($_GET['addType']);
	$addStmt = $pdo -> prepare('insert into '.$type.$values);
	$addStmt->execute();
}
if(isset($_GET['delType'])){
	if($_GET['delType'] == 'book'){			//delete authors, categories and publishers by id, delete books by isbn
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
if(isset($_GET['isbn'])){			// add books, similar to screen 3
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



function display_books($getBooks){   // called in html below, copied from shopping cart
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

														<!-- onClick functions, values appear in url/$_GET-->
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
<body> 														<!-- most of this is copied from shopping cart -->
		<table align="center" style="border:2px solid grey;">
		<tr>
			<td valign = "top"> <!-- cell -->
				<div id="book" style="overflow:auto;height:180px;width:450px;"> <!-- scroll thingy -->
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">     <!-- table -->
						<th>Remove</th><th width='60%'>Book Description</th><th width='10%'>Price</th> <!-- table headers -->
						<?php display_books($getBooks);?> <!-- display function called in each cell-->
					</table> <!-- close the table -->
				</div>  <!-- close the div -->
			</td>	<!-- close the cell -->
			<td valign = "top"> <!-- cell -->
				<div id="book" style="overflow:auto;height:180px;width:450px;"> <!-- scroll thingy -->											<!-- add book table -->
<table style="border:2px solid gray;" WIDTH="100%"> 
<tr>										<!-- add table headers -->
		<td colspan="2" align="center">New Book
			</td>
</tr>
<tr>
<td>
	<input type="text" id="title" name="title" placeholder="Title" style="width: 92%;">
</td>
<td>
	<input type="text" id="auth_id" name="auth_id" placeholder="Author ID" style="width: 92%;">
</td>
</tr>																			
<tr>
	<td>
<input type="text" id="cat_id" name="cat_id" placeholder="Category ID" style="width: 92%;">
</td>
<td>
<input type="text" id="pub_id" name="pub_id" placeholder="Publisher ID" style="width: 92%;">
</td>
<tr><td>
<input type="text" id="isbn" name="isbn" placeholder="ISBN" style="width: 92%;"></td>
<td>
<input type="text" id="price" name="price" placeholder="Price" style="width: 92%;">
</td>
</tr>
<tr><td align = "center" colspan = "2">						<!-- getElementById('input id')  -->
<button name="add_book" id="add_book" onClick="add_book(document.getElementById('title').value, document.getElementById('isbn').value, 
													    document.getElementById('auth_id').value, document.getElementById('cat_id').value,
														document.getElementById('pub_id').value,document.getElementById('price').value,);return false;">Update</button>
</td>
</tr>
</tr>
</table>
</tr>
</table>
				</div>  <!-- close the div -->
			</td>	<!-- close the cell -->
		</tr>
		<tr>
	<table align="center" style="border:2px solid gray;">
		<tr>
			<td valign = "top">
				<div id="authors" style="overflow:auto;height:180px;width:450px;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th>Remove</th><th>First Name</th><th>Last Name</th><th>ID</th>
						<?php display_authors($getAuthors);?>
					</table>
				</div>
			</td>
			<td valign = "top">
			<div id="authors" style="overflow:auto;height:180px;width:450px;">
			<table style="border:2px solid gray;"  WIDTH="100%">
			<tr>
			<td colspan="2" align="center">New Author
			</td>	
</tr>
<tr>
					<td valign = "top">											<!-- add author -->
				
				<tr><td>
				<input type="text" id="authorf" name="authorf" placeholder="First name" style="width: 92%;">
				</td><td>
				<input type="text" id="authorl" name="authorl" placeholder="Last name" style="width: 92%;">
				</td>
				</tr>
				<tr><td colspan = "2"  align="center">
				<button name="add_auth" id="add_auth" onClick="add('author', document.getElementById('authorf').value, document.getElementById('authorl').value);return false;" style="width: 30%;">Update</button>
				</td></tr>
			</td>
					</table>
					</tr>
</table>
				</div>
			</td>
		</tr>
		<tr>
		<table align="center" style="border:2px solid gray;">
		<tr>
			<td valign = "top">
				<div id="categories" style="overflow:auto;height:180px;width:450px;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th>Remove</th><th>Category</th><th>ID</th>
						<?php display_categories($getCategories);?> 
					</table>
				</div>
			</td>
			<td valign = "top">
			<div id="categories" style="overflow:auto;height:180px;width:450px;">											<!-- add category -->
				<table style="border:2px solid gray;" WIDTH="100%">
				<tr><td align="center">New Category
				</tr>
				<tr><td align="center">
				<input type="text" id="cat" name="cat" placeholder="Category name" style="width: 50%;">
				</td></tr>
				<tr><td align="center">
				<button name="add_cat" id="add_cat" onClick="add('category', document.getElementById('cat').value, '');return false;" style="width: 30%;">Update</button>
				</td></tr>
				</table>
				</tr>
</table>
				</div>	
			</td>
		</tr>
		<tr>
		<table align="center" style="border:2px solid gray;">
		<tr>
			<td valign = "top">
				<div id="publishers" style="overflow:auto;height:180px;width:450px;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th>Remove</th><th>Publisher</th><th>ID</th>
						<?php display_publishers($getPublishers);?>
					</table>
				</div>
			</td>
			<td valign = "top">
			<div id="categories" style="overflow:auto;height:180px;width:450px;">											<!-- add category -->
				<table style="border:2px solid gray;"  WIDTH="100%">
				<tr>	
			<td  align="center">New Publisher
			</td></tr>
				<tr><td align="center">
				<input type="text" id="pub" name="pub" placeholder="Publisher name" style="width: 50%;">
				</td></tr>
				<tr><td align = "center">
				<button name="add_pub" id="add_pub" onClick="add('publisher', document.getElementById('pub').value, '');return false;" style="width: 30%;">Update</button>
				</td></tr>
				</table>
				</tr>
</table>
				</div>	
			</td>
		</tr>
	</table>
</td>				<!-- end of row -->
<td>
</tr>
</table>
</body>
</html>

