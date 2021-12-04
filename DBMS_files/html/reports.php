<?php
ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');
print_r($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
	<title> REPORTS </title>
	<style>
		table.main { align: center; border:1px solid blue;" }
	</style>
</head>
<body>
	<h2> ADMINISTRATOR REPORTS </h2>
	<!-- TOTAL NUMBER of REGISTERED CUSTOMERS in the system AT THE TIME AND DATE OF INQUIRY  -->
	<table>
		<tr>
			<th colspan="2"> Total Registered Customers </th>
		</tr>
		<tr>
			<?php
				// query for number of users
					//<td>  </td>
				// time and date of inquiry
					//<td>  </td>
			?>
		</tr>
	</table>


	<!-- TOTAL NUMBER of BOOK TITLES available in EACH CATEGORY -->
	<table>
		<tr>
			<th colspan="2"> Book Titles & Categories Available </th>
		</tr>
		<tr>
			<?php
				
			?>
		</tr>
	</table>


	<!-- AVERAGE MONTHLY SALES, in dollars, for the CURRENT YEAR, ordered BY MONTH -->
	<table>
		<tr>
			<th colspan="2"> Average Monthly Sales </th>
		</tr>
		<tr>
			<?php
				
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
				
			?>
		</tr>
	</table>

</body>
</html>