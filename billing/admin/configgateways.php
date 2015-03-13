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
function defineGatewayField( $gateway, $type, $name, $defaultvalue, $friendlyname, $size, $description )
{
	global $GatewayFieldDefines;
	if( $type == "dropdown" )
	{
		$options = $description;
		$description = "";
	}
	else
	{
		$options = "";
	}
	$GatewayFieldDefines[$name] = array(
		"FriendlyName" => $friendlyname,
		"Type" => $type,
		"Size" => $size,
		"Description" => $description,
		"Value" => $defaultvalue,
		"Options" => $options
	);
}

require( "../dbconnect.php" );
require( "../includes/functions.php" );
require( "../includes/adminfunctions.php" );
$aInt = new adminInterface( "Configure Payment Gateways" );
$aInt->title = $aInt->lang( "setup", "gateways" );
$aInt->sidebar = "config";
$aInt->icon = "offlinecc";
$aInt->helplink = "Payment Gateways";
$aInt->requiredFiles( array( "gatewayfunctions", "modulefunctions" ) );
$GatewayValues = $GatewayConfig = $ActiveGateways = $DisabledGateways = array();
$result = select_query( "tblpaymentgateways", "", "", "setting", "ASC" );
while ( $data = mysql_fetch_array( $result ) )
{
	$gwv_gateway = $data['gateway'];
	$gwv_setting = $data['setting'];
	$gwv_value = $data['value'];
	$GatewayValues[$gwv_gateway][$gwv_setting] = $gwv_value;
}
$includedmodules = array();
$dh = opendir( "../modules/gateways/" );
while ( false !== ( $file = readdir( $dh ) ) )
{
	$fileext = explode( ".", $file, 2 );
	if( trim( $file ) && $file != "index.php" && $fileext[1] == "php" && !in_array( $fileext[0], $includedmodules ) )
	{
		$includedmodules[] = $fileext[0];
		$pieces = explode( ".", $file );
		$gwv_modulename = $pieces[0];
		require_once( ROOTDIR."/modules/gateways/".$file );
		if( $GatewayValues[$gwv_modulename]['type'] )
		{
			$ActiveGateways[] = $gwv_modulename;
		}
		else
		{
			$DisabledGateways[] = $gwv_modulename;
		}
		if( function_exists( $gwv_modulename."_config" ) )
		{
			$GatewayConfig[$gwv_modulename] = call_user_func( $gwv_modulename."_config" );
		}
		else
		{
			$GatewayFieldDefines = array();
			$GatewayFieldDefines['FriendlyName'] = array(
				"Type" => "System",
				"Value" => $GATEWAYMODULE[$gwv_modulename."visiblename"]
			);
			if( $GATEWAYMODULE[$gwv_modulename."notes"] )
			{
				$GatewayFieldDefines['UsageNotes'] = array(
					"Type" => "System",
					"Value" => $GATEWAYMODULE[$gwv_modulename."notes"]
				);
			}
			call_user_func( $gwv_modulename."_activate" );
			$GatewayConfig[$gwv_modulename] = $GatewayFieldDefines;
		}
	}
}
closedir( $dh );
$result = select_query( "tblpaymentgateways", "", "", "order", "DESC" );
$data = mysql_fetch_array( $result );
$lastorder = $data['order'];
if( $action == "activate" )
{
	check_token();
	delete_query( "tblpaymentgateways", array(
		"gateway" => $gateway
	) );
	++$lastorder;
	$type = "Invoices";
	if( function_exists( $gateway."_capture" ) )
	{
		$type = "CC";
	}
	insert_query( "tblpaymentgateways", array(
		"gateway" => $gateway,
		"setting" => "name",
		"value" => $GatewayConfig[$gateway]['FriendlyName']['Value'],
		"order" => $lastorder
	) );
	if( $GatewayConfig[$gateway]['RemoteStorage'] )
	{
		insert_query( "tblpaymentgateways", array(
			"gateway" => $gateway,
			"setting" => "remotestorage",
			"value" => "1"
		) );
	}
	insert_query( "tblpaymentgateways", array(
		"gateway" => $gateway,
		"setting" => "type",
		"value" => $type
	) );
	insert_query( "tblpaymentgateways", array(
		"gateway" => $gateway,
		"setting" => "visible",
		"value" => "on"
	) );
	header( "Location: ".$_SERVER['PHP_SELF']."?activated=true" );
	exit();
}
if( $action == "deactivate" )
{
	check_token();
	if( $gateway != $newgateway )
	{
		update_query( "tblhosting", array(
			"paymentmethod" => $newgateway
		), array(
			"paymentmethod" => $gateway
		) );
		update_query( "tblhostingaddons", array(
			"paymentmethod" => $newgateway
		), array(
			"paymentmethod" => $gateway
		) );
		update_query( "tbldomains", array(
			"paymentmethod" => $newgateway
		), array(
			"paymentmethod" => $gateway
		) );
		update_query( "tblinvoices", array(
			"paymentmethod" => $newgateway
		), array(
			"paymentmethod" => $gateway
		) );
		update_query( "tblorders", array(
			"paymentmethod" => $newgateway
		), array(
			"paymentmethod" => $gateway
		) );
		update_query( "tblaccounts", array(
			"gateway" => $newgateway
		), array(
			"gateway" => $gateway
		) );
		delete_query( "tblpaymentgateways", array(
			"gateway" => $gateway
		) );
		header( "Location: ".$_SERVER['PHP_SELF']."?deactivated=true" );
	}
	else
	{
		header( "Location: ".$_SERVER['PHP_SELF'] );
	}
	exit();
}
if( $action == "save" )
{
	check_token();
	$GatewayConfig[$module]['visible'] = array( "Type" => "yesno" );
	$GatewayConfig[$module]['name'] = array( "Type" => "text" );
	$GatewayConfig[$module]['convertto'] = array( "Type" => "text" );
	foreach( $GatewayConfig[$module] as $confname => $values )
	{
		if( $values['Type'] != "System" )
		{
			$result = select_query( "tblpaymentgateways", "COUNT(*)", array(
				"gateway" => $module,
				"setting" => $confname
			) );
			$data = mysql_fetch_array( $result );
			$count = $data[0];
			if( $count )
			{
				update_query( "tblpaymentgateways", array(
					"value" => html_entity_decode( trim( $field[$confname] ) )
				), array(
					"gateway" => $module,
					"setting" => $confname
				) );
			}
			else
			{
				insert_query( "tblpaymentgateways", array(
					"gateway" => $module,
					"setting" => $confname,
					"value" => html_entity_decode( trim( $field[$confname] ) )
				) );
			}
		}
	}
	header( "Location: ".$_SERVER['PHP_SELF']."?updated=true" );
	exit();
}
if( $action == "moveup" )
{
	$result = select_query( "tblpaymentgateways", "", array(
		"`order`" => $order
	) );
	$data = mysql_fetch_array( $result );
	$gateway = $data['gateway'];
	$order1 = $order - 1;
	update_query( "tblpaymentgateways", array(
		"order" => $order
	), array(
		"`order`" => $order1
	) );
	update_query( "tblpaymentgateways", array(
		"order" => $order1
	), array(
		"gateway" => $gateway
	) );
	header( "Location: ".$_SERVER['PHP_SELF'] );
	exit();
}
if( $action == "movedown" )
{
	$result = select_query( "tblpaymentgateways", "", array(
		"`order`" => $order
	) );
	$data = mysql_fetch_array( $result );
	$gateway = $data['gateway'];
	$order1 = $order + 1;
	update_query( "tblpaymentgateways", array(
		"order" => $order
	), array(
		"`order`" => $order1
	) );
	update_query( "tblpaymentgateways", array(
		"order" => $order1
	), array(
		"gateway" => $gateway
	) );
	header( "Location: ".$_SERVER['PHP_SELF'] );
	exit();
}
$result = select_query( "tblcurrencies", "id,code", "", "code", "ASC" );
$i = 0;
while ( $currenciesarray[$i] = mysql_fetch_assoc( $result ) )
{
	++$i;
}
array_pop( $currenciesarray );
ob_start();
if( $activated )
{
	infoBox( $aInt->lang( "global", "success" ), $aInt->lang( "gateways", "activatesuccess" ) );
}
if( $deactivated )
{
	infoBox( $aInt->lang( "global", "success" ), $aInt->lang( "gateways", "deactivatesuccess" ) );
}
if( $updated )
{
	infoBox( $aInt->lang( "global", "success" ), $aInt->lang( "gateways", "savesuccess" ) );
}
echo $infobox;
echo "<p>".$aInt->lang( "gateways", "intro" )." <a href=\"http://dereferer.ws/?http://docs.whmcs.com/Creating_Modules\" target=\"_blank\">http://docs.whmcs.com/Creating_Modules</a></p>";
echo "\r\n<p>";
echo "<form method=\"post\" action=\"{$PHP_SELF}\"><input type=\"hidden\" name=\"action\" value=\"activate\"><b>".$aInt->lang( "gateways", "activatemodule" ).":</b> ";
if( 0 < count( $DisabledGateways ) )
{
	$AlphaDisabled = array();
	foreach( $DisabledGateways as $modulename )
	{
		$AlphaDisabled[$GatewayConfig[$modulename]['FriendlyName']['Value']] = $modulename;
	}
	ksort( $AlphaDisabled );
	echo "<select name=\"gateway\">";
	foreach( $AlphaDisabled as $displayname => $modulename )
	{
		echo "<option value=\"{$modulename}\">".$displayname."</option>";
	}
	echo "</select> <input type=\"submit\" value=\"".$aInt->lang( "gateways", "activate" )."\">";
}
else
{
	echo $aInt->lang( "gateways", "nodisabledgateways" );
}
echo "</form></p>\r\n\r\n";
$count = 1;
$newgateways = "";
$result3 = select_query( "tblpaymentgateways", "", array( "setting" => "name" ), "order", "ASC" );
while ( $data = mysql_fetch_array( $result3 ) )
{
	$module = $data['gateway'];
	$order = $data['order'];
	echo "\r\n<form method=\"post\" action=\"";
	echo $PHP_SELF;
	echo "?action=save\">\r\n<input type=\"hidden\" name=\"module\" value=\"";
	echo $module;
	echo "\">\r\n\r\n<p align=\"left\"><b>";
	echo $count.". ".$GatewayConfig[$module]['FriendlyName']['Value']." <a href=\"#\" onclick=\"deactivateGW('{$module}');return false\" style=\"color:#cc0000\">";
	echo "(".$aInt->lang( "gateways", "deactivate" ).")</a></b> ";
	if( $order != "1" )
	{
		echo "<a href=\"{$PHP_SELF}?action=moveup&order={$order}\"><img src=\"images/moveup.gif\" align=\"absmiddle\" width=\"16\" height=\"16\" border=\"0\" alt=\"\"></a> ";
	}
	if( $order != $lastorder )
	{
		echo "<a href=\"{$PHP_SELF}?action=movedown&order={$order}\"><img src=\"images/movedown.gif\" align=\"absmiddle\" width=\"16\" height=\"16\" border=\"0\" alt=\"\"></a>";
	}
	echo "</p>\r\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\r\n<tr><td width=\"200\" class=\"fieldlabel\">";
	echo $aInt->lang( "gateways", "showonorderform" );
	echo "</td><td class=\"fieldarea\"><input type=\"checkbox\" name=\"field[visible]\"";
	if( $GatewayValues[$module]['visible'] )
	{
		echo " checked";
	}
	echo " /></td></tr>\r\n<tr><td class=\"fieldlabel\">";
	echo $aInt->lang( "gateways", "displayname" );
	echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"field[name]\" size=\"30\" value=\"";
	echo $GatewayValues[$module]['name'];
	echo "\"></td></tr>\r\n";
	foreach( $GatewayConfig[$module] as $confname => $values )
	{
		if( $values['Type'] != "System" )
		{
			$values['Name'] = "field[".$confname."]";
			if( isset( $GatewayValues[$module][$confname] ) )
			{
				$values['Value'] = $GatewayValues[$module][$confname];
			}
			echo "<tr><td class=\"fieldlabel\">".$values['FriendlyName']."</td><td class=\"fieldarea\">".moduleConfigFieldOutput( $values )."</td></tr>";
		}
	}
	if( 1 < count( $currenciesarray ) )
	{
		echo "<tr><td class=\"fieldlabel\">".$aInt->lang( "gateways", "currencyconvert" )."</td><td class=\"fieldarea\"><select name=\"field[convertto]\"><option value=\"\">".$aInt->lang( "global", "none" )."</option>";
		foreach( $currenciesarray as $currencydata )
		{
			echo "<option value=\"{$currencydata['id']}\"";
			if( $currencydata['id'] == $GatewayValues[$module]['convertto'] )
			{
				echo " selected";
			}
			echo ">{$currencydata['code']}</option>";
		}
		echo "</select></td></tr>";
	}
	echo "<tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\"><input type=\"submit\" value=\"";
	echo $aInt->lang( "global", "savechanges" );
	echo "\">";
	if( $GatewayConfig[$module]['UsageNotes']['Value'] )
	{
		echo " (".$GatewayConfig[$module]['UsageNotes']['Value'].")";
	}
	echo "</td></tr>\r\n</table>\r\n\r\n<br />\r\n\r\n</form>\r\n\r\n";
	if( $count != $order )
	{
		update_query( "tblpaymentgateways", array(
			"order" => $count
		), array(
			"setting" => "name",
			"gateway" => $module
		) );
	}
	++$count;
	$newgateways .= "<option value=\"".$module."\">".$GatewayConfig[$module]['FriendlyName']['Value']."</option>";
}
echo $aInt->jqueryDialog( "deactivategw", $aInt->lang( "gateways", "deactivatemodule" ), "<p>".$aInt->lang( "gateways", "deactivatemoduleinfo" )."</p><form method=\"post\" action=\"configgateways.php?action=deactivate\" id=\"deactivategwfrm\"><input type=\"hidden\" name=\"gateway\" value=\"\" id=\"deactivategwfield\"><div align=\"center\"><select name=\"newgateway\">{$newgateways}</select></div></form>", array(
	$aInt->lang( "gateways", "deactivate" ) => "\$('#deactivategwfrm').submit();",
	""
) );
$jscode .= "\r\nfunction deactivateGW(module) {\r\n	\$(\"#deactivategwfield\").val(module);\r\n	showDialog(\"deactivategw\");\r\n}";
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->jquerycode = $jquerycode;
$aInt->jscode = $jscode;
$aInt->display();
?>