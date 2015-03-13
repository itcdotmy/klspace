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
$licensing->forceRemoteCheck();
$aInt = new adminInterface( "Configure General Settings" );
$aInt->title = $aInt->lang( "system", "checkforupdates" );
$aInt->sidebar = "help";
$aInt->icon = "support";

// Nulled begin
ob_start ();
infobox('Update Check', 'This page has been disabled. There is no reason to check for updates using this version.');
echo $infobox;
$content = ob_get_contents ();
ob_end_clean ();
$aInt->content = $content;
$aInt->display ();
exit();
// Nulled end

ob_start();
if( !$licensing->keydata['latestversion'] )
{
	infoBox( $aInt->lang( "system", "updatecheck" ), $aInt->lang( "system", "connectfailed" ), "error" );
	echo $infobox;
}
else
{
	echo "\r\n<br />\r\n\r\n";
	echo "<style>\r\n.versioncont {\r\n	margin:0 auto;\r\n	padding:0;\r\n	width:480px;\r\n}\r\n.versionyour {\r\n	float:left;\r\n	margin:0;\r\n	padding:10px 20px;\r\n	width:200px;\r\n	background-color:#535353;\r\n	border-bottom:1px solid #fff;\r\n	color: #fff;\r\n	font-size:20px;\r\n	text-align:right;\r\n	-moz-border-radius: 10px 0 0 0;\r\n	-webkit-border-radius: 10px 0 0 0;\r\n	-o-border-radius: 10p";
	echo "x 0 0 0;\r\n	border-radius: 10px 0 0 0;\r\n}\r\n.versionyournum {\r\n	float:left;\r\n	margin:0;\r\n	padding:5px 20px;\r\n	width:200px;\r\n	background-color:#666;\r\n	color: #fff;\r\n	font-family:Arial;\r\n	font-size:70px;\r\n	text-align:right;\r\n	-moz-border-radius: 0 0 0 10px;\r\n	-webkit-border-radius: 0 0 0 10px;\r\n	-o-border-radius: 0 0 0 10px;\r\n	border-radius: 0 0 0 10px;\r\n}\r\n.v";
	echo "ersionlatest {\r\n	float:left;\r\n	margin:0;\r\n	padding:10px 20px;\r\n	width:200px;\r\n	background-color:#035485;\r\n	border-bottom:1px solid #fff;\r\n	color: #fff;\r\n	font-size:20px;\r\n	text-align:left;\r\n	-moz-border-radius: 0 10px 0 0;\r\n	-webkit-border-radius: 0 10px 0 0;\r\n	-o-border-radius: 0 10px 0 0;\r\n	border-radius: 0 10px 0 0;\r\n}\r\n.versionlatestnum {\r\n	float:left;";
	echo "\r\n	margin:0;\r\n	padding:5px 20px;\r\n	width:200px;\r\n	background-color:#0467A2;\r\n	color: #fff;\r\n	font-family:Arial;\r\n	font-size:70px;\r\n	text-align:left;\r\n	-moz-border-radius: 0 0 10px 0;\r\n	-webkit-border-radius: 0 0 10px 0;\r\n	-o-border-radius: 0 0 10px 0;\r\n	border-radius: 0 0 10px 0;\r\n}\r\n.versionnoticecont {\r\n	width:700px;\r\n	margin:30px auto;\r\n}\r\n.newspost {\r\n";
	echo "	margin:10px auto;\r\n	padding:6px 15px;\r\n	width:80%;\r\n	background-color:#f8f8f8;\r\n	border:1px solid #ccc;\r\n	-moz-border-radius: 10px;\r\n	-webkit-border-radius: 10px;\r\n	-o-border-radius: 10px;\r\n	border-radius: 10px;\r\n}\r\n</style>\r\n\r\n<div class=\"versioncont\">\r\n<div class=\"versionyour\">";
	echo $aInt->lang( "system", "yourversion" );
	echo "</div>\r\n<div class=\"versionlatest\">";
	echo $aInt->lang( "system", "latestversion" );
	echo "</div>\r\n<div class=\"versionyournum\">";
	echo $CONFIG['Version'];
	echo "</div>\r\n<div class=\"versionlatestnum\">";
	echo $licensing->keydata['latestversion'];
	echo "</div>\r\n<div style=\"clear:both;\"></div>\r\n</div>\r\n\r\n";
	if( $CONFIG['Version'] != $licensing->keydata['latestversion'] )
	{
		infoBox( $aInt->lang( "system", "updatecheck" ), $aInt->lang( "system", "upgrade" )." <a href=\"https://www.whmcs.com/members/clientarea.php\" target=\"_blank\">".$aInt->lang( "system", "clickhere" )."</a>" );
	}
	else
	{
		infoBox( $aInt->lang( "system", "updatecheck" ), $aInt->lang( "system", "runninglatestversion" ) );
	}
	echo "<div class=\"versionnoticecont\">".$infobox."</div>";
}
$data = curlCall( "http://blog.whmcs.com/rssfeed.php", "" );
$data = XMLtoArray( $data );
$count = 0;
foreach( $data['RSS']['CHANNEL'] as $name => $values )
{
	if( $count < 8 && substr( $name, 0, 4 ) == "ITEM" )
	{
		echo "<div class=\"newspost\"><h2><a href=\"".$values['LINK']."\" target=\"_blank\">".$values['TITLE']."</a></h2><p>".$values['DESCRIPTION']."</p><p><i>Date: ".$values['PUBDATE']."</i></p></div>";
		++$count;
	}
}
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();
?>