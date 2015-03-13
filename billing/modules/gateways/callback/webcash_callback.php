<?php

# Required File Includes
include("../../../dbconnect.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

$gatewaymodule = "webcash"; # Enter your gateway module name here replacing template
$yourdomain = "http://billing.klspace.com/clientarea.php?action=invoices";

$GATEWAY = getGatewayVariables($gatewaymodule);
if (!$GATEWAY["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback

# Get Returned Variables
$status = $_POST['returncode'];
$invoiceid = $_POST['ord_mercref'];
$transid = $_POST['wcID'];
$amount = $_POST['ord_totalamt'];
$fee = 0;

if ($status=="100") {
    # Successful
    addInvoicePayment($invoiceid,$transid,$amount,$fee,$gatewaymodule);
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