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
$aInt = new adminInterface( "View Integration Code" );
$aInt->title = $aInt->lang( "system", "integrationcode" );
$aInt->sidebar = "utilities";
$aInt->icon = "integrationcode";
$aInt->requiredFiles( array( "domainfunctions" ) );
$currency = getCurrency();
$tlds = getTLDList();
$systemurl = $CONFIG['SystemSSLURL'] ? $CONFIG['SystemSSLURL'] : $CONFIG['SystemURL'];
ob_start();
echo "\r\n<p>";
echo $aInt->lang( "system", "integrationinfo" );
echo "</p>\r\n\r\n<p>";
echo $aInt->lang( "system", "widgetsinfo" );
echo " <a href=\"http://dereferer.ws/?http://docs.whmcs.com/Widgets\" target=\"_blank\">http://docs.whmcs.com/Widgets</a></p>\r\n\r\n<br />\r\n\r\n<h2>";
echo $aInt->lang( "system", "intclientlogin" );
echo "</h2>\r\n<p>";
echo $aInt->lang( "system", "intclientlogininfo" );
echo "</p>\r\n<textarea rows=\"6\" style=\"width:100%;\"><form method=\"post\" action=\"";
echo $systemurl;
echo "/dologin.php\">\r\nEmail Address: <input type=\"text\" name=\"username\" size=\"50\" /><br />\r\nPassword: <input type=\"password\" name=\"password\" size=\"20\" /><br />\r\n<input type=\"submit\" value=\"Login\" />\r\n</form></textarea>\r\n<br /><br />\r\n\r\n<h2>";
echo $aInt->lang( "system", "intdalookup" );
echo "</h2>\r\n<p>";
echo $aInt->lang( "system", "intdalookupinfo" );
echo "</p>\r\n<textarea rows=\"10\" style=\"width:100%;\"><form action=\"";
echo $systemurl;
echo "/domainchecker.php\" method=\"post\">\r\n<input type=\"hidden\" name=\"direct\" value=\"true\" />\r\nDomain: <input type=\"text\" name=\"domain\" size=\"20\" /> ";
echo "<select name=\"ext\">\r\n";
foreach ( $tlds as $tld )
{
	echo "<option>{$tld}</option>\n";
}
echo "</select>\r\n<input type=\"submit\" value=\"Go\" />\r\n</form>\r\n</textarea>\r\n<br /><br />\r\n\r\n<h2>";
echo $aInt->lang( "system", "intdo" );
echo "</h2>\r\n<p>";
echo $aInt->lang( "system", "intdoinfo" );
echo "</p>\r\n<textarea rows=\"10\" style=\"width:100%;\"><form action=\"";
echo $systemurl;
echo "/cart.php?a=add&domain=register\" method=\"post\">\r\nDomain: <input type=\"text\" name=\"sld\" size=\"20\" /> ";
echo "<select name=\"tld\">\r\n";
foreach ( $tlds as $tld )
{
	echo "<option>{$tld}</option>\n";
}
echo "</select>\r\n<input type=\"submit\" value=\"Go\" />\r\n</form>\r\n</textarea>\r\n<br /><br />\r\n\r\n<h2>";
echo $aInt->lang( "system", "intuserreg" );
echo "</h2>\r\n<p>";
echo $aInt->lang( "system", "intuserreginfo" );
echo "</p>\r\n<textarea rows=\"2\" style=\"width:100%;\"><a href=\"";
echo $systemurl;
echo "/register.php\">Click here to register with us</a></textarea>\r\n\r\n";
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();
?>