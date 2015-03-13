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
require( "../includes/adminfunctions.php" );
$aInt = new adminInterface( "Mass Mail" );
$aInt->title = $aInt->lang( "permissions", "21" );
$aInt->sidebar = "clients";
$aInt->icon = "massmail";
$aInt->helplink = "Mass Mail";
$aInt->requiredFiles( array( "customfieldfunctions" ) );
$clientgroups = getClientGroups();
$jscode = "function showMailOptions(type) {\r\n	\$(\"#product_criteria\").slideUp();\r\n	\$(\"#addon_criteria\").slideUp();\r\n	\$(\"#domain_criteria\").slideUp();\r\n	\$(\"#client_criteria\").slideDown();\r\n	if(type) \$(\"#\"+type+\"_criteria\").slideDown();\r\n}";
ob_start();
echo "\r\n<p>";
echo $aInt->lang( "massmail", "pagedesc" );
echo "</p>\r\n\r\n<form method=\"post\" action=\"sendmessage.php?type=massmail\">\r\n\r\n<h2>";
echo $aInt->lang( "massmail", "messagetype" );
echo "</h2>\r\n\r\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\r\n<tr><td width=\"20%\" class=\"fieldlabel\">";
echo $aInt->lang( "massmail", "emailtype" );
echo "</td><td class=\"fieldarea\">\r\n<input type=\"radio\" name=\"emailtype\" value=\"General\" id=\"typegen\" onclick=\"showMailOptions('')\" /> <label for=\"typegen\">";
echo $aInt->lang( "emailtpls", "typegeneral" );
echo "</label> &nbsp; <input type=\"radio\" name=\"emailtype\" value=\"Product/Service\" id=\"typeprod\" onclick=\"showMailOptions('product')\" /> <label for=\"typeprod\">";
echo $aInt->lang( "fields", "product" );
echo "</label> &nbsp; <input type=\"radio\" name=\"emailtype\" value=\"Addon\" id=\"typeaddon\" onclick=\"showMailOptions('addon')\" /> <label for=\"typeaddon\">";
echo $aInt->lang( "fields", "addon" );
echo "</label> &nbsp; <input type=\"radio\" name=\"emailtype\" value=\"Domain\" id=\"typedom\" onclick=\"showMailOptions('domain')\" /> <label for=\"typedom\">";
echo $aInt->lang( "fields", "domain" );
echo "</label>\r\n</tr></tr>\r\n</table>\r\n\r\n<div id=\"client_criteria\" style=\"display:none;\">\r\n\r\n<br />\r\n\r\n<h2>";
echo $aInt->lang( "massmail", "clientcriteria" );
echo "</h2>\r\n\r\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\r\n<tr><td width=\"20%\" class=\"fieldlabel\">";
echo $aInt->lang( "fields", "clientgroup" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"clientgroup[]\" size=\"4\" multiple=\"true\">";
foreach ( $clientgroups as $groupid => $data )
{
	echo "<option value=\"".$groupid."\">".$data['name']."</option>";
}
echo "</select></td></tr>\r\n";
$customfields = getCustomFields( "client", "", "", true );
foreach ( $customfields as $customfield )
{
	echo "<tr><td class=\"fieldlabel\">".$customfield['name']."</td><td class=\"fieldarea\">";
	if( $customfield['type'] == "tickbox" )
	{
		echo "<input type=\"radio\" name=\"customfield[".$customfield['id']."]\" value=\"\" checked /> No Filter <input type=\"radio\" name=\"customfield[".$customfield['id']."]\" value=\"cfon\" /> Checked Only <input type=\"radio\" name=\"customfield[".$customfield['id']."]\" value=\"cfoff\" /> Unchecked Only";
	}
	else
	{
		echo str_replace( "\"><option value=\"", "\"><option value=\"\">".$aInt->lang( "global", "any" )."</option><option value=\"", $customfield['input'] );
	}
	echo "</td></tr>";
}
echo "<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "global", "language" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"clientlanguage[]\" size=\"4\" multiple=\"true\"><option value=\"\" selected>";
echo $aInt->lang( "global", "default" );
echo "</option>";
$result = select_query( "tblclients", "DISTINCT language", "", "language", "ASC" );
while ( $data = mysql_fetch_array( $result ) )
{
	$language = $displanguage = $data['language'];
	if( !$language )
	{
		$displanguage = "Default";
	}
	echo "<option value=\"".$language."\" selected>".ucfirst( $displanguage )."</option>";
}
echo "</select></td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "massmail", "clientstatus" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"clientstatus[]\" size=\"3\" multiple=\"true\"><option value=\"Active\" selected>";
echo $aInt->lang( "status", "active" );
echo "</option><option value=\"Inactive\" selected>";
echo $aInt->lang( "status", "inactive" );
echo "</option><option value=\"Closed\" selected>";
echo $aInt->lang( "status", "closed" );
echo "</option></select></td></tr>\r\n</table>\r\n\r\n</div>\r\n<div id=\"product_criteria\" style=\"display:none;\">\r\n\r\n<br />\r\n\r\n<h2>";
echo $aInt->lang( "massmail", "productservicecriteria" );
echo "</h2>\r\n\r\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\r\n<tr><td width=\"20%\" class=\"fieldlabel\">";
echo $aInt->lang( "fields", "product" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"productids[]\" size=\"10\" multiple=\"true\">";
$result = select_query( "tblproducts", "tblproducts.id,tblproducts.name,tblproductgroups.name AS groupname", "", "tblproductgroups`.`order` ASC,`tblproducts`.`order` ASC,`tblproducts`.`name", "ASC", "", "tblproductgroups ON tblproducts.gid=tblproductgroups.id" );
while ( $data = mysql_fetch_array( $result ) )
{
	$id = $data['id'];
	$name = $data['name'];
	$groupname = $data['groupname'];
	echo "<option value=\"{$id}\">{$groupname} - {$name}</option>";
}
echo "</select></td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "massmail", "productservicestatus" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"productstatus[]\" size=\"5\" multiple=\"true\">\r\n<option value=\"Pending\">";
echo $aInt->lang( "status", "pending" );
echo "</option>\r\n<option value=\"Active\">";
echo $aInt->lang( "status", "active" );
echo "</option>\r\n<option value=\"Suspended\">";
echo $aInt->lang( "status", "suspended" );
echo "</option>\r\n<option value=\"Terminated\">";
echo $aInt->lang( "status", "terminated" );
echo "</option>\r\n<option value=\"Cancelled\">";
echo $aInt->lang( "status", "cancelled" );
echo "</option>\r\n<option value=\"Fraud\">";
echo $aInt->lang( "status", "fraud" );
echo "</option>\r\n</select></td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "massmail", "assignedserver" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"server[]\" size=\"5\" multiple=\"true\">";
$result = select_query( "tblservers", "", "", "name", "ASC" );
while ( $data = mysql_fetch_array( $result ) )
{
	$id = $data['id'];
	$name = $data['name'];
	echo "<option value=\"{$id}\">{$name}</option>";
}
echo "</select></td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "massmail", "sendforeachdomain" );
echo "</td><td class=\"fieldarea\"><input type=\"checkbox\" name=\"sendforeach\">";
echo $aInt->lang( "massmail", "tickboxsendeverymatchingdomain" );
echo "</td></tr>\r\n</table>\r\n\r\n</div>\r\n<div id=\"addon_criteria\" style=\"display:none;\">\r\n\r\n<br />\r\n\r\n<h2>";
echo $aInt->lang( "massmail", "addoncriteria" );
echo "</h2>\r\n\r\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\r\n<tr><td width=\"20%\" class=\"fieldlabel\">";
echo $aInt->lang( "fields", "addon" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"addonids[]\" size=\"10\" multiple=\"true\">";
$result = select_query( "tbladdons", "id,name", "", "name", "ASC" );
while ( $data = mysql_fetch_array( $result ) )
{
	$id = $data['id'];
	$addonname = $data['name'];
	echo "<option value=\"{$id}\">{$addonname}</option>";
}
echo "</select></td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "massmail", "addonstatus" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"addonstatus[]\" size=\"5\" multiple=\"true\">\r\n<option value=\"Pending\">";
echo $aInt->lang( "status", "pending" );
echo "</option>\r\n<option value=\"Active\">";
echo $aInt->lang( "status", "active" );
echo "</option>\r\n<option value=\"Suspended\">";
echo $aInt->lang( "status", "suspended" );
echo "</option>\r\n<option value=\"Terminated\">";
echo $aInt->lang( "status", "terminated" );
echo "</option>\r\n<option value=\"Cancelled\">";
echo $aInt->lang( "status", "cancelled" );
echo "</option>\r\n<option value=\"Fraud\">";
echo $aInt->lang( "status", "fraud" );
echo "</option>\r\n</select></td></tr>\r\n</table>\r\n\r\n</div>\r\n<div id=\"domain_criteria\" style=\"display:none;\">\r\n\r\n<br />\r\n\r\n<h2>";
echo $aInt->lang( "massmail", "domaincriteria" );
echo "</h2>\r\n\r\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\r\n<tr><td width=\"20%\" class=\"fieldlabel\">";
echo $aInt->lang( "massmail", "domainstatus" );
echo "</td><td class=\"fieldarea\">";
echo "<select name=\"domainstatus[]\" size=\"5\" multiple=\"true\">\r\n<option value=\"Pending\">";
echo $aInt->lang( "status", "pending" );
echo "</option>\r\n<option value=\"Pending Transfer\">";
echo $aInt->lang( "status", "pendingtransfer" );
echo "</option>\r\n<option value=\"Active\">";
echo $aInt->lang( "status", "active" );
echo "</option>\r\n<option value=\"Expired\">";
echo $aInt->lang( "status", "expired" );
echo "</option>\r\n<option value=\"Cancelled\">";
echo $aInt->lang( "status", "cancelled" );
echo "</option>\r\n<option value=\"Fraud\">";
echo $aInt->lang( "status", "fraud" );
echo "</option>\r\n</select></td></tr>\r\n</table>\r\n\r\n</div>\r\n\r\n<p align=\"center\"><input type=\"submit\" value=\"";
echo $aInt->lang( "massmail", "composemsg" );
echo "\" class=\"button\"></p>\r\n\r\n</form>\r\n\r\n<p>";
echo $aInt->lang( "massmail", "footnote" );
echo "</p>\r\n\r\n";
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->jscode = $jscode;
$aInt->display();
?>