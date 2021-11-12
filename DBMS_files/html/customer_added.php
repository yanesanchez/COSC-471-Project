<html>
<head>
<title> Add Customer </title>
</head>
<body>
<?php
ob_start();
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');

print_r($_SESSION);
if(isset($_POST['register_submit'])){

    $data_missing = array();

    if(empty($_POST['username'])){
        $data_missing[] = 'username';
    }
    else {
        $username = trim($_POST['username']);
    }

    if(empty($_POST['pin'])){
        $data_missing[] = 'pin';
    }
    else {
        $pin = trim($_POST['pin']);
    
    }
    if(empty($_POST['firstname'])){
        $data_missing[] = 'firstname';
    }
    else {
        $firstname = trim($_POST['firstname']);
    }

    if(empty($_POST['lastname'])){
        $data_missing[] = 'lastname';
    }
    else {
        $lastname = trim($_POST['lastname']);
    }

    if(empty($_POST['address'])){
        $data_missing[] = 'address';
    }
    else {
        $address = trim($_POST['address']);
    }

    if(empty($_POST['city'])){
        $data_missing[] = 'city';
    }
    else {
        $city = trim($_POST['city']);
    }

    if(empty($_POST['state'])){
        $data_missing[] = 'state';
    }
    else {
        $state = trim($_POST['state']);
    }

    if(empty($_POST['zip'])){
        $data_missing[] = 'zip';
    }

    else {
        $zip = trim($_POST['zip']);
    }

    if(empty($_POST['credit_card'])){
        $data_missing[] = 'credit_card';
    }
    else {
        $credit_card = trim($_POST['credit_card']);
    }

    if(empty($_POST['card_number'])){
        $data_missing[] = 'card_number';
    }
    else {
        $card_number = trim($_POST['card_number']);
    }

    if(empty($_POST['expiration'])){
        $data_missing[] = 'expiration';
    }
    else {
        $expiration = date( "Y-m-d", strtotime(trim($_POST['expiration'])));

    }

    if(empty($data_missing)){

        require_once('../PDO_connect.php');

        if(!empty($_SESSION['temp_id'])){                                                       // create dummy registered user for temp user on search screen and populate it with these info
            $stmt = $pdo -> prepare("UPDATE REGISTERED_USER 
                                     set username = :username, pin = :pin, first_name = :first_name, last_name = :last_name, 
                                     address = :address, city = :city, state = :state, zip = :zip, 
                                     credit_card = :credit_card, card_number = :card_number, expiration =:expiration 
                                     where id = ".$_SESSION['temp_id']);
                                     
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':pin', $pin);
		$stmt->bindParam(':first_name', $firstname);
		$stmt->bindParam(':last_name', $lastname);
		$stmt->bindParam(':address', $address);
		$stmt->bindParam(':city', $city);
		$stmt->bindParam(':state', $state);
		$stmt->bindParam(':zip', $zip);
		$stmt->bindParam(':credit_card', $credit_card);
		$stmt->bindParam(':card_number', $card_number);
		$stmt->bindParam(':expiration', $expiration);           
        $stmt->execute();

            $stmt2 = $pdo -> prepare("SELECT * from TEMP_CART_ITEM, TEMP_SHOPPING_CART 
                                      WHERE TEMP_SHOPPING_CART.id = TEMP_CART_ITEM.cart_id 
                                      and TEMP_SHOPPING_CART.user_id = ".$_SESSION['temp_id']);

            $stmt2 -> execute();

            $temp_cart = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            print_r($temp_cart);
            
            $stmt3 = $pdo -> prepare("INSERT INTO SHOPPING_CART (user_id) VALUES (:user_id)" );
            $stmt3->bindParam(':user_id', $_SESSION['temp_id']);
            $stmt3->execute();

            $stmt4 = $pdo -> prepare("select id from SHOPPING_CART where user_id = ".$_SESSION['temp_id']);
            $stmt4 -> execute();
            $_SESSION['cart_id'] = $stmt4 -> fetchColumn();

            foreach ($temp_cart as $t){
                $stmt4 = $pdo -> prepare('insert into CART_ITEM (cart_id , isbn, price, quantity)
                                         values ('.$_SESSION['cart_id'].', \''.$t['isbn'].'\', '.$t['price'].', '.$t['quantity'].')');
                $stmt4 -> execute();
            }


            $stmt = $pdo -> prepare("delete from TEMP_CART_ITEM where user_id = ".$_SESSION['temp_id']);
            $stmt -> execute();

            $_SESSION['user_id'] = $_SESSION['temp_id'];
            $_SESSION['temp_id'] = '';
            $_SESSION['temp'] = false;
            $_SESSION['valid'] = true;
        }
        else {
            $stmt = $pdo -> prepare("INSERT INTO USER (type) VALUE (:type)");
            $type = 'R';
            $stmt->bindParam(':type', $type);
            $stmt->execute();
            $stmt = $pdo -> prepare("INSERT INTO REGISTERED_USER (id, username, pin, first_name, last_name, 
                                     address, city, state, zip, credit_card, card_number, expiration) 
                                     VALUES (LAST_INSERT_ID(), :username, :pin, :first_name, :last_name, 
                                    :address, :city, :state, :zip, :credit_card, :card_number, :expiration)");

            $stmt2 = $pdo -> prepare("SELECT LAST_INSERT_ID() as id");

	    	$stmt->bindParam(':username', $username);
	    	$stmt->bindParam(':pin', $pin);
	    	$stmt->bindParam(':first_name', $firstname);
	    	$stmt->bindParam(':last_name', $lastname);
	    	$stmt->bindParam(':address', $address);
	    	$stmt->bindParam(':city', $city);
	    	$stmt->bindParam(':state', $state);
	    	$stmt->bindParam(':zip', $zip);
	    	$stmt->bindParam(':credit_card', $credit_card);
	    	$stmt->bindParam(':card_number', $card_number);
	    	$stmt->bindParam(':expiration', $expiration);

	    	$stmt->execute();


             $stmt2 -> execute();

            $cart_user_id = $stmt2->fetch();

             print_r($cart_user_id);

             $stmt4 = $pdo -> prepare("INSERT INTO SHOPPING_CART (user_id) VALUES (:user_id)");
             $stmt4->bindParam(':user_id', $cart_user_id['id']);
             $stmt4->execute();

             $_SESSION['user_id'] = $cart_user_id['id'];
      //  mysqli_stmt_bind_param($stmt, "sisssssssss", $username, $pin, $firstname, 
      //  $lastname, $address, $city, $state, $zip, $credit_card, $card_number, $expiration);

      // mysqli_stmt_bind_param($stmt);
        }
       // $stmt5 = $pdo -> prepare("INSERT INTO CREDIT_CARD (user_id, credit_card, card_number, expiration) VALUES ( $_SESSION['user_id'], $credit_card, $card_number, $expiration)");
       // $stmt5->execute();

             $affected_rows = $stmt4->rowCount();
             echo $affected_rows;

        if($affected_rows > 0){
            header("Location: screen2.php"); 
            exit;
            $stmt=null;
			$pdo=null;

        }

        else{
            header("Location: customer_registration.php");

            $stmt=null;
			$pdo=null;
        }
   //         else {
   //         echo 'enter the following data <br />';
   //         foreach($data_missing as $missing){
   //         echo "$missing<br />";
   //              }
   //	}

    }
    else{
        header("Location: customer_registration.php");

        $stmt=null;
        $pdo=null;
    }
}

?>
</body>
</html>