<script> alert('Please enter all values')</script><!-- UI: Prithviraj Narahari, php code: Alexander Martens -->"
<head>
<title> CUSTOMER REGISTRATION </title>
</head>
<?php
ob_start();
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

if(isset($_POST['register_submit'])){
	//echo "register submit";
	//print_r($_POST);
	//print_r($_SESSION);

    $data_missing = array();

    if(empty($_POST['username'])){
        $data_missing[] = 'username';
    }
    else {

        require_once('../PDO_connect.php');
		$stmt = $pdo -> prepare("select id from REGISTERED_USER where username = '".$_POST['username']."'");
		$stmt -> execute();
		$is_user = $stmt ->rowCount();

		if($is_user > 0){
			$_SESSION['invalid_username'] = $_POST['username'];
			$data_missing[] = 'username';
		}
		else{
			$_SESSION['invalid_username'] = '';
			$username = trim($_POST['username']);
		}
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
        $expiration = $_POST['expiration'];

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

           // print_r($temp_cart);
            
            $stmt3 = $pdo -> prepare("INSERT INTO SHOPPING_CART (user_id) VALUES (:user_id)" );
            $stmt3->bindParam(':user_id', $_SESSION['temp_id']);
            $stmt3->execute();

            $stmt4 = $pdo -> prepare("select id from SHOPPING_CART where user_id = ".$_SESSION['temp_id']);
            $stmt4 -> execute();
            $cart_id = $stmt4 -> fetchColumn();
			echo "CART_ID : ".$cart_id;

            foreach ($temp_cart as $t){
                $stmt4 = $pdo -> prepare('insert into CART_ITEM (cart_id , isbn, price, quantity)
                                         values ('.$cart_id.', \''.$t['isbn'].'\', '.$t['price'].', '.$t['quantity'].')');
                $stmt4 -> execute();
            }

			echo $temp_cart['cart_id'];
            $stmt = $pdo -> prepare("delete from TEMP_CART_ITEM where cart_id = ".$_SESSION['cart_id']);
            $stmt -> execute();
			$stmt = $pdo -> prepare("delete from TEMP_SHOPPING_CART where user_id = ".$_SESSION['temp_id']);
            $stmt -> execute();

			$_SESSION['cart_id'] = $cart_id;
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

            // print_r($cart_user_id);

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
           //  echo $affected_rows;

        if($affected_rows > 0){
			$_SESSION['temp_id'] = '';
            $_SESSION['temp'] = false;
            $_SESSION['valid'] = true;
            header("Location: screen2.php"); 
            exit;
            $stmt=null;
			$pdo=null;

        }

        else{
            header("Location: customer_registration.php");
			exit;
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

<body>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<form id="register" action="" method="post">
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left" colspan="3">
				<input type="text" id="username" name="username" <?php if(!empty($_SESSION['invalid_username']))
																			echo 'placeholder="Username '.$_SESSION['invalid_username'].' is taken"';
																	   else if(!empty($_POST['username']))
																	   		echo "value=\"".$_POST['username'].'" placeholder="Enter your username">';?>
			</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" id="pin" name="pin">
			</td>
			<td align="right">
				Re-type PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" id="retype_pin" name="retype_pin">
			</td>
		</tr>
		<tr>
			<td align="right">
				Firstname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="firstname" name="firstname" <?php if(!empty($_POST['firstname'])) echo " value=\"".$_POST['firstname'].'"'?>placeholder="Enter your firstname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Lastname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="lastname" name="lastname" <?php if(!empty($_POST['lastname'])) echo " value=\"".$_POST['lastname'].'"'?>placeholder="Enter your lastname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Address<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="address" name="address"<?php if(!empty($_POST['address'])) echo " value=\"".$_POST['address'].'"'?>>
			</td>
		</tr>
		<tr>
			<td align="right">
				City<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="city" name="city"<?php if(!empty($_POST['city'])) echo " value=\"".$_POST['city'].'"'?>>
			</td>
		</tr>
		<tr>
			<td align="right">
				State<span style="color:red">*</span>:
			</td>
			<td align="left">
				<select id="state" name="state">
				<option selected disabled>select a state</option>
				<option>Michigan</option>
				<option>California</option>
				<option>Tennessee</option>
				</select>
			</td>
			<td align="right">
				Zip<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" id="zip" name="zip"<?php if(!empty($_POST['zip'])) echo " value=\"".$_POST['zip'].'"'?>>
			</td>
		</tr>
		<tr>
			<td align="right">
				Credit Card<span style="color:red">*</span>
			</td>
			<td align="left">
				<select id="credit_card" name="credit_card"<?php if(!empty($_POST['credit_card'])) echo " value=\"".$_POST['credit_card'].'"'?>>
				<option selected disabled>select a card type</option>
				<option>VISA</option>
				<option>MASTER</option>
				<option>DISCOVER</option>
				</select>
			</td>
			<td colspan="2" align="left">
				<input type="text" id="card_number" name="card_number" <?php if(!empty($_POST['card_number'])) echo "value=\"".$_POST['card_number'].'"'?> placeholder="Credit card number">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				Expiration Date<span style="color:red">*</span>:
			</td>
			<td colspan="2" align="left">
				<input type="text" id="expiration" name="expiration" <?php if(!empty($_POST['expiration'])) echo "value=\"".$_POST['expiration'].'"'?> placeholder="MM/YY">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"> 
				<input type="submit" id="register_submit" name="register_submit" value="Register">
			</td>
			</form>
			<form id="no_registration" action="index.php" method="post">
			<td colspan="2" align="center">
				<input type="submit" id="donotregister" name="donotregister" value="Don't Register">
			</td>
			</form>
		</tr>
	</table>
</body>
</HTML>