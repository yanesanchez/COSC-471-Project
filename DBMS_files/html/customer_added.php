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
        $expiration = trim($_POST['expiration']);
    }

    if(empty($data_missing)){
		echo 'ok good';
        require_once('../mysqli_connect.php');

        $query = "INSERT INTO customer (username, pin, first_name, last_name, 
        address, city, state, zip, credit_card, card_number, expiration) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = @mysqli_prepare($dbc, $query);

        mysqli_stmt_bind_param($stmt, "sisssssssss", $username, $pin, $firstname, 
        $lastname, $address, $city, $state, $zip, $credit_card, $card_number, $expiration);

        mysqli_stmt_bind_param($stmt);

        $affected_rows = mysqli_stmt_affected_rows($stmt);
		echo 'good good';
        if($affected_rows == 1){
            echo 'Customer added';

            mysqli_stmt_close($stmt);

            mysqli_close($dbc);
        }

        else{
            echo 'Error<br />';
            echo mysqli_error();

            mysqli_stmt_close($stmt);

            mysqli_close($dbc);
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
<form id="register" action="customer_added.php" method="post">
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left" colspan="3">
				<input type="text" id="username" name="username" placeholder="Enter your username">
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
				<input type="text" id="firstname" name="firstname" placeholder="Enter your firstname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Lastname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="lastname" name="lastname" placeholder="Enter your lastname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Address<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="address" name="address">
			</td>
		</tr>
		<tr>
			<td align="right">
				City<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="city" name="city">
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
				<input type="text" id="zip" name="zip">
			</td>
		</tr>
		<tr>
			<td align="right">
				Credit Card<span style="color:red">*</span>
			</td>
			<td align="left">
				<select id="credit_card" name="credit_card">
				<option selected disabled>select a card type</option>
				<option>VISA</option>
				<option>MASTER</option>
				<option>DISCOVER</option>
				</select>
			</td>
			<td colspan="2" align="left">
				<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				Expiration Date<span style="color:red">*</span>:
			</td>
			<td colspan="2" align="left">
				<input type="text" id="expiration" name="expiration" placeholder="MM/YY">
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
</body>
</html>