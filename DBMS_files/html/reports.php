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
		td { padding: 5px; };
		th { padding: 10px; };
		table { width: 520px; margin: auto; border:2px solid blue;" };

	</style>
</head>
<body align="center">
	<h1> ADMINISTRATOR REPORTS </h1>
<main>
	<!-- TOTAL NUMBER of REGISTERED CUSTOMERS in the system AT THE TIME AND DATE OF INQUIRY  -->
	<table>
		<tr>
			<th colspan="2" class="title"> Total Registered Customers </th>
		</tr>
		<tr>
			<td style="text-align: left;"> Registered customers as of <?php echo date("m/d/Y h:ia")?> : </td>
			<td style="width: 30%;"> 
			<?php
				// "select count(type)  from USER where type = 'R'"
			$stmt = $pdo -> prepare("SELECT count(*) from USER where type = 'R'");
			$stmt -> execute();
			$usersR = $stmt -> fetch(PDO::FETCH_ASSOC);
			foreach ($usersR as $u) {
				echo $u; 
			}

			?>
		</td>
		</tr>
	</table>


	<!-- TOTAL NUMBER of BOOK TITLES available in EACH CATEGORY -->
	<table>
		<tr>
			<th colspan="2"> Book Titles & Categories Available </th>
		</tr>
		<tr>
			<td style="text-align: left;"><b> Nonfiction </b></td>
			<td>
				<?php
				// "select name as n, count(title) as c from CATEGORY, BOOK where BOOK.category_id= CATEGORY.id group by name order by c desc"
				?>
			</td>
		</tr>
		<tr>
			<td style="text-align: left;"><b> Fiction </b></td>
			<td>
				
			</td>
		</tr>
		<tr>
			<td style="text-align: left;"><b> Young Adult </b></td>
			<td>
				
			</td>
		</tr>
		<tr>
			<td style="text-align: left;"><b> Philosophy </b></td>
			<td>
				
			</td>
		</tr>
		<tr>
			<td style="text-align: left;"><b> Psychology </b></td>
			<td>
				
			</td>
		</tr>
	</table>


	<!-- AVERAGE MONTHLY SALES, in dollars, for the CURRENT YEAR, ordered BY MONTH -->
	<table>
		<tr>
			<th colspan="2"> Average Monthly Sales </th>
		</tr>
		<tr>
			<?php
				// "select MONTHNAME(date) as month, truncate(avg(total),2) as avg from ORDER_PLACED where YEAR(date) = YEAR(CURDATE()) group by MONTHNAME(date)"
			?>
		</tr>
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