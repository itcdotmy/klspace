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
if( $updatekey == "true" )
{
	$result = select_query( "tbladmins", "", array(
		"username" => $username,
		"password" => md5( $password )
	) );
	$data = mysql_fetch_array( $result );
	$id = $data['id'];
	$roleid = $data['roleid'];
	if( !$id )
	{
		$expire_date = date( "Y-m-d H:i:s", mktime( date( "H" ), date( "i" ) + $CONFIG['InvalidLoginBanLength'], date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) );
		if( !isset( $CONFIG['LoginFailures'] ) )
		{
			insert_query( "tblconfiguration", array( "setting" => "LoginFailures", "value" => "" ) );
		}
		$loginfailures = unserialize( $CONFIG['LoginFailures'] );
		++$loginfailures[$remote_ip];
		if( 3 <= $loginfailures[$remote_ip] )
		{
			unset( $loginfailures[$remote_ip] );
			insert_query( "tblbannedips", array(
				"ip" => $remote_ip,
				"reason" => "3 Invalid Login Attempts",
				"expires" => $expire_date
			) );
		}
		update_query( "tblconfiguration", array(
			"value" => serialize( $loginfailures )
		), array( "setting" => "LoginFailures" ) );
		$result = update_query( "tbladmins", array( "loginattempts" => "+1" ), array(
			"username" => $username
		) );
		$result = select_query( "tbladmins", "loginattempts", array(
			"username" => $username
		) );
		$data = mysql_fetch_array( $result );
		$loginattempts = $data['loginattempts'];
		if( 3 <= $loginattempts )
		{
			insert_query( "tblbannedips", array(
				"ip" => $remote_ip,
				"reason" => "3 Invalid Login Attempts",
				"expires" => $expire_date
			) );
			update_query( "tbladmins", array( "loginattempts" => "0" ), array(
				"username" => $username
			) );
		}
		sendAdminNotification( "system", "WHMCS Admin Failed Login Attempt", "<p>A recent login attempt failed.  Details of the attempt are below.</p><p>Date/Time: ".date( "d/m/Y H:i:s" )."<br>Username: {$username}<br>IP Address: {$remote_ip}<br>Hostname: ".gethostbyaddr( $remote_ip )."</p>" );
		logActivity( "Failed Admin Login Attempt - Username: {$username}" );
	}
	if( $roleid )
	{
		$result = select_query( "tbladminperms", "COUNT(*)", array(
			"roleid" => $roleid,
			"permid" => "64"
		) );
		$data = mysql_fetch_array( $result );
		$match = $data[0];
	}
	$newlicensekey = trim( $newlicensekey );
	if( !$newlicensekey )
	{
		exit( "You did not enter a new license key" );
	}
	if( !$id )
	{
		exit( "The admin username & password entered were incorrect" );
	}
	if( !$match )
	{
		exit( "You do not have permission to make this change" );
	}
	$attachments_dir = "";
	$downloads_dir = "";
	$customadminpath = "";
	include( ROOTDIR."/configuration.php" );
	$output = "<?php\r\n\$license = '".$newlicensekey."';\r\n\$db_host = '".$db_host."';\r\n\$db_username = '".$db_username."';\r\n\$db_password = '".$db_password."';\r\n\$db_name = '".$db_name."';\r\n\$cc_encryption_hash = '".$cc_encryption_hash."';\r\n\$templates_compiledir = '".$templates_compiledir."';\r\n";
	if( $mysql_charset )
	{
		$output .= "\$mysql_charset = '".$mysql_charset."';\r\n";
	}
	if( $attachments_dir )
	{
		$output .= "\$attachments_dir = '".$attachments_dir."';\r\n";
	}
	if( $downloads_dir )
	{
		$output .= "\$downloads_dir = '".$downloads_dir."';\r\n";
	}
	if( $customadminpath )
	{
		$output .= "\$customadminpath = '".$customadminpath."';\r\n";
	}
	if( $api_access_key )
	{
		$output .= "\$api_access_key = '".$api_access_key."';\r\n";
	}
	$output .= "?>";
	$fp = fopen( "../configuration.php", "w" );
	fwrite( $fp, $output );
	fclose( $fp );
	update_query( "tblconfiguration", array( "value" => "" ), array( "setting" => "License" ) );
	header( "Location: index.php" );
	exit();
}
if( !$licenseerror )
{
	$licenseerror = "invalid";
}
$licenseerror = strtolower( $licenseerror );
$licensing->forceRemoteCheck();
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<title>WHMCS - License ";
echo TitleCase( $licenseerror );
echo "</title>\r\n";
echo "<style type=\"text/css\">\r\nbody {\r\n\tmargin: 0;\r\n	background-color: #F4F4F4;\r\n	background-image: url('images/loginbg.gif');\r\n	background-repeat: repeat-x;\r\n}\r\nbody, td, th {\r\n\tfont-family: Tahoma, Arial, Helvetica, sans-serif;\r\n\tfont-size: 12px;\r\n\tcolor: #333;\r\n}\r\na, a:visited {\r\n\tcolor: #000066;\r\n\ttext-decoration: underline;\r\n}\r\na:hover {\r\n\ttext-decoration: none;\r\n}\r\nform {\r\n\tmargin: 0;\r\n\tpad";
echo "ding: 0;\r\n}\r\ninput, select {\r\n\tfont-family: Tahoma, Arial, Helvetica, sans-serif;\r\n\tfont-size: 16px;\r\n}\r\n.login_inputs {\r\n\tpadding: 3px;\r\n	border: 1px solid #ccc;\r\n	font-size: 12px;\r\n}\r\n#logo {\r\n\ttext-align: center;\r\n	width: 420px;\r\n\tmargin: 30px auto 10px auto;\r\n\tpadding: 15px;\r\n}\r\n#login_container {\r\n\tcolor: #333;\r\n\tbackground-color: #fff;\r\n\ttext-align: left;\r\n\twidth: 430px;\r\n\tpadding: ";
echo "10px;\r\n\tmargin: 0 auto 10px auto;\r\n	-moz-border-radius: 10px;\r\n	-webkit-border-radius: 10px;\r\n	-o-border-radius: 10px;\r\n	border-radius: 10px;\r\n}\r\n#login_container #login {\r\n\ttext-align: left;\r\n\tmargin: 0;\r\n\tpadding: 20px 10px 20px 10px;\r\n}\r\n#login_container #login_msg {\r\n	background-color: #FAF4B8;\r\n	text-align: center;\r\n	padding: 10px;\r\n	margin: 0 0 1px 0;\r\n	-moz-border";
echo "-radius: 10px;\r\n	-webkit-border-radius: 10px;\r\n	-o-border-radius: 10px;\r\n	border-radius: 10px;\r\n}\r\n#login_container #extra_info {\r\n\tbackground-color: #D3D3D3;\r\n\ttext-align: left;\r\n\tpadding: 10px;\r\n\tmargin: 1px 0 0 0;\r\n	-moz-border-radius: 10px;\r\n	-webkit-border-radius: 10px;\r\n	-o-border-radius: 10px;\r\n	border-radius: 10px;\r\n}\r\n</style>\r\n</head>\r\n<body>\r\n<div id=\"logo\"><a href=\"logi";
echo "n.php\"><img src=\"images/loginlogo.png\" alt=\"WHMCS\" border=\"0\" /></a></div>\r\n<div id=\"login_container\">\r\n  <div id=\"login_msg\">\r\n	";
echo "<span style=\"font-size:14px;\">";
echo "<strong>License ";
echo TitleCase( $licenseerror );
echo "</strong>\r\n  </div>\r\n  <div id=\"login\">\r\n\r\n";
if( $licenseerror == "suspended" )
{
	echo "<p>Your license key ";
	//echo $license;
	echo " has been suspended.  Possible reasons for this include:</p>\r\n<ul>\r\n<li>Your license is overdue on payment</li>\r\n<li>Your license has been suspended for being used on a banned domain</li>\r\n<li>Your license was found to be being used against the End User License Agreement</li>\r\n</ul>\r\n<p>Got a new license key?  <a href=\"licenseerror.php?licenseerror=change\">Click here to enter it</a></p>\r\n";
}
else if( $licenseerror == "pending" )
{
	echo "<p>The WHMCS License Key ";
	//echo $license;
	echo " you just tried to access is still pending. This error occurs when we have not yet received the payment for your license.</p>\r\n<p>Got a new license key?  <a href=\"licenseerror.php?licenseerror=change\">Click here to enter it</a></p>\r\n";
}
else if( $licenseerror == "invalid" )
{
	echo "<p>Your license key ";
	//echo $license;
	echo " is invalid. Possible reasons for this include:</p>\r\n<ul>\r\n<li>The license key has been entered incorrectly</li>\r\n<li>The domain being used to access your install has changed</li>\r\n<li>The IP address your install is located on has changed</li>\r\n<li>The directory you are using has changed</li>\r\n</ul>\r\n<p>If required, you can reissue your license from our client area on demand @ <a href=\"http://dereferer.ws/?https://www.whmcs.com/me";
	echo "mbers/clientarea.php\" target=\"_blank\">www.whmcs.com/members/clientarea.php</a> to update the allowed install location.</p>\r\n<p>Got a new license key?  <a href=\"licenseerror.php?licenseerror=change\">Click here to enter it</a></p>\r\n";
}
else if( $licenseerror == "expired" )
{
	echo "<p>Your license key ";
	//echo $license;
	echo " has expired!  To resolve this you can:</p>\r\n<ul>\r\n<li>Check your email for a copy of the invoice or payment reminders</li>\r\n<li>Order a new license from <a href=\"http://dereferer.ws/?http://www.whmcs.com/order.php\" target=\"_blank\">www.whmcs.com/order.php</a></li>\r\n</ul>\r\n<p>If you feel this message to be an error, please email us on <a href=\"mailto:licensing@whmcs.com\">licensing@whmcs.com</a></p>\r\n<p>Got a new license key?  <a href";
	echo "=\"licenseerror.php?licenseerror=change\">Click here to enter it</a></p>\r\n";
}
else if( $licenseerror == "version" )
{
	echo "<p>Your owned license support & updates period expired before this release!<br />So in order to use this latest version of WHMCS, you need to renew your support & updates package.  You can do this from the addons section of our client area @ <a href=\"http://dereferer.ws/?https://www.whmcs.com/members/clientarea.php\" target=\"_blank\">www.whmcs.com/members/clientarea.php</a></p>\r\n<p>If you feel this message to be an error, ple";
	echo "ase email us on <a href=\"mailto:licensing@whmcs.com\">licensing@whmcs.com</a></p>\r\n<p>Got a new license key?  <a href=\"licenseerror.php?licenseerror=change\">Click here to enter it</a></p>\r\n";
}
else if( $licenseerror == "noconnection" )
{
	echo "<p>WHMCS has not been able to verify your license for the last few days.</p>\r\n<p>To access your WHMCS Admin Area again, first the license needs to be verified.  So please check & ensure that you don't have any firewall or other rules blocking outgoing connections to our website.</p>\r\n<p>If you need assistance, email <a href=\"mailto:licensing@whmcs.com\">licensing@whmcs.com</a>.</p>\r\n";
}
else if( $licenseerror == "change" )
{
	echo "<p>You can change your license key by entering your admin login details and new key below. Requires full admin access permissions.</p>\r\n";
	if( !is_writable( "../configuration.php" ) )
	{
		echo "<p align=center style=\"color:#cc0000\"><b>You must set the permissions for the configuration.php file to 777 so it can be written to before you can change your license key</b></p>";
	}
	if( $loginincorrect )
	{
		echo "<p align=center><b>Login Details Incorrect</b></p>";
	}
	if( $keyblank )
	{
		echo "<p align=center><b>You must enter a new license key to change your key</b></p>";
	}
	echo "<form method=\"post\" action=\"";
	echo $PHP_SELF;
	echo "?licenseerror=change&updatekey=true\">\r\n<table align=center>\r\n<tr><td align=\"right\">Username:</td><td><input type=\"text\" name=\"username\"></td></tr>\r\n<tr><td align=\"right\">Password:</td><td><input type=\"password\" name=\"password\"></td></tr>\r\n<tr><td align=\"right\">New License Key:</td><td><input type=\"text\" name=\"newlicensekey\"></td></tr>\r\n</table>\r\n<p align=\"center\"><input type=\"submit\" value=\"Change License Key\"></p>\r\n</form>";
	echo "\r\n";
}
echo "\r\n  </div>\r\n\r\n\r\n</body>\r\n</html>";
?>