<?php //00d4b
// *************************************************************************
// *                                                                       *
// * WHMCS - The Complete Client Management, Billing & Support Solution    *
// * Copyright (c) WHMCS Ltd. All Rights Reserved,                         *
// * Release Date: 14th December 2011                                      *
// * Version 5.0.3 Stable                                                  *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: info@whmcs.com                                                 *
// * Website: http://www.whmcs.com                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.  This software  or any other *
// * copies thereof may not be provided or otherwise made available to any *
// * other person.  No title to and  ownership of the  software is  hereby *
// * transferred.                                                          *
// *                                                                       *
// * You may not reverse  engineer, decompile, defeat  license  encryption *
// * mechanisms, or  disassemble this software product or software product *
// * license.  WHMCompleteSolution may terminate this license if you don't *
// * comply with any of the terms and conditions set forth in our end user *
// * license agreement (EULA).  In such event,  licensee  agrees to return *
// * licensor  or destroy  all copies of software  upon termination of the *
// * license.                                                              *
// *                                                                       *
// * Please see the EULA file for the full End User License Agreement.     *
// *                                                                       *
// *************************************************************************
require( "../dbconnect.php" );
require( "../includes/functions.php" );
require( "../includes/adminfunctions.php" );
$aInt = new adminInterface( "Configure General Settings" );
$aInt->title = $aInt->lang( "supportreq", "title" );
$aInt->sidebar = "help";
$aInt->icon = "support";

// Nulled begin
ob_start ();
infobox('Support Request', 'This page has been disabled. There is no reason to request support using this version.');
echo $infobox;
$content = ob_get_contents ();
ob_end_clean ();
$aInt->content = $content;
$aInt->display ();
exit();
// Nulled end

ob_start();
if( $action == "send" )
{
	if( $name == "" )
	{
		$errormessage .= $aInt->lang( "supportreq", "erroryourname" ).", ";
	}
	if( $email == "" )
	{
		$errormessage .= $aInt->lang( "supportreq", "erroryouremail" ).", ";
	}
	if( $subject == "" )
	{
		$errormessage .= $aInt->lang( "supportreq", "errorsubject" ).", ";
	}
	if( $message == "" )
	{
		$errormessage .= $aInt->lang( "supportreq", "errormessage" ).", ";
	}
	if( $errormessage == "" )
	{
		$mail = new PHPMailer();
		$mail->From = $email;
		$mail->FromName = $name;
		$mail->Subject = $subject;
		$mail->CharSet = $CONFIG['Charset'];
		if( $CONFIG['MailType'] == "mail" )
		{
			$mail->Mailer = "mail";
		}
		else if( $CONFIG['MailType'] == "smtp" )
		{
			$mail->IsSMTP();
			$mail->Host = $CONFIG['SMTPHost'];
			$mail->Port = $CONFIG['SMTPPort'];
			if( $CONFIG['SMTPSSL'] )
			{
				$mail->SMTPSecure = $CONFIG['SMTPSSL'];
			}
			if( $CONFIG['SMTPUsername'] )
			{
				$mail->SMTPAuth = true;
				$mail->Username = $CONFIG['SMTPUsername'];
				$mail->Password = $CONFIG['SMTPPassword'];
			}
			$mail->Sender = $email;
		}
		$mail->Body = $message;
		$mail->AddAddress( $department );
		$mail->Send();
		$mail->ClearAddresses();
		infoBox( $aInt->lang( "supportreq", "submitsuccess" ), $aInt->lang( "supportreq", "submitsuccessinfo" ) );
		echo $infobox;
		$sent = "true";
	}
	else
	{
		infoBox( $aInt->lang( "supportreq", "submiterror" ), $errormessage );
		echo $infobox;
	}
}
if( $sent != "true" )
{
	if( $errormessage == "" )
	{
		$name = $CONFIG['CompanyName'];
		$email = $CONFIG['Email'];
		$message = $aInt->lang( "supportreq", "entermessage" )."\r\n\r\n### DEBUG INFORMATION ###\r\n\r\nRegistered to: ".$licensing->keydata['registeredname']."\r\nLicense Type: ".$licensing->keydata['productname']."\r\nLicense Key: ".$license."\r\nLicense Expires: ".$licensing->keydata['nextduedate']."\r\nWHMCS URL: ".$CONFIG['SystemURL']."\r\nWHMCS Version: ".$CONFIG['Version']."\r\nPHP Version: ".phpversion()."\r\nMySQL Version: ".mysql_get_server_info();
	}
	echo "\r\n<form method=\"post\" action=\"";
	echo $PHP_SELF;
	echo "?action=send\">\r\n\r\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\r\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang( "supportreq", "yourname" );
	echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"name\" size=\"40\" value=\"";
	echo $name;
	echo "\"></td></tr>\r\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang( "supportreq", "youremail" );
	echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"email\" size=\"60\" value=\"";
	echo $email;
	echo "\"></td></tr>\r\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang( "support", "department" );
	echo "</td><td class=\"fieldarea\">";
	echo "<s";
	echo "elect name=\"department\"><option value=\"support@whmcs.com\">";
	echo $aInt->lang( "supportreq", "support" );
	echo "<option value=\"sales@whmcs.com\">";
	echo $aInt->lang( "supportreq", "sales" );
	echo "<option value=\"licensing@whmcs.com\">";
	echo $aInt->lang( "supportreq", "licensing" );
	echo "</select></td></tr>\r\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang( "fields", "subject" );
	echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"subject\" size=\"80\" value=\"";
	echo $subject;
	echo "\"></td></tr>\r\n</table>\r\n\r\n<br />\r\n\r\n<textarea rows=\"20\" name=\"message\" style=\"width:100%;\">";
	echo $message;
	echo "</textarea>\r\n\r\n<p align=center><input type=\"submit\" value=\"";
	echo $aInt->lang( "supportreq", "send" );
	echo "\" class=\"button\"> <input type=\"reset\" value=\"";
	echo $aInt->lang( "supportreq", "cancel" );
	echo "\" class=\"button\"></p>\r\n\r\n<p>* ";
	echo $aInt->lang( "supportreq", "debuginfo" );
	echo "</p>\r\n\r\n</form>\r\n\r\n";
}
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();
?>