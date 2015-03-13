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
run_hook( "ClientLogout", array(
	"userid" => $_SESSION['uid']
) );
unset( $_SESSION['uid'] );
unset( $_SESSION['cid'] );
unset( $_SESSION['upw'] );
setcookie( "WHMCSUID" );
setcookie( "WHMCSPW" );
$pagetitle = $_LANG['logouttitle'];
$breadcrumbnav = "<a href=\"index.php\">".$_LANG['globalsystemname']."</a> > <a href=\"clientarea.php\">".$_LANG['clientareatitle']."</a> > <a href=\"logout.php\">".$_LANG['logouttitle']."</a>";
$templatefile = "logout";
$pageicon = "images/clientarea_big.gif";
initialiseClientArea( $pagetitle, $pageicon, $breadcrumbnav );
outputClientArea( $templatefile );
?>