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
define( "CLIENTAREA", true );
require( "dbconnect.php" );
require( "includes/functions.php" );
require( "includes/clientareafunctions.php" );
$pagetitle = $_LANG['bannedtitle'];
$breadcrumbnav = "<a href=\"index.php\">".$_LANG['globalsystemname']."</a> > <a href=\"banned.php\">".$_LANG['bannedtitle']."</a>";
$templatefile = "banned";
$pageicon = "";
initialiseClientArea( $pagetitle, $pageicon, $breadcrumbnav );
$ip = explode( ".", $remote_ip );
$ip = db_escape_numarray( $ip );
$remote_ip1 = $ip[0].".".$ip[1].".".$ip[2].".*";
$remote_ip2 = $ip[0].".".$ip[1].".*.*";
$result = full_query( "select * from tblbannedips where ip = '{$remote_ip}' OR ip = '{$remote_ip1}' OR ip = '{$remote_ip2}' ORDER BY id DESC" );
$data = mysql_fetch_array( $result );
$ip = $remote_ip;
$id = $data['id'];
$reason = $data['reason'];
$expires = fromMySQLDate( $data['expires'], "time" );
if( !$id )
{
	redir( "", "index.php" );
}
$smarty->assign( "ip", $ip );
$smarty->assign( "reason", $reason );
$smarty->assign( "expires", $expires );
outputClientArea( $templatefile );
?>