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
if( $_SESSION['uid'] )
{
	require( "includes/smarty/Smarty.class.php" );
	$smarty = new Smarty();
	$smarty->template_dir = "templates/".$CONFIG['Template']."/";
	$smarty->compile_dir = $templates_compiledir;
	$smarty->assign( "template", $CONFIG['Template'] );
	$smarty->assign( "LANG", $_LANG );
	$smarty->assign( "logo", $CONFIG['LogoURL'] );
	$smarty->assign( "companyname", $CONFIG['CompanyName'] );
	$result = select_query( "tblemails", "", array(
		"id" => $id,
		"userid" => $_SESSION['uid']
	) );
	$data = mysql_fetch_array( $result );
	$date = $data['date'];
	$subject = $data['subject'];
	$message = $data['message'];
	$date = fromMySQLDate( $date, "time" );
	$smarty->assign( "date", $date );
	$smarty->assign( "subject", $subject );
	$smarty->assign( "message", $message );
	$template_output = $smarty->fetch( "viewemail.tpl" );
	echo $template_output;
}
else
{
	header( "Location: index.php" );
	exit();
}
?>