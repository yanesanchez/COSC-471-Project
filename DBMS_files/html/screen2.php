
<!-- Figure 2: Search Screen by Alexander -->

<?php
require_once('../PDO_connect.php');
	ob_start();
	session_start();
//	echo session_status();
//	print_r($_SESSION);
	?>

<html>
<head>
	<title>SEARCH - 3-B.com</title>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td>Search for: </td>
			<form action="screen3.php" method="get">
				<td><input name="searchfor" /></td>
				<td><input type="submit" name="search" value="Search" /></td>
		</tr>
		<tr>
			<td>Search In: </td>
				<td>
					<select name="searchon[]" multiple>
						<option value="anywhere" selected='selected'>Keyword anywhere</option>
						<option value="title"> Title </option>
						<option value="author"> Author </option>
						<option value="publisher"> Publisher </option>
						<option value="isbn"> ISBN </option>				
					</select>
				</td>
				<td><a href="shopping_cart.php"><input type="button" name="manage" value="Manage Shopping Cart" /></a></td>
		</tr>
		<tr>
			<td>Category: </td>
				<td><select name="category">
						<option value='all' selected='selected'>All Categories</option>
						<option value='1'> Nonfiction </option>
						<option value='2'> Education </option>
						<option value='3'> Philosophy </option>
						<option value='4'> Psychology </option>
						<option value='5'> Self Improvement </option>
						<option value='6'> Young Adult </option>
						<option value='7'> Fiction </option>	
						<option value='8'> Historical Fiction </option>
						<option value='9'> Mystery </option>			
					</select></td>
				</form>
	<form action="index.php" method="post">	
				<td><input type="submit" name="exit" value="EXIT 3-B.com" /></td>
			</form>
		</tr>
	</table>
</body>
</html>