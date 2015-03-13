<?php

function ipay88_config() {
    $configarray = array(
     "FriendlyName" => array("Type" => "System", "Value"=>"iPay88"),
     "mcode" => array("FriendlyName" => "Merchant Code", "Type" => "text", "Size" => "20", ),
     "mkey" => array("FriendlyName" => "Merchant Key", "Type" => "text", "Size" => "20", ),
     "instructions" => array("FriendlyName" => "Payment Instructions", "Type" => "textarea", "Rows" => "5", "Description" => "iPay88", ),
     //"testmode" => array("FriendlyName" => "Test Mode", "Type" => "yesno", "Description" => "Tick this to test", ),
    );
	return $configarray;
}

function iPay88_signature($source)
{
	return base64_encode(hex2bin(sha1($source)));
}

if ( !function_exists('hex2bin') )
{
	function hex2bin($hexSource)
	{
		for ($i=0;$i<strlen($hexSource);$i=$i+2)
		{
			$bin .= chr(hexdec(substr($hexSource,$i,2)));
		}
		return $bin;
	}
}

function ipay88_link($params) {

	# Gateway Specific Variables
	$gatewaymcode = $params['mcode'];
	$gatewaymkey = $params['mkey'];
	//$gatewaytestmode = $params['testmode'];

	# Invoice Variables
	$invoiceid = $params['invoiceid'];
	$description = $params["description"];
    $amount = $params['amount']; # Format: ##.##
    $currency = $params['currency']; # Currency Code

	# Client Variables
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$address1 = $params['clientdetails']['address1'];
	$address2 = $params['clientdetails']['address2'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = $params['clientdetails']['postcode'];
	$country = $params['clientdetails']['country'];
	$phone = $params['clientdetails']['phonenumber'];

	# System Variables
	$companyname = $params['companyname'];
	$systemurl = $params['systemurl'];
	$currency = $params['currency'];

	# Enter your code submit to the gateway...

$strToHash = $gatewaymkey . $gatewaymcode . $invoiceid . str_replace('.','',str_replace(',','',$amount)) .$currency;
$encrypstr = iPay88_signature($strToHash);


$code = '
	<br><br><center>Please select the payment option that you wish to pay
	<FORM method="post" name="ePayment" action="https://www.mobile88.com/epayment/entry.asp">

<INPUT type="hidden" name="MerchantCode" value="' . $gatewaymcode . '">

  <select name=PaymentId>
    <option value=2>Credit Card</option>
    <option value=6>Maybank2U</option>
    <option value=20>CIMB Clicks</option>
    <option value=16>FPX</option>
	<option value=10>AMBank Online</option>
	<option value=14>RHB Online</option>
    <option value=15>Hong Leong Bank Online</option>
    <option value=22>Webcash</option>
   </select>

  <INPUT type="hidden" name="RefNo" value="' . $invoiceid . '">
  <INPUT type="hidden" name="Amount" value="' . $amount . '">
  <INPUT type="hidden" name="Currency" value="' . $currency . '">
  <INPUT type="hidden" name="ProdDesc" value="' . $description . '">
  <INPUT type="hidden" name="UserName" value="'. $firstname . ' ' . $lastname .'">
  <INPUT type="hidden" name="UserEmail" value="' . $email . '">
  <INPUT type="hidden" name="UserContact" value="' . $phone . '">
  <INPUT type="hidden" name="Remark" value="' . $description . '">
  <INPUT type="hidden" name="Lang" value="UTF-8">
  <INPUT type="hidden" name="Signature" value="' . $encrypstr . '">
  <input type="hidden" name="ResponseURL" value="'.$params['systemurl'].'/modules/gateways/callback/ipay88_callback.php">
  <INPUT type="submit" value="Proceed with Payment" name="Submit">
</FORM><center>';

	return $code;
}

?>