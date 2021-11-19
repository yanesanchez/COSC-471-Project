
<!-- screen 4: Book Reviews by Prithviraj Narahari, php coding: Alexander Martens-->

<?php
require_once('../PDO_connect.php');

$stmt = $pdo->prepare("SELECT review FROM REVIEW WHERE isbn ='".$_GET['isbn']."'");



$stmt->execute();

$reviews = $stmt->fetchAll(PDO::FETCH_COLUMN);

//print_r($reviews);

?>

<!DOCTYPE html>
<html>
<head>
<title>Book Reviews - 3-B.com</title>
<style>
.field_set
{
	border-style: inset;
	border-width:4px;
}
</style>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="center">
				<h5> Reviews For: <?php echo $_GET['title'];?></h5>
			</td>
			<td align="left">
				<h5> </h5>
			</td>
		</tr>
			
		<tr>
			<td colspan="2">
			<div id="bookdetails" style="overflow:scroll;height:200px;width:300px;border:1px solid black;">
			<?php  foreach ($reviews as $r) echo"$r"."<br><br>";?>
			<table>
						</table>
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<form action="screen2.php" method="post">
					<input type="submit" value="Done">
				</form>
			</td>
		</tr>
	</table>

</body>

</html>
