<?php

# Required File Includes
include("../../../dbconnect.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

$gatewaymodule = "ipay88"; # Enter your gateway module name here replacing template
$yourdomain = "http://****/clientarea.php?action=invoices";

$GATEWAY = getGatewayVariables($gatewaymodule);
if (!$GATEWAY["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback

# Get Returned Variables
$status = $_REQUEST["Status"];
$invoiceid = $_REQUEST["RefNo"];
$transid = $_REQUEST["TransId"];
$amount = $_REQUEST["Amount"];
$r_amount = str_replace(",","",$amount);
// $fee = $_REQUEST["Amount"] * 0.03 ; // additional fees to be charged by using this payment gateway example 0.03 = 3%
$fee = 0 ; // additional fees to be charged by using this payment , default set to 0 (no additonal fee)

$MerchantCode = $_POST["MerchantCode"];
$RefNo = $_POST["RefNo"];
$Amount = $_POST["Amount"];

function Requery($MerchantCode,$RefNo,$Amount){
  $query = "https://www.mobile88.com/epayment/enquiry.asp?MerchantCode=" . $MerchantCode . "&RefNo=" . str_replace(" ","%20",$RefNo) . "&Amount=" . $Amount;


  $url = parse_url($query);
  $host = $url["host"];
  $path = $url["path"] . "?" . $url["query"];
  $timeout = 3;
  $fp = fsockopen ($host, 80, $errno, $errstr, $timeout);

  if ($fp) {
    fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
    while (!feof($fp)) {
      $buf .= fgets($fp, 128);
    }
    $lines = split("\n", $buf);
    $Result = $lines[count($lines)-1];
    fclose($fp);
  } else {
    # enter error handing code here
  }


  return $Result;
}


$invoiceid = checkCbInvoiceID($invoiceid,$GATEWAY["name"]); # Checks invoice ID is a valid invoice number or ends processing

checkCbTransID($transid); # Checks transaction number isn't already in the database and ends processing if it does

if ($status=="1" && Requery($MerchantCode,$RefNo,$Amount)=="00") {
    # Successful
    addInvoicePayment($invoiceid,$transid,$r_amount,$fee,$gatewaymodule);
	logTransaction($GATEWAY["name"],$_POST,"Successful");
	echo '<p>Payment success ! redirecting to home page ....</p>';
	
} else {
	# Unsuccessful
    logTransaction($GATEWAY["name"],$_POST,"Unsuccessful");
	echo '<p>Payment failed ! redirecting to home page ....</p>';

}

?>
<script>
function gogo(){
  window.location.href="<?php echo $yourdomain ?>";
}
setTimeout("gogo()",3000);
</script>