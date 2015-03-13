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
require( "includes/whoisfunctions.php" );
if( !is_array( $_SESSION['domaincheckerwhois'] ) || !in_array( $domain, $_SESSION['domaincheckerwhois'] ) )
{
	exit( "You must use the domain checker to get here" );
}
include( "includes/smarty/Smarty.class.php" );
$smarty = new Smarty();
$smarty->template_dir = "templates/".$CONFIG['Template']."/";
$smarty->compile_dir = $templates_compiledir;
$smarty->assign( "template", $CONFIG['Template'] );
$smarty->assign( "LANG", $_LANG );
$smarty->assign( "logo", $CONFIG['LogoURL'] );
$smarty->assign( "currency", $CONFIG['Currency'] );
$smarty->assign( "currencysymbol", $CONFIG['CurrencySymbol'] );
$smarty->assign( "companyname", $CONFIG['CompanyName'] );
$smarty->assign( "pagetitle", "WHOIS Results" );
$domainparts = explode( ".", $domain, 2 );
$sld = $domainparts[0];
$tld = ".".$domainparts[1];
$result = lookupDomain( $sld, $tld );
$smarty->assign( "domain", $domain );
$smarty->assign( "whois", $result['whois'] );
$template_output = $smarty->fetch( "whois.tpl" );
echo $template_output;
?>