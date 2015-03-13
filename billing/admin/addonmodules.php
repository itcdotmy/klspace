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
$aInt = new adminInterface( "Addon Modules", false );
$aInt->title = $aInt->lang( "utilities", "addonmodules" );
$aInt->sidebar = "addonmodules";
$aInt->icon = "addonmodules";
if( $action == "getcats" )
{
	//$data = curlCall( "http://www.whmcs.com/members/communityaddonsfeed.php", "action=getcats" );
	//echo $data;
	exit();
}
if( $action == "getaddons" )
{
	$activeaddonmodules = $CONFIG['ActiveAddonModules'];
	$data = array( "active" => explode( ",", $activeaddonmodules ) );
	if( is_dir( ROOTDIR."/modules/addons/" ) )
	{
		$dh = opendir( ROOTDIR."/modules/addons/" );
		while ( false !== ( $file = readdir( $dh ) ) )
		{
			$modfilename = ROOTDIR."/modules/addons/{$file}/{$file}.php";
			if( is_file( $modfilename ) )
			{
				$data['installed'][] = $file;
			}
		}
	}
	//$data = curlCall( "http://www.whmcs.com/members/communityaddonsfeed.php", "action=getaddons&catid=".$catid."&search=".$search."&modules=".json_encode( $data ) );
	//echo $data;
	exit();
}
global $jquerycode;
global $jscode;
$jquerycode = $jscode = "";
ob_start();
if( !$module )
{
	$aInt->title = $aInt->lang( "utilities", "addonsdirectory" );
	echo "\r\n<div id=\"searchaddons\"><form onsubmit=\"search();return false\"><input type=\"text\" id=\"searchterm\" /> <input type=\"submit\" value=\"Search\" /></form></div>\r\n<div id=\"addonscats\"></div>\r\n<div id=\"addonslist\">\r\n<div class=\"loading\">";
	echo $aInt->lang( "global", "loading" );
	echo "<br /><img src=\"../images/loading.gif\" /></div>\r\n</div>\r\n<div style=\"clear:both;\"></div>\r\n\r\n<p style=\"font-size:10px;\">* Please note that any addon modules listed above outside of the \"Official Addon's\" directory are third party modules that WHMCS is in no way affiliated with or endorsing by listing them in the addons directory. We are unable to provide support for, and cannot be held responsible for any";
	echo " problems resulting from the use of third party addons.</p>\r\n\r\n";
	$jscode = "function loadcats() {\r\n	\$.post(\"addonmodules.php\", { action: \"getcats\" },\r\n\t	function(data){\r\n\t\t	\$(\"#addonscats\").html(data);\r\n\t\t});\r\n}\r\nfunction loadaddons(id) {\r\n	\$(\".cat\").removeClass(\"addonsel\");\r\n	\$(\"#cat\"+id).addClass(\"addonsel\")\r\n	\$(\"#addonslist\").html('<div class=\"loading\">".$aInt->lang( "global", "loading", 1 )."<br /><img src=\"../images/loading.gif\" /></div>');\r\n	\$.post(\"addonmodules.php\", { action: \"getaddons\", catid: id },\r\n\t	function(data){\r\n\t\t	\$(\"#addonslist\").html(data);\r\n\t\t});\r\n}\r\nfunction search() {\r\n	\$(\".cat\").removeClass(\"addonsel\");\r\n	\$(\"#cat\").addClass(\"addonsel\")\r\n	\$(\"#addonslist\").html('<div class=\"loading\">".$aInt->lang( "global", "loading", 1 )."<br /><img src=\"../images/loading.gif\" /></div>');\r\n	\$.post(\"addonmodules.php\", { action: \"getaddons\", search: \$(\"#searchterm\").val() },\r\n\t	function(data){\r\n\t\t	\$(\"#addonslist\").html(data);\r\n\t\t});\r\n}";
	$jquerycode = "loadcats();loadaddons(\"\");";
}
else
{
	$modulelink = "addonmodules.php?module={$module}";
	$result = select_query( "tbladdonmodules", "value", array(
		"module" => $module,
		"setting" => "access"
	) );
	$data = mysql_fetch_array( $result );
	$allowedroles = explode( ",", $data[0] );
	$result = select_query( "tbladmins", "roleid", array(
		"id" => $_SESSION['adminid']
	) );
	$data = mysql_fetch_array( $result );
	$adminroleid = $data[0];
	$modulepath = ROOTDIR."/modules/addons/{$module}/{$module}.php";
	if( file_exists( $modulepath ) )
	{
		require( $modulepath );
		if( function_exists( $module."_config" ) )
		{
			$configarray = call_user_func( $module."_config" );
			$aInt->title = $configarray['name'];
			if( in_array( $adminroleid, $allowedroles ) )
			{
				$modulevars = array(
					"modulelink" => $modulelink
				);
				$result = select_query( "tbladdonmodules", "", array(
					"module" => $module
				) );
				while ( $data = mysql_fetch_array( $result ) )
				{
					$modulevars[$data['setting']] = $data['value'];
				}
				$_ADDONLANG = array();
				$addonlangfile = ROOTDIR."/modules/addons/{$module}/lang/".$aInt->language.".php";
				if( file_exists( $addonlangfile ) )
				{
					require( $addonlangfile );
				}
				else if( $configarray['language'] )
				{
					$addonlangfile = ROOTDIR."/modules/addons/{$module}/lang/".$configarray['language'].".php";
					if( file_exists( $addonlangfile ) )
					{
						require( $addonlangfile );
					}
				}
				if( count( $_ADDONLANG ) )
				{
					$modulevars['_lang'] = $_ADDONLANG;
				}
				if( $modulevars['version'] != $configarray['version'] )
				{
					if( function_exists( $module."_upgrade" ) )
					{
						call_user_func( $module."_upgrade", $modulevars );
					}
					update_query( "tbladdonmodules", array(
						"value" => $configarray['version']
					), array(
						"module" => $module,
						"setting" => "version"
					) );
				}
				$sidebar = "";
				if( function_exists( $module."_sidebar" ) )
				{
					$sidebar = call_user_func( $module."_sidebar", $modulevars );
				}
				$aInt->assign( "addon_module_sidebar", $sidebar );
				if( $aInt->adminTemplate == "blend" && $sidebar )
				{
					echo "<div style=\"float:right;margin:0 20px 0 0;width:200px;border:1px solid #ccc;background-color:#efefef;padding:10px;\">".$sidebar."</div>";
				}
				if( function_exists( $module."_output" ) )
				{
					call_user_func( $module."_output", $modulevars );
				}
				else
				{
					echo "<p>".$aInt->lang( "addonmodules", "nooutput" )."</p>";
				}
			}
			else
			{
				echo "<br /><br />\r\n<p align=\"center\"><b>".$aInt->lang( "permissions", "accessdenied" )."</b></p>\r\n<p align=\"center\">".$aInt->lang( "addonmodules", "noaccess" )."</p>\r\n<p align=\"center\">".$aInt->lang( "addonmodules", "howtogrant" )."</p>";
			}
		}
		else
		{
			echo "<p>".$aInt->lang( "addonmodules", "error" )."</p>";
		}
	}
	else
	{
		$pagetitle = str_replace( "_", " ", $module );
		$pagetitle = titleCase( $pagetitle );
		echo "<h2>{$pagetitle}</h2>";
		if( in_array( $adminroleid, $allowedroles ) )
		{
			$modulepath = ROOTDIR."/modules/admin/{$module}/{$module}.php";
			if( file_exists( $modulepath ) )
			{
				require( $modulepath );
			}
			else
			{
				echo "<p>".$aInt->lang( "addonmodules", "nooutput" )."</p>";
			}
		}
		else
		{
			echo "<br /><br />\r\n<p align=\"center\"><b>".$aInt->lang( "permissions", "accessdenied" )."</b></p>\r\n<p align=\"center\">".$aInt->lang( "addonmodules", "noaccess" )."</p>\r\n<p align=\"center\">".$aInt->lang( "addonmodules", "howtogrant" )."</p>";
		}
	}
}
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->jquerycode = $jquerycode;
$aInt->jscode = $jscode;
$aInt->display();
?>