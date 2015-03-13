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
include( "../includes/adminfunctions.php" );
if( !$adminpermsarray[$permid] )
{
	exit();
}
$result = select_query( "tbladmins", "language", array(
	"id" => $_SESSION['adminid']
) );
$data = mysql_fetch_array( $result );
$language = $data['language'];
$_ADMINLANG = array();
if( $_SESSION['adminlang'] )
{
	$language = $_SESSION['adminlang'];
}
$langfilepath = ROOTDIR."/".$customadminpath."/lang/".$language.".php";
if( file_exists( $langfilepath ) )
{
	include( $langfilepath );
}
else
{
	include( ROOTDIR."/".$customadminpath."/lang/english.php" );
}
logActivity( "Access Denied to {$adminpermsarray[$permid]}" );
echo "\r\n<html>\r\n<head>\r\n<title>WHMCS - ";
echo $_ADMINLANG['permissions']['accessdenied'];
echo "</title>\r\n<link href=\"templates/original/style.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n</head>\r\n<body>\r\n\r\n<br /><br /><br /><br /><br />\r\n<p align=\"center\" style=\"font-size:24px;\">";
echo $_ADMINLANG['permissions']['accessdenied'];
echo "</p>\r\n<p align=\"center\" style=\"font-size:18px;color:#FF0000;\">";
echo $_ADMINLANG['permissions']['nopermission'];
echo "</p>\r\n<br /><br />\r\n<p align=\"center\" style=\"font-size:18px;\">";
echo $_ADMINLANG['permissions']['action'];
echo ": ";
echo $adminpermsarray[$permid];
echo "</p>\r\n<br /><br /><br />\r\n<p align=\"center\"><input type=\"button\" value=\" &laquo; ";
echo $_ADMINLANG['global']['goback'];
echo " \" onClick=\"javascript:history.go(-1)\"></p>\r\n<br /><br />\r\n\r\n</body>\r\n</html>";
?>