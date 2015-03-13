<?php

# Bank Transfer Payment Gateway Module

function banktransfer_config() {

    $configarray = array(
     "FriendlyName" => array(
        "Type" => "System",
        "Value" => "Bank Transfer"
        ),
     "instructions" => array(
        "FriendlyName" => "Bank Transfer Instructions",
        "Type" => "textarea",
        "Rows" => "5",
        "Value" => "Bank Name:\nPayee Name:\nSort Code:\nAccount Number:",
        "Description" => "The instructions you want displaying to customers who choose this payment method - the invoice number will be shown underneath the text entered above",
        ),
    );

	return $configarray;

}

function banktransfer_link($params) {
    global $_LANG;

    $code = '<p>'.nl2br($params['instructions']).'<br />'.$_LANG['invoicerefnum'].': '.$params['invoiceid'].'</p>';

    return $code;

}

?>