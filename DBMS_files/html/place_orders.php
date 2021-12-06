<?php
require_once('../PDO_connect.php');
ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');
//print_r($_GET);
if(isset($_GET['orderId'])){
	$placeOrder = $pdo ->prepare("update ORDER_PLACED set placed = 1 where id = ".$_GET['orderId']);
	$placeOrder->execute();
}

$getOrders = $pdo->prepare("select ORDER_PLACED.id as id, user_id, date, total, placed, address, username from USER, ORDER_PLACED where USER.id = ORDER_PLACED.user_id");
$getOrders->execute();
$getOrders = $getOrders->fetchAll(PDO::FETCH_ASSOC);


function display($result){


foreach ($result as $row){
if($row['placed']==0){
$status = "pending";
$disabled = "";
}
else{
$status = "ordered";
$disabled = ' disabled';
}

echo '<tr><td rowspan = ""><b>No. '.$row['id'].'</b></br><b> User: </b>'.$row['username'].'</br><b>Address: </b>'.$row['address'].'</br><b>Total: $</b>'.$row['total'].'</td>
<td align = "center"><b>Status: </b>'.$status.'</br>'.'<button name= \'place_order\' id= \'place_order\' onClick= \'order('.'"'.$row['id'].'"'.');return false;\''.$disabled.'>Order</button></td></tr>';

}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>PLACE ORDERS</title>
	<script>
	function order(id){
		window.location.href="place_orders.php?orderId="+ id;	
	}
	</script>
	<header align="center">Place Orders</header> 
</head>
<body>
<table align="center"  BORDER="1"> 
	<?php display($getOrders);?>
</table>

</body>
</html>