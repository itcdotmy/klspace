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
$aInt = new adminInterface( "Manage Quotes" );
$aInt->requiredFiles( array( "clientfunctions", "invoicefunctions" ) );
$aInt->inClientsProfile = true;
$aInt->valUserID( $userid );
if( $delete == "true" )
{
	checkPermission( "Manage Quotes" );
	delete_query( "tblquotes", array(
		"id" => $quoteid
	) );
	logActivity( "Deleted Quote (ID: {$quoteid} - User ID: {$userid})" );
	header( "Location: ".$_SERVER['PHP_SELF']."?userid={$userid}" );
	exit();
}
ob_start();
$jscode = "function doDelete(id) {\r\nif(confirm(\"".$aInt->lang( "quotes", "deletesure" )."\")) {\r\nwindow.location='".$PHP_SELF."?userid=".$userid."&delete=true&quoteid='+id;\r\n}}";
echo "\r\n<div align=center><input type=\"button\" value=\"";
echo $aInt->lang( "quotes", "createnew" );
echo "\" class=\"button\" onClick=\"window.location='quotes.php?action=manage&userid=";
echo $userid;
echo "'\"></div>\r\n\r\n";
$currency = getCurrency( $userid );
$aInt->sortableTableInit( "id", "DESC" );
$result = select_query( "tblquotes", "COUNT(*)", array(
	"userid" => $userid
) );
$data = mysql_fetch_array( $result );
$numrows = $data[0];
$result = select_query( "tblquotes", "", array(
	"userid" => $userid
), $orderby, $order, $page * $limit.",{$limit}" );
while ( $data = mysql_fetch_assoc( $result ) )
{
	$id = $data['id'];
	$subject = $data['subject'];
	$validuntil = $data['validuntil'];
	$datecreated = $data['datecreated'];
	$stage = $aInt->lang( "status", str_replace( " ", "", strtolower( $data['stage'] ) ) );
	$total = $data['total'];
	$validuntil = fromMySQLDate( $validuntil );
	$datecreated = fromMySQLDate( $datecreated );
	$total = formatCurrency( $total );
	$tabledata[] = array(
		"<a href=\"quotes.php?action=manage&id={$id}\">{$id}</a>",
		$subject,
		$datecreated,
		$validuntil,
		$total,
		$stage,
		"<a href=\"quotes.php?action=manage&id={$id}\"><img src=\"images/edit.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"".$aInt->lang( "global", "edit" )."\"></a>",
		"<a href=\"#\" onClick=\"doDelete('{$id}');return false\"><img src=\"images/delete.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"".$aInt->lang( "global", "delete" )."\"></a>"
	);
}
echo $aInt->sortableTable( array(
	array(
		"id",
		$aInt->lang( "quotes", "quotenum" )
	),
	array(
		"subject",
		$aInt->lang( "quotes", "subject" )
	),
	array(
		"datecreated",
		$aInt->lang( "quotes", "createdate" )
	),
	array(
		"validuntil",
		$aInt->lang( "quotes", "validuntil" )
	),
	array(
		"total",
		$aInt->lang( "fields", "total" )
	),
	array(
		"stage",
		$aInt->lang( "quotes", "stage" )
	),
	"",
	""
), $tabledata );
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->jquerycode = $jquerycode;
$aInt->jscode = $jscode;
$aInt->display();
?>