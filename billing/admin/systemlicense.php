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
$aInt = new adminInterface( "Main Homepage" );
$aInt->title = $aInt->lang( "license", "title" );
$aInt->sidebar = "help";
$aInt->icon = "support";
ob_start();
echo "\r\n<table class=\"form\" width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"3\">\r\n<tr><td width=\"20%\" class=\"fieldlabel\">";
echo $aInt->lang( "license", "regto" );
echo "</td><td class=\"fieldarea\">";
echo $licensing->keydata['registeredname'];
echo "</td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "license", "key" );
echo "</td><td class=\"fieldarea\">";
echo $license;
echo "</td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "license", "type" );
echo "</td><td class=\"fieldarea\">";
echo $licensing->keydata['productname'];
echo "</td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "license", "validdomain" );
echo "</td><td class=\"fieldarea\">";
echo $licensing->keydata['validdomain'];
echo "</td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "license", "validip" );
echo "</td><td class=\"fieldarea\">";
echo $licensing->keydata['validip'];
echo "</td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "license", "validdir" );
echo "</td><td class=\"fieldarea\">";
echo $licensing->keydata['validdirectory'];
echo "</td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "license", "brandingremoval" );
echo "</td><td class=\"fieldarea\">";
echo $licensing->keydata['configoptions']['Branding Removal'];
echo "</td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "license", "created" );
echo "</td><td class=\"fieldarea\">";
echo $licensing->keydata['regdate'];
echo "</td></tr>\r\n<tr><td class=\"fieldlabel\">";
echo $aInt->lang( "license", "expires" );
echo "</td><td class=\"fieldarea\">";
echo $licensing->keydata['nextduedate'];
echo "</td></tr>\r\n</table>\r\n\r\n<p>";
/*
echo $aInt->lang( "license", "reissue1" );
echo " <a href=\"http://wiki.whmcs.com/Licensing\">http://wiki.whmcs.com/Licensing</a> ";
echo $aInt->lang( "license", "reissue2" );
*/
echo "</p>\r\n\r\n";
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();
?>