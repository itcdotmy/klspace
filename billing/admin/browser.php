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
$aInt = new adminInterface( "Browser" );
$aInt->title = $aInt->lang( "utilities", "browser" );
$aInt->sidebar = "browser";
$aInt->icon = "browser";
if( $action == "delete" )
{
	delete_query( "tblbrowserlinks", array( "id" => $id ) );
	header( "Location: ".$_SERVER['PHP_SELF'] );
	exit();
}
if( $action == "add" )
{
	insert_query( "tblbrowserlinks", array( "name" => $sitename, "url" => $siteurl ) );
	header( "Location: ".$_SERVER['PHP_SELF'] );
	exit();
}
$result = select_query( "tblbrowserlinks", "", "", "name", "ASC" );
while ( $data = mysql_fetch_array( $result ) )
{
	$browserlinks[] = $data;
}
$aInt->assign( "browserlinks", $browserlinks );
$result = select_query( "tbladmins", "template", array( "id" => $_SESSION['adminid'] ) );
$data = mysql_fetch_array( $result );
$template = $data[0];
$content = "";
if( $template == "blend" )
{
	$content = "<div style=\"float:left;width:160px;border:1px solid #ccc;margin:0 20px 0 0;padding:10px;\">\r\n&nbsp;&raquo; <a href=\"http://dereferer.ws/?http://www.whmcs.com/\" target=\"brwsrwnd\">WHMCS Homepage</a><br />\r\n&nbsp;&raquo; <a href=\"http://dereferer.ws/?https://www.whmcs.com/members/\" target=\"brwsrwnd\">WHMCS Client Area</a><br />";
	foreach( $browserlinks as $link )
	{
		$content .= "&nbsp;&raquo; <a href=\"".$link['url']."\" target=\"brwsrwnd\">".$link['name']." <img src=\"images/delete.gif\" width=\"10\" border=\"0\" onclick=\"doDelete('".$link['id']."')\"></a><br />";
	}
	$content .= "<br />\r\n<form method=\"post\" action=\"browser.php?action=add\">\r\n<b>".$aInt->lang( "browser", "addnew" )."</b><br /><br />\r\n".$aInt->lang( "browser", "sitename" ).":<br><input type=\"text\" name=\"sitename\" size=\"25\" style=\"font-size:9px;\"><br />\r\n".$aInt->lang( "browser", "url" ).":<br><input type=\"text\" name=\"siteurl\" size=\"25\" value=\"http://\" style=\"font-size:9px;\"><br /><br />\r\n<input type=\"submit\" value=\"".$aInt->lang( "browser", "add" )."\" style=\"font-size:9px;\">\r\n</form>\r\n</div>";
}
$content .= "<iframe width=\"1000\" height=\"580\" src=\"http://dereferer.ws/?http://www.whmcs.com\" name=\"brwsrwnd\"></iframe>";
$jscode = "function doDelete(id) {\r\n	if(confirm(\"".$aInt->lang( "browser", "deleteq" )."\")) {\r\n		window.location='".$_SERVER['PHP_SELF']."?action=delete&id='+id;\r\n		return false;\r\n	}\r\n}\r\n";
$aInt->content = $content;
$aInt->jquerycode = $jquerycode;
$aInt->jscode = $jscode;
$aInt->display();
?>