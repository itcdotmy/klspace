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
include( "../includes/functions.php" );
$result = select_query( "tblconfiguration", "COUNT(*)", array( "setting" => "License" ) );
$data = mysql_fetch_array( $result );
if( !$data[0] )
{
	insert_query( "tblconfiguration", array( "setting" => "License" ) );
}
$licensing->remoteCheck();
if( $licensing->getStatus() != "Active" )
{
	header( "Location: licenseerror.php?licenseerror=".$licensing->getStatus() );
	exit();
}
if( $licensing->keydata['productname'] == "Owned License" || $licensing->keydata['productname'] == "Owned License No Branding" )
{
	$releasedate = "20111214";
	$validversion = false;
	foreach( $licensing->keydata['addons'] as $addon )
	{
		if( !( $addon['name'] == "Support and Updates" ) && !( $releasedate < str_replace( "-", "", $addon['nextduedate'] ) ) )
		{
			$validversion = true;
		}
	}
	if( !$validversion )
	{
		header( "Location: licenseerror.php?licenseerror=version" );
		exit();
	}
}
if( $_SESSION['adminid'] )
{
	redir( "", "index.php" );
}
if( $CONFIG['AdminForceSSL'] && $CONFIG['SystemSSLURL'] && ( !$_SERVER['HTTPS'] || $_SERVER['HTTPS'] == "off" ) )
{
	header( "Location: ".$CONFIG['SystemSSLURL']."/".$customadminpath );
	exit();
}
if( $CONFIG['DisableAdminPWReset'] )
{
	$disableadminforgottenpw = true;
}
if( $action && $disableadminforgottenpw )
{
	$action = "";
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<title>WHMCS - Login</title>\r\n";
echo "<style type=\"text/css\">\r\nbody {\r\n\tmargin: 0;\r\n	background-color: #F4F4F4;\r\n	background-image: url('images/loginbg.gif');\r\n	background-repeat: repeat-x;\r\n}\r\nbody, td, th {\r\n\tfont-family: Tahoma, Arial, Helvetica, sans-serif;\r\n\tfont-size: 12px;\r\n\tcolor: #333;\r\n}\r\na, a:visited {\r\n\tcolor: #000066;\r\n\ttext-decoration: underline;\r\n}\r\na:hover {\r\n\ttext-decoration: none;\r\n}\r\nform {\r\n\tmargin: 0;\r\n\tpad";
echo "ding: 0;\r\n}\r\ninput, select {\r\n\tfont-family: Tahoma, Arial, Helvetica, sans-serif;\r\n\tfont-size: 16px;\r\n}\r\n.login_inputs {\r\n\tpadding: 3px;\r\n	border: 1px solid #ccc;\r\n	font-size: 12px;\r\n}\r\n#logo {\r\n\ttext-align: center;\r\n	width: 420px;\r\n\tmargin: 30px auto 10px auto;\r\n\tpadding: 15px;\r\n}\r\n#login_container {\r\n\tcolor: #333;\r\n\tbackground-color: #fff;\r\n\ttext-align: left;\r\n\twidth: 430px;\r\n\tpadding: ";
echo "10px;\r\n\tmargin: 0 auto 10px auto;\r\n	-moz-border-radius: 10px;\r\n	-webkit-border-radius: 10px;\r\n	-o-border-radius: 10px;\r\n	border-radius: 10px;\r\n}\r\n#login_container #login {\r\n\ttext-align: left;\r\n\tmargin: 0;\r\n\tpadding: 20px 10px 20px 10px;\r\n}\r\n#login_container #login_msg {\r\n	background-color: #FAF4B8;\r\n	text-align: center;\r\n	padding: 10px;\r\n	margin: 0 0 1px 0;\r\n	-moz-border";
echo "-radius: 10px;\r\n	-webkit-border-radius: 10px;\r\n	-o-border-radius: 10px;\r\n	border-radius: 10px;\r\n}\r\n#login_container #extra_info {\r\n\tbackground-color: #D3D3D3;\r\n\ttext-align: left;\r\n\tpadding: 10px;\r\n\tmargin: 1px 0 0 0;\r\n	-moz-border-radius: 10px;\r\n	-webkit-border-radius: 10px;\r\n	-o-border-radius: 10px;\r\n	border-radius: 10px;\r\n}\r\n</style>\r\n";
echo "<script language=\"javascript\">\r\nfunction sf(){ document.frmlogin.username.focus(); }\r\n</script>\r\n</head>\r\n<body";
if( !$action )
{
	echo " onload=\"sf()\"";
}
echo ">\r\n<div id=\"logo\"><a href=\"login.php\"><img src=\"images/loginlogo.png\" alt=\"WHMCS\" border=\"0\" /></a></div>\r\n<div id=\"login_container\">\r\n";
if( !$action )
{
	if( $incorrect )
	{
		echo "  <div id=\"login_msg\">\r\n	";
		echo "<s";
		echo "pan style=\"font-size:14px;\">";
		echo "<s";
		echo "trong>Login Failed. Please Try Again.</strong></span><br>Your IP has been logged and admins notified of this<br />failed login attempt.\r\n  </div>\r\n";
	}
	else if( $logout )
	{
		echo "  <div id=\"login_msg\">\r\n	";
		echo "<s";
		echo "pan style=\"font-size:14px;\">";
		echo "<s";
		echo "trong>Logged Out</strong></span><br>You have been successfully logged out.\r\n  </div>\r\n";
	}
	else
	{
		echo "  <div id=\"login_msg\">\r\n	";
		echo "<s";
		echo "pan style=\"font-size:14px;\">";
		echo "<s";
		echo "trong>Welcome Back</strong></span><br>Please enter your login details below to authenticate.\r\n  </div>\r\n";
	}
	echo "  <div id=\"login\">\r\n	<form action=\"dologin.php\" method=\"post\" name=\"frmlogin\" id=\"frmlogin\">\r\n	  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\r\n		<tr>\r\n		  <td width=\"30%\" align=\"right\" valign=\"middle\">";
	echo "<s";
	echo "trong>Username</strong></td>\r\n		  <td align=\"left\" valign=\"middle\"><input type=\"text\" name=\"username\" size=\"30\" class=\"login_inputs\" /></td>\r\n		</tr>\r\n		<tr>\r\n		  <td width=\"30%\" align=\"right\" valign=\"middle\">";
	echo "<s";
	echo "trong>Password</strong></td>\r\n		  <td align=\"left\" valign=\"middle\"><input type=\"password\" name=\"password\" size=\"30\" class=\"login_inputs\" /></td>\r\n		</tr>\r\n		<tr>\r\n		  <td width=\"30%\" align=\"right\" valign=\"middle\"><input type=\"checkbox\" name=\"rememberme\" id=\"rememberme\" /></td>\r\n		  <td align=\"left\" valign=\"middle\"><label for=\"rememberme\" style=\"cursor:hand\">Remember me until I lo";
	echo "gout.</label></td>\r\n		</tr>\r\n		<tr>\r\n		  <td width=\"30%\" align=\"right\" valign=\"middle\">&nbsp;</td>\r\n		  <td align=\"left\" valign=\"middle\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><input type=\"submit\" value=\"Login\" class=\"button\" /></td><td align=\"right\">Language: ";
	echo "<s";
	echo "elect name=\"language\" class=\"login_inputs\"><option value=\"\">Default</option>";
	$adminlangs = array();
	$dh = opendir( "lang/" );
	while ( false !== ( $file = readdir( $dh ) ) )
	{
		if( is_file( "lang/{$file}" ) )
		{
			$adminlangs[] = substr( $file, 0, 0 - 4 );
		}
	}
	sort( $adminlangs );
	foreach( $adminlangs as $temp )
	{
		echo "<option value=\"{$temp}\"";
		if( $temp == $language )
		{
			echo " selected";
		}
		echo ">".ucfirst( $temp )."</option>";
	}
	closedir( $dh );
	echo "</select></td></tr></table></td>\r\n		</tr>\r\n	  </table>\r\n	</form>\r\n  </div>\r\n";
}
else if( $action == "remind" && !$disableadminforgottenpw )
{
	if( $sub == "send" )
	{
		$result = select_query( "tbladmins", "", array( "email" => $email ) );
		$data = mysql_fetch_array( $result );
		$firstname = $data['firstname'];
		$lastname = $data['lastname'];
		$username = $data['username'];
		$email = $data['email'];
		if( !$email )
		{
			echo "<div id=\"login_msg\">\r\n	";
			echo "<s";
			echo "pan style=\"font-size:14px;\">";
			echo "<s";
			echo "trong>Email Address Not Found</strong></span><br>Your IP has been logged and admins notified of this<br />failed reminder attempt.\r\n</div>\r\n";
		}
		else
		{
			$length = 10;
			$seeds = "ABCDEFGHIJKLMNPQRSTUVYXYZ0123456789abcdefghijklmnopqrstuvwxyz";
			$str = null;
			$seeds_count = strlen( $seeds ) - 1;
			$i = 0;
			while ( $i < $length )
			{
				$str .= $seeds[rand( 0, $seeds_count )];
				++$i;
			}
			$newpassword = $str;
			update_query( "tbladmins", array( "password" => md5( $newpassword ) ), array( "email" => $email ) );
			$message = "";
			if( $CONFIG['LogoURL'] )
			{
				$message = "<p><a href=\"".$CONFIG['Domain']."\" target=\"_blank\"><img src=\"".$CONFIG['LogoURL']."\" alt=\"".$CONFIG['CompanyName']."\" border=\"0\"></a></p>";
			}
			$message .= "<p>Dear {$firstname},</p><p>As requested, here is a new password for you to use to login to your WHMCS admin area.</p><p>Login Details<br>-------------------------------<br>Username: {$username}<br>Password: {$newpassword}</p><p>If you did not request this change, you should change your account login details as soon as possible.</p><p><a href=\"".$CONFIG['SystemURL']."/{$customadminpath}/\">".$CONFIG['SystemURL']."/{$customadminpath}/</a></p>";
			$mail = new PHPMailer();
			$mail->From = $CONFIG['SystemEmailsFromEmail'];
			$mail->FromName = $CONFIG['SystemEmailsFromName'];
			$mail->Subject = "New Password Generated";
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
				$mail->Hostname = $_SERVER['SERVER_NAME'];
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
				$mail->Sender = $mail->From;
			}
			if( $smtp_debug )
			{
				$mail->SMTPDebug = true;
			}
			$message = $message;
			$message_text = str_replace( "</p>", "\n\n", $message );
			$message_text = str_replace( "<br>", "\n", $message_text );
			$message_text = str_replace( "<br />", "\n", $message_text );
			$message_text = strip_tags( $message_text );
			$mail->Body = $message;
			$mail->AltBody = $message_text;
			$mail->AddAddress( $email );
			if( !$mail->Send() )
			{
				echo "<div id=\"login_msg\"><span style=\"font-size:14px;\"><strong>An Error Occurred</strong></span><br />There has been an error sending the message</div>";
			}
			else
			{
				echo "<div id=\"login_msg\"><span style=\"font-size:14px;\"><strong>Success!</strong></span><br />A New Password has been Emailed to You</div>";
				logActivity( "New Password Requested for Admin Username {$username}" );
			}
			$mail->ClearAddresses();
		}
	}
	else
	{
		echo "  <div id=\"login_msg\">\r\n	";
		echo "<s";
		echo "pan style=\"font-size:14px;\">";
		echo "<s";
		echo "trong>Password Reset</strong></span><br>Enter your registered email below to have a new password sent to it\r\n  </div>\r\n";
	}
	echo "  <div id=\"login\">\r\n	<form action=\"login.php\" method=\"post\" name=\"frmlogin\" id=\"frmlogin\">\r\n	<input type=\"hidden\" name=\"action\" value=\"remind\" />\r\n	<input type=\"hidden\" name=\"sub\" value=\"send\" />\r\n	  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\r\n		<tr>\r\n		  <td width=\"30%\" align=\"right\" valign=\"middle\">";
	echo "<s";
	echo "trong>Email</strong></td>\r\n		  <td align=\"left\" valign=\"middle\"><input type=\"text\" name=\"email\" size=\"40\" /></td>\r\n		</tr>\r\n		<tr>\r\n		  <td width=\"30%\" align=\"right\" valign=\"middle\">&nbsp;</td>\r\n		  <td align=\"left\" valign=\"middle\"><input type=\"submit\" value=\"Send Reminder\" class=\"button\" /></td>\r\n		</tr>\r\n	  </table>\r\n	</form>\r\n  </div>\r\n";
}
echo "  <div id=\"extra_info\">\r\n	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n	  <tr>\r\n		<td align=\"left\" valign=\"middle\">IP Logged: ";
echo "<strong>";
echo $remote_ip;
echo "</strong></td>\r\n		<td align=\"right\" valign=\"middle\">Powered by <a href=\"http://dereferer.ws/?http://www.whmcs.com/\" target=\"_blank\">WHMCS</a></td>\r\n	  </tr>\r\n	</table>\r\n  </div>\r\n</div>\r\n<div align=\"center\">";
if( $CONFIG['SystemSSLURL'] && !$CONFIG['AdminForceSSL'] )
{
	echo "<a href=\"";
	echo $CONFIG['SystemSSLURL']."/".$customadminpath;
	echo "\">Secure SSL Access</a>";
}
if( !$disableadminforgottenpw )
{
	if( $CONFIG['SystemSSLURL'] && !$CONFIG['AdminForceSSL'] )
	{
		echo " | ";
	}
	echo "<a href=\"login.php?action=remind\">Forgot your password?</a>";
}
echo "</div>\r\n</body>\r\n</html>";
?>