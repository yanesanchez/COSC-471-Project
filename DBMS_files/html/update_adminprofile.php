<script>alert('Please enter all values')</script><!DOCTYPE HTML>
<head>
<title>UPDATE ADMIN PROFILE</title>



</head>
<?php
ob_start();
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

if(empty($_SESSION['admin'])){                                                       // create dummy registered user for temp user on search screen and populate it with these info
	header("Location: customer_registration.php");
	exit;
	$stmt=null;
	$pdo=null;
}
else{
	require_once('../PDO_connect.php');
	$getName = $pdo -> prepare("select username from USER where id = ".$_SESSION['user_id']);
	$getName->execute();
	$getName = $getName->fetch(PDO::FETCH_COLUMN);

	if(isset($_POST['update_submit'])){
	//echo "register submit";
	//print_r($_POST);
	//print_r($_SESSION);

    $data_missing = array();

    if(!empty($_POST['pin']) && !empty($_POST['retype_pin'])){
		if($_POST['pin'] != $_POST['retype_pin']){
			$_SESSION['invalid_pin'] = true;
      	  $data_missing[] = 'pin';
		}
    	else {
			$_SESSION['invalid_pin'] = false;
       	 $pin = trim($_POST['pin']);
		}
    }
	else
	$data_missing[] = 'pin';

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

   /* if(empty($_POST['address'])){
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
    }*/

    if(empty($data_missing)){
        require_once('../PDO_connect.php');

        $stmt = $pdo -> prepare("update USER set pin = :pin, first_name = :first_name, last_name = :last_name
								where id = ".$_SESSION['user_id']);
																	//,address = :address, city = :city, state = :state, zip = :zip, credit_card = :credit_card, card_number = :card_number, expiration = :expiration
	    	$stmt->bindParam(':pin', $pin);
	    	$stmt->bindParam(':first_name', $firstname);
	    	$stmt->bindParam(':last_name', $lastname);
	    	/*$stmt->bindParam(':address', $address);
	    	$stmt->bindParam(':city', $city);
	    	$stmt->bindParam(':state', $state);
	    	$stmt->bindParam(':zip', $zip);
	    	$stmt->bindParam(':credit_card', $credit_card);
	    	$stmt->bindParam(':card_number', $card_number);
	    	$stmt->bindParam(':expiration', $expiration);*/

	    	$stmt->execute();

             $affected_rows = $stmt->rowCount();

        if($affected_rows > 0){

            header("Location: admin_tasks.php"); 
            exit;
            $stmt=null;
			$pdo=null;

        }

        else{
            header("Location: update_adminprofile.php");
			exit;
            $stmt=null;
			$pdo=null;
        }
    }

}
}
?>

</head>
<body>
	<form id="update_profile" action="" method="post">
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="right">
				Username: 
			</td>
			<td colspan="1" align="left">
			<?php echo $getName; ?>
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
		<!--<tr>
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
		</tr>-->
		<tr>
			<td align="right" colspan="2">
				<input type="submit" id="update_submit" name="update_submit" value="Update">
			</td>
			</form>
		<form id="cancel" action="index.php" method="post">	
			<td align="left" colspan="2">
				<input type="submit" id="cancel_submit" name="cancel_submit" value="Cancel">
			</td>
		</tr>
	</table>
	</form>
</body>
</html>