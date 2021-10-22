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

		$stmt = $pdo -> prepare("INSERT INTO customer (username, pin, first_name, last_name, 
        address, city, state, zip, credit_card, card_number, expiration) 
        VALUES (:username, :pin, :first_name, :last_name, 
        :address, :city, :state, :zip, :credit_card, :card_number, :expiration)");

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

      //  mysqli_stmt_bind_param($stmt, "sisssssssss", $username, $pin, $firstname, 
      //  $lastname, $address, $city, $state, $zip, $credit_card, $card_number, $expiration);

       // mysqli_stmt_bind_param($stmt);

             $affected_rows = $stmt->rowCount();

        if($affected_rows == 1){
            echo 'Customer added';

            $stmt=null;
			$pdo=null;

        }

        else{
            echo 'Error<br />';

            $stmt=null;
			$pdo=null;
        }
 //       else {
   //         echo 'enter the following data <br />';

   //         foreach($data_missing as $missing){
    //            echo "$missing<br />";
          //  }
	//	}

    }
}

?>
</body>
</html>