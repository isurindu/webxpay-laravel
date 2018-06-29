<?php
//load RSA library
include 'Crypt/RSA.php';
//initialize RSA
$rsa = new Crypt_RSA();
// unique_order_id|total_amount
$plaintext = '525|146.25';
$publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQChet+9WAmmIEmuhanqG2I6Rh4M
+BbsvFY5U5LLE4fd1sbqg4Lxw6a4gMXNV1/ot4Qbo1MMy7PA/s1feCW/wZ0vouL/
zQsbhArFDGz3bBS+yATG5BZfWPImxpahGmWJjEUMAh61QVsuhBe8qsPz/jmxSRT+
yAmaqEstn8Uqk7Uj9QIDAQAB
-----END PUBLIC KEY-----";
//load public key for encrypting
$rsa->loadKey($publickey);
$encrypt = $rsa->encrypt($plaintext);
//encode for data passing
$payment = base64_encode($encrypt);
//checkout URL
$url = 'https://webxpay.com/index.php?route=checkout/billing';

//custom fields
//cus_1|cus_2|cus_3|cus_4
$custom_fields = base64_encode('cus_1|cus_2|cus_3|cus_4');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pavan Welihinda">
    <title>WebXPay | Sample checkout form</title>
  </head>
  <body>     	  
       <form action="<?php echo $url; ?>" method="POST">
			First name: <input type="text" name="first_name" value="Pavan"><br>
			Last name: <input type="text" name="last_name" value="Welihinda"><br>
			Email: <input type="text" name="email" value="customer_email@email.com"><br>
			Contact Number: <input type="text" name="contact_number" value="0773606370"><br>
			Address Line 1: <input type="text" name="address_line_one" value="46/46, Green Lanka Building"><br>
			Address Line 2: <input type="text" name="address_line_two" value="Nawam Mawatha"><br>
			City: <input type="text" name="city" value="Colombo"><br>
			State: <input type="text" name="state" value="Western"><br>
			Zip/Postal Code: <input type="text" name="postal_code" value="10300"><br>
			Country: <input type="text" name="country" value="Sri Lanka"><br>
			currency: <input type="text" name="process_currency" value=""><br>
			CMS : <input type="text" name="cms" value="PHP">
			custom: <input type="text" name="custom_fields" value="<?php echo $custom_fields; ?>">
			<br/>		   
			<!-- POST parameters -->
			<input type="hidden" name="secret_key" value="D15AA1E2482BCD6D56E5F3A4B5DE4" >  
			<input type="hidden" name="payment" value="<?php echo $payment; ?>" >                         
			<input type="submit" value="Pay Now" >
        </form>      
  </body>
</html>
