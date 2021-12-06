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

echo '<tr><td ><div id = "info"><div id = "left"><b>No. '.$row['id'].'</b></br><b> User: </b>'.$row['username'].'</div><div id = "address"><b>Address: </b>'.$row['address'].'</div><div id = "right"><b>Date: </b>'.$row['date'].'</br><b>Total: $</b>'.$row['total'].'</div></div></td>
<td align = "center" ><div id = "button_box"><b>Status: </b>'.$status.'</br>'.'<button name= \'place_order\' id= \'place_order\' onClick= \'order('.'"'.$row['id'].'"'.');return false;\''.$disabled.'>Order</button></td></div></tr>';



}
}
?>

<!DOCTYPE html>
<html>
<head>
	<style>
#info{
	position: relative
		}
#left {
    float: left;
    width: 50%;
    padding: 0;
    margin: 0;
}
#right {
    float: right;
    width: 50%;
    padding: 0;
    margin: 0;
}
}
#address {
	position: absolute; 
	bottom: 0;
    float: center;
    width: 100%;
    padding: 0;
    margin: 0;
}
#button_box {
    float: center;
    width: 100%;
    padding: 0;
    margin: 0;
}
</style>
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