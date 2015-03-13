<?php

function webcash_config() {
    $configarray = array(
     "FriendlyName" => array("Type" => "System", "Value"=>"Webcash Malaysia"),
     "mcode" => array("FriendlyName" => "Merchant Code", "Type" => "text", "Size" => "20", ),
     "instructions" => array("FriendlyName" => "Payment Instructions", "Type" => "textarea", "Rows" => "5", "Description" => "Webcash Malaysia", ),
     //"testmode" => array("FriendlyName" => "Test Mode", "Type" => "yesno", "Description" => "Tick this to test", ),
    );
	return $configarray;
}

function webcash_link($params) {

	# Gateway Specific Variables
	$gatewaymcode = $params['mcode'];
	//$gatewaytestmode = $params['testmode'];

	# Invoice Variables
	$invoiceid = $params['invoiceid'];
    $amount = $params['amount']; # Format: ##.##

	# Client Variables
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$country = $params['clientdetails']['country'];
	$phone = $params['clientdetails']['phonenumber'];

	# Enter your code submit to the gateway...

$order_date = date("d M Y");
$response_URL = $params['systemurl']."/modules/gateways/callback/webcash_callback.php";
$code = '
	<br><br><center>Webcash Malaysia Online Payment
	<FORM method="post" name="ePayment" action="https://webcash.com.my/wcgatewayinit.php">

  <INPUT type="hidden" name="ord_mercID" value="' . $gatewaymcode . '">
  <INPUT type="hidden" name="ord_mercref" value="' . $invoiceid . '">
  <INPUT type="hidden" name="ord_totalamt" value="' . $amount . '">
  <INPUT type="hidden" name="ord_shipname" value="'. $firstname . ' ' . $lastname .'">
  <INPUT type="hidden" name="ord_email" value="' . $email . '">
  <INPUT type="hidden" name="ord_telephone" value="' . $phone . '">
  <INPUT type="hidden" name="ord_date" value="' . $order_date . '">
  <INPUT type="hidden" name="ord_shipcountry" value="' . $country . '">  
  <input type="hidden" name="ord_returnURL" value="'. $response_URL . '">
  <INPUT type="submit" value="Proceed with Payment" name="Submit">
</FORM><center>';

	return $code;
}

?>