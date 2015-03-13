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
include( "dbconnect.php" );
include( "includes/functions.php" );
include( "includes/clientfunctions.php" );
$loginsuccess = false;
$username = trim( $username );
$password = trim( $password );
if( validateClientLogin( $username, $password ) )
{
	$loginsuccess = true;
	if( $rememberme )
	{
		setcookie( "WHMCSUID", $_SESSION['uid'], time() + 60 * 60 * 24 * 365 );
		setcookie( "WHMCSPW", $_SESSION['upw'], time() + 60 * 60 * 24 * 365 );
	}
}
if( $autoauthkey && $hash )
{
	$autoauthkey = "";
	require( "configuration.php" );
	if( $autoauthkey )
	{
		$login_uid = $login_cid = "";
		if( $timestamp < time() - 15 * 60 || time() < $timestamp )
		{
			exit( "Link expired" );
		}
		$hashverify = sha1( $email.$timestamp.$autoauthkey );
		if( $hashverify == $hash )
		{
			$result = select_query( "tblclients", "id,password,language", array(
				"email" => $email,
				"status" => array( "sqltype" => "NEQ", "value" => "Closed" )
			) );
			$data = mysql_fetch_array( $result );
			$login_uid = $data['id'];
			$login_pwd = $data['password'];
			$language = $data['language'];
			if( !$login_uid )
			{
				$result = select_query( "tblcontacts", "id,userid,password", array(
					"email" => $username,
					"subaccount" => "1",
					"password" => array( "sqltype" => "NEQ", "value" => "" )
				) );
				$data = mysql_fetch_array( $result );
				$login_cid = $data['id'];
				$login_uid = $data['userid'];
				$login_pwd = $data['password'];
				$result = select_query( "tblclients", "id,language", array(
					"id" => $login_uid,
					"status" => array( "sqltype" => "NEQ", "value" => "Closed" )
				) );
				$data = mysql_fetch_array( $result );
				$login_uid = $data['id'];
				$language = $data['language'];
			}
			if( $login_uid )
			{
				$fullhost = gethostbyaddr( $remote_ip );
				update_query( "tblclients", array(
					"lastlogin" => "now()",
					"ip" => $remote_ip,
					"host" => $fullhost
				), array(
					"id" => $login_uid
				) );
				$_SESSION['uid'] = $login_uid;
				if( $login_cid )
				{
					$_SESSION['cid'] = $login_cid;
				}
				$haship = $CONFIG['DisableSessionIPCheck'] ? "" : $remote_ip;
				$_SESSION['upw'] = md5( $login_uid.$login_cid.$login_pwd.$haship );
				if( $language )
				{
					$_SESSION['Language'] = $language;
				}
				run_hook( "ClientLogin", array(
					"userid" => $login_uid
				) );
				$loginsuccess = true;
			}
		}
	}
}
$gotourl = "";
if( $goto )
{
	$goto = trim( $goto );
	if( substr( $goto, 0, 7 ) == "http://" || substr( $goto, 0, 8 ) == "https://" )
	{
		$goto = "";
	}
	$gotourl = html_entity_decode( $goto );
}
else if( isset( $_SESSION['loginurlredirect'] ) )
{
	$gotourl = $_SESSION['loginurlredirect'];
	if( substr( $gotourl, 0 - 15 ) == "&incorrect=true" || substr( $gotourl, 0 - 15 ) == "?incorrect=true" )
	{
		$gotourl = substr( $gotourl, 0, strlen( $gotourl ) - 15 );
	}
	unset( $_SESSION['loginurlredirect'] );
}
if( !$gotourl )
{
	$gotourl = "clientarea.php";
}
if( !$loginsuccess )
{
	if( strpos( $gotourl, "?" ) )
	{
		$gotourl .= "&incorrect=true";
	}
	else
	{
		$gotourl .= "?incorrect=true";
	}
}
header( "Location: {$gotourl}" );
exit();
?>