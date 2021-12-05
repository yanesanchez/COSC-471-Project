<?php
require_once('../PDO_connect.php');
ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');
//print_r($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
	<title> REPORTS </title>
	<style>
		td { padding: 5px; }
		th { padding: 5px; }
		table { width: 520px; 
			margin: auto; 
			border-width: 2px; 
			border-style: solid; 
			border-color: blue; }
	</style>
</head>
<body align="center">
	<h1> ADMINISTRATOR REPORTS </h1>
<main>

	<!-- TOTAL NUMBER of REGISTERED CUSTOMERS in the system AT THE TIME AND DATE OF INQUIRY  -->
	<table>
		<tr>
			<th colspan="2"> Total Registered Customers </th>
		</tr>
		<tr>
			<td style="text-align: left;"> Registered Customers: </td>
			<td> 
			<?php
			$stmt = $pdo -> prepare("SELECT count(*) from USER where type = 'R'");
			$stmt -> execute();
			$usersR = $stmt -> fetch(PDO::FETCH_ASSOC);
			foreach ($usersR as $u) {
				echo $u; 
			}
			?>
			</td>
		</tr>
		<tr>
			<td style="text-align: left;"> Date of Report: </td>
			<td> <?php echo date("m/d/Y h:ia") ?> </td>
		</tr>
	</table>


	<!-- TOTAL NUMBER of BOOK TITLES available in EACH CATEGORY -->
	<table>
		<tr>
			<th colspan="2"> Book Titles & Categories Available </th>
		</tr>
			<?php
			$stmt = $pdo -> prepare("SELECT name as n, count(title) as c from CATEGORY, BOOK where BOOK.category_id= CATEGORY.id group by name order by c desc");
			$stmt -> execute();
			$result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

			foreach ($result as $r) {
				echo "<tr>";
				echo "<td style='text-align: left;'>";	// category name
				echo $r['n']."</td>";
				echo "<td style='text-align: left;'>";	// count in category
				echo $r['c']."</td>";
				echo "</tr>";
			}

			?>
	</table>


	<!-- AVERAGE MONTHLY SALES, in dollars, for the CURRENT YEAR, ordered BY MONTH -->
	<table>
		<tr>
			<th colspan="2"> Average Monthly Sales <?php date("Y"); ?> </th>
		</tr>
			<?php
				// "select MONTHNAME(date) as month, truncate(avg(total),2) as avg from ORDER_PLACED where YEAR(date) = YEAR(CURDATE()) group by MONTHNAME(date)"
			$stmt = $pdo -> prepare("SELECT MONTHNAME(date) as month, truncate(avg(total),2) as avg from ORDER_PLACED where YEAR(date) = YEAR(CURDATE()) group by MONTHNAME(date)");
			$stmt -> execute();
			$monthAvg = $stmt -> fetchAll(PDO::FETCH_ASSOC);

			foreach($monthAvg as $m) {
				echo "<tr>";echo "<td style='text-align: left;'>";	// month
				echo $m['month']."</td>";
				echo "<td style='text-align: left;'>";	// average
				echo $m['avg']."</td>";
				echo "</tr>";
			}
			?>
	</table>


	<!-- ALL BOOK TITLES and the NUMBER OF REVIEWS for EACH BOOK -->
	<table>
		<tr>
			<th colspan="2"> All Book Titles and Reviews </th>
		</tr>
		<tr>
			<?php
				// "select title, count(description) as c from BOOK, REVIEW where BOOK.isbn = REVIEW.isbn group by title"
			?>
		</tr>
	</table>
</main>
</body>
</html>