<html>
<head>
<title> Add Customer </title>
</head>
<body>
<?php

error_reporting(-1);
ini_set('display_errors', 'On');

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

        $stmt1 = $pdo -> prepare("INSERT INTO USER (type) VALUE (:type)");
        $type = 'R';
        $stmt1->bindParam(':type', $type);
        $stmt1->execute();

		$stmt2 = $pdo -> prepare("INSERT INTO REGISTERED_USER (id, username, pin, first_name, last_name, 
        address, city, state, zip, credit_card, card_number, expiration) 
        VALUES (LAST_INSERT_ID(), :username, :pin, :first_name, :last_name, 
        :address, :city, :state, :zip, :credit_card, :card_number, :expiration)");

		$stmt2->bindParam(':username', $username);
		$stmt2->bindParam(':pin', $pin);
		$stmt2->bindParam(':first_name', $firstname);
		$stmt2->bindParam(':last_name', $lastname);
		$stmt2->bindParam(':address', $address);
		$stmt2->bindParam(':city', $city);
		$stmt2->bindParam(':state', $state);
		$stmt2->bindParam(':zip', $zip);
		$stmt2->bindParam(':credit_card', $credit_card);
		$stmt2->bindParam(':card_number', $card_number);
		$stmt2->bindParam(':expiration', $expiration);

		$stmt2->execute();

        $stmt3 = $pdo -> prepare("SELECT LAST_INSERT_ID() as id");
        $stmt3 -> execute();

        $cart_user_id = $stmt3->fetch();

        print_r($cart_user_id);

        $stmt4 = $pdo -> prepare("INSERT INTO SHOPPING_CART (user_id) VALUES (:user_id)" );
        $stmt4->bindParam(':user_id', $cart_user_id['id']);
        $stmt4->execute();

      //  mysqli_stmt_bind_param($stmt, "sisssssssss", $username, $pin, $firstname, 
      //  $lastname, $address, $city, $state, $zip, $credit_card, $card_number, $expiration);

      // mysqli_stmt_bind_param($stmt);

             $affected_rows = $stmt1->rowCount();

        if($affected_rows == 1){
            header("Location: screen2.php"); 
            exit;
            $stmt=null;
			$pdo=null;

        }

        else{
            echo 'Error<br />';

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
}

?>
</body>
</html>