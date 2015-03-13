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
function initialiseClientArea( $pagetitle, $pageicon, $breadcrumbnav )
{
	global $CONFIG;
	global $_LANG;
	global $templates_compiledir;
	global $in_ssl;
	global $clientsdetails;
	global $smarty;
	global $smartyvalues;
	include_once( ROOTDIR."/includes/smarty/Smarty.class.php" );
	$smarty = new Smarty();
	$smarty->caching = 0;
	$smarty->template_dir = ROOTDIR."/templates/";
	$smarty->compile_dir = $templates_compiledir;
	$filename = $_SERVER['PHP_SELF'];
	$filename = substr( $filename, strrpos( $filename, "/" ) );
	$filename = str_replace( "/", "", $filename );
	$filename = explode( ".", $filename );
	$filename = $filename[0];
	$smarty->assign( "template", $CONFIG['Template'] );
	$smarty->assign( "language", $CONFIG['Language'] );
	$smarty->assign( "LANG", $_LANG );
	$smarty->assign( "companyname", $CONFIG['CompanyName'] );
	$smarty->assign( "charset", $CONFIG['Charset'] );
	$smarty->assign( "pagetitle", $pagetitle );
	$smarty->assign( "pageicon", $pageicon );
	$smarty->assign( "filename", $filename );
	$smarty->assign( "breadcrumbnav", $breadcrumbnav );
	$smarty->assign( "todaysdate", date( "l, jS F Y" ) );
	$smarty->assign( "date_day", date( "d" ) );
	$smarty->assign( "date_month", date( "m" ) );
	$smarty->assign( "date_year", date( "Y" ) );
	if( $CONFIG['SystemSSLURL'] )
	{
		$smarty->assign( "systemsslurl", $CONFIG['SystemSSLURL']."/" );
	}
	if( $in_ssl && $CONFIG['SystemSSLURL'] )
	{
		$smarty->assign( "systemurl", $CONFIG['SystemSSLURL']."/" );
	}
	else if( $CONFIG['SystemURL'] != "http://www.yourdomain.com/whmcs" )
	{
		$smarty->assign( "systemurl", $CONFIG['SystemURL']."/" );
	}
	if( $_SESSION['uid'] )
	{
		$smarty->assign( "loggedin", true );
		if( !function_exists( "getClientsDetails" ) )
		{
			require( ROOTDIR."/includes/clientfunctions.php" );
		}
		$clientsdetails = getClientsDetails();
		$smarty->assign( "clientsdetails", $clientsdetails );
		$smarty->assign( "clientsstats", getClientsStats( $_SESSION['uid'] ) );
		if( $_SESSION['cid'] )
		{
			$result = select_query( "tblcontacts", "id,firstname,lastname,email,permissions", array(
				"id" => $_SESSION['cid'],
				"userid" => $_SESSION['uid']
			) );
			$data = mysql_fetch_array( $result );
			$loggedinuser = array(
				"contactid" => $data['id'],
				"firstname" => $data['firstname'],
				"lastname" => $data['lastname'],
				"email" => $data['email']
			);
			$contactpermissions = explode( ",", $data[4] );
		}
		else
		{
			$loggedinuser = array(
				"userid" => $_SESSION['uid'],
				"firstname" => $clientsdetails['firstname'],
				"lastname" => $clientsdetails['lastname'],
				"email" => $clientsdetails['email']
			);
			$contactpermissions = array( "profile", "contacts", "products", "manageproducts", "domains", "managedomains", "invoices", "tickets", "affiliates", "emails", "orders" );
		}
		$smarty->assign( "loggedinuser", $loggedinuser );
		$smarty->assign( "contactpermissions", $contactpermissions );
	}
	if( $CONFIG['AllowLanguageChange'] == "on" )
	{
		$smarty->assign( "langchange", "true" );
	}
	$setlanguage = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF'];
	$count = 0;
	foreach( $_GET as $k => $v )
	{
		$prefix = $count == 0 ? "?" : "&";
		$setlanguage .= $prefix.htmlentities( $k )."=".htmlentities( $v );
		++$count;
	}
	$setlanguage .= "\" name=\"languagefrm\" id=\"languagefrm\"><strong>".$_LANG['language'].":</strong> <select name=\"language\" onchange=\"languagefrm.submit()\">";
	foreach( getValidLanguages() as $lang )
	{
		$setlanguage .= "<option";
		if( isset( $_SESSION['Language'] ) && strtolower( $_SESSION['Language'] ) == $lang || !isset( $_SESSION['Language'] ) && $lang == strtolower( $CONFIG['Language'] ) )
		{
			$setlanguage .= " selected=\"selected\"";
		}
		$setlanguage .= ">".ucfirst( $lang )."</option>";
	}
	$setlanguage .= "</select></form>";
	$smarty->assign( "setlanguage", $setlanguage );
	$currenciesarray = array();
	$result = select_query( "tblcurrencies", "id,code", "", "code", "ASC" );
	while ( $data = mysql_fetch_array( $result ) )
	{
		$currenciesarray[] = array(
			"id" => $data['id'],
			"code" => $data['code']
		);
	}
	if( count( $currenciesarray ) == 1 )
	{
		$currenciesarray = "";
	}
	$smarty->assign( "currencies", $currenciesarray );
	$smarty->assign( "twitterusername", $CONFIG['TwitterUsername'] );
	$calinkupdatecc = isset( $_SESSION['calinkupdatecc'] ) ? $_SESSION['calinkupdatecc'] : CALinkUpdateCC();
	$calinkupdatesq = isset( $_SESSION['calinkupdatesq'] ) ? $_SESSION['calinkupdatesq'] : CALinkUpdateSQ();
	$smarty->assign( "condlinks", array(
		"updatecc" => $calinkupdatecc,
		"updatesq" => $calinkupdatesq,
		"addfunds" => $CONFIG['AddFundsEnabled'],
		"masspay" => $CONFIG['EnableMassPay']
	) );
	$smartyvalues = array();
}

function outputClientArea( $templatefile, $nowrapper = false )
{
	global $CONFIG;
	global $smarty;
	global $smartyvalues;
	global $orderform;
	global $usingsupportmodule;
	global $licensing;
	global $customadminpath;
	if( !$templatefile )
	{
		exit( "Invalid Entity Requested" );
	}
	if( $licensing->getBrandingRemoval() )
	{
		$copyrighttext = "";
	}
	else
	{
		$copyrighttext = "<p align=\"center\">Powered by <a href=\"http://dereferer.ws/?http://www.whmcs.com/\" target=\"_blank\">WHMCompleteSolution</a></p>";
	}
	if( $_SESSION['adminid'] )
	{
		$adminloginlink = "<div style=\"position:absolute;top:0px;right:0px;padding:5px;background-color:#000066;font-family:Tahoma;font-size:11px;color:#ffffff\" class=\"adminreturndiv\">Logged in as Administrator | <a href=\"".$customadminpath."/";
		if( $_SESSION['uid'] )
		{
			$adminloginlink .= "clientssummary.php?userid=".$_SESSION['uid']."&return=1";
		}
		$adminloginlink .= "\" style=\"color:#6699ff\">Return to Admin Area</a></div>\r\n\r\n";
	}
	else
	{
		$adminloginlink = "";
	}
	if( isset( $GLOBALS['pagelimit'] ) )
	{
		$smartyvalues['itemlimit'] = $GLOBALS['pagelimit'];
	}
	if( $smartyvalues )
	{
		foreach( $smartyvalues as $key => $value )
		{
			$smarty->assign( $key, $value );
		}
	}
	$hookvars = $smarty->_tpl_vars;
	unset( $hookvars['LANG'] );
	$hookres = run_hook( "ClientAreaPage", $hookvars );
	foreach( $hookres as $arr )
	{
		foreach( $arr as $k => $v )
		{
			$hookvars[$k] = $v;
			$smarty->assign( $k, $v );
		}
	}
	$hookres = run_hook( "ClientAreaHeadOutput", $hookvars );
	$headoutput = "";
	foreach( $hookres as $data )
	{
		if( $data )
		{
			$headoutput .= $data."\n";
		}
	}
	$smarty->assign( "headoutput", $headoutput );
	$hookres = run_hook( "ClientAreaHeaderOutput", $hookvars );
	$headoutput = "";
	foreach( $hookres as $data )
	{
		if( $data )
		{
			$headoutput .= $data."\n";
		}
	}
	$smarty->assign( "headeroutput", $headoutput );
	$hookres = run_hook( "ClientAreaFooterOutput", $hookvars );
	$headoutput = "";
	foreach( $hookres as $data )
	{
		if( $data )
		{
			$headoutput .= $data."\n";
		}
	}
	$smarty->assign( "footeroutput", $headoutput );
	if( !$nowrapper )
	{
		$header_file = $smarty->fetch( $CONFIG['Template']."/header.tpl" );
		$footer_file = $smarty->fetch( $CONFIG['Template']."/footer.tpl" );
	}
	if( $orderform )
	{
		$body_file = $smarty->fetch( ROOTDIR."/templates/orderforms/".$CONFIG['OrderFormTemplate']."/".$templatefile.".tpl" );
	}
	else if( $usingsupportmodule )
	{
		$body_file = $smarty->fetch( ROOTDIR."/templates/".$CONFIG['SupportModule']."/".$templatefile.".tpl" );
	}
	else if( substr( $templatefile, 0, 1 ) == "/" )
	{
		$body_file = $smarty->fetch( ROOTDIR.$templatefile );
	}
	else
	{
		$body_file = $smarty->fetch( ROOTDIR."/templates/".$CONFIG['Template']."/".$templatefile.".tpl" );
	}
	if( $nowrapper )
	{
		$template_output = $body_file;
	}
	else
	{
		$template_output = $header_file.$body_file."\n\n".$copyrighttext."\n\n".$adminloginlink.$footer_file;
	}
	echo $template_output;
}

function processSingleTemplate( $templatepath, $templatevars )
{
	global $CONFIG;
	global $smarty;
	global $smartyvalues;
	if( $smartyvalues )
	{
		foreach( $smartyvalues as $key => $value )
		{
			$smarty->assign( $key, $value );
		}
	}
	foreach( $templatevars as $key => $value )
	{
		$smarty->assign( $key, $value );
	}
	$templatecode = $smarty->fetch( ROOTDIR.$templatepath );
	return $templatecode;
}

function CALinkUpdateCC()
{
	global $CONFIG;
	$result = select_query( "tblpaymentgateways", "gateway", array( "setting" => "type", "value" => "CC" ) );
	while ( $data = mysql_fetch_array( $result ) )
	{
		$gateway = $data['gateway'];
		if( file_exists( ROOTDIR."/modules/gateways/{$gateway}.php" ) )
		{
			require_once( ROOTDIR."/modules/gateways/{$gateway}.php" );
		}
		if( !function_exists( $gateway."_remoteupdate" ) )
		{
			continue;
		}
		$_SESSION['calinkupdatecc'] = 1;
		return true;
	}
	if( !$CONFIG['CCNeverStore'] )
	{
		$result = select_query( "tblpaymentgateways", "COUNT(*)", "setting='type' AND (value='CC' OR value='OfflineCC')" );
		$data = mysql_fetch_array( $result );
		if( $data[0] )
		{
			$_SESSION['calinkupdatecc'] = 1;
			return true;
		}
	}
	$_SESSION['calinkupdatecc'] = 0;
	return false;
}

function CALinkUpdateSQ()
{
	$get_sq_count = get_query_val( "tbladminsecurityquestions", "COUNT(id)", "" );
	if( 0 < $get_sq_count )
	{
		$_SESSION['calinkupdatesq'] = 1;
		return true;
	}
	$_SESSION['calinkupdatesq'] = 0;
	return false;
}

function clientAreaTableInit( $name, $defaultorderby, $defaultsort, $numitems )
{
	$pagelimit = "";
	if( $_REQUEST['itemlimit'] == "all" )
	{
		$pagelimit = 99999999;
	}
	else if( is_numeric( $_REQUEST['itemlimit'] ) )
	{
		$pagelimit = $_REQUEST['itemlimit'];
	}
	if( $pagelimit )
	{
		setcookie( "pagelimit", $pagelimit, time() + 90 * 24 * 60 * 60 );
	}
	if( !$pagelimit && isset( $_COOKIE['pagelimit'] ) && is_numeric( $_COOKIE['pagelimit'] ) )
	{
		$pagelimit = $_COOKIE['pagelimit'];
	}
	if( !$pagelimit )
	{
		$pagelimit = "10";
	}
	$GLOBALS['pagelimit'] = $pagelimit;
	if( isset( $_REQUEST['page'] ) )
	{
		$page = (int)$_REQUEST['page'];
	}
	if( !$page )
	{
		$page = 1;
	}
	if( $numitems < ( $page - 1 ) * $pagelimit )
	{
		$page = 1;
	}
	$GLOBALS['page'] = $page;
	if( !$_SESSION["ca".$name."orderby"] )
	{
		$_SESSION["ca".$name."orderby"] = $defaultorderby;
	}
	if( !$_SESSION["ca".$name."sort"] )
	{
		$_SESSION["ca".$name."sort"] = $defaultsort;
	}
	if( $_SESSION["ca".$name."orderby"] == $_REQUEST['orderby'] )
	{
		if( $_SESSION["ca".$name."sort"] == "ASC" )
		{
			$_SESSION["ca".$name."sort"] = "DESC";
		}
		else
		{
			$_SESSION["ca".$name."sort"] = "ASC";
		}
	}
	if( $_REQUEST['orderby'] )
	{
		$_SESSION["ca".$name."orderby"] = $_REQUEST['orderby'];
	}
	$orderby = preg_replace( "/[^a-z0-9]/", "", $_SESSION["ca".$name."orderby"] );
	$sort = $_SESSION["ca".$name."sort"];
	if( !in_array( $sort, array( "ASC", "DESC" ) ) )
	{
		$sort = "ASC";
	}
	$limit = ( ( $page - 1 ) * $pagelimit ).",{$pagelimit}";
	return array( $orderby, $sort, $limit );
}

function clientAreaTablePageNav( $numitems )
{
	$totalpages = ceil( $numitems / (int)$GLOBALS['pagelimit'] );
	$pagenumber = (int)$GLOBALS['page'];
	if( $pagenumber != 1 )
	{
		$prevpage = $pagenumber - 1;
	}
	if( $pagenumber != $totalpages && $numitems )
	{
		$nextpage = $pagenumber + 1;
	}
	if( !$totalpages )
	{
		$totalpages = 1;
	}
	return array(
		"numitems" => $numitems,
		"numproducts" => $numitems,
		"pagenumber" => $pagenumber,
		"totalpages" => $totalpages,
		"prevpage" => $prevpage,
		"nextpage" => $nextpage
	);
}

function clientAreaInitCaptcha()
{
	global $CONFIG;
	$capatacha = "";
	if( $CONFIG['CaptchaSetting'] == "on" || $CONFIG['CaptchaSetting'] == "offloggedin" && !$_SESSION['uid'] )
	{
		if( $CONFIG['CaptchaType'] == "recaptcha" )
		{
			require( ROOTDIR."/includes/recaptchalib.php" );
			$capatacha = "recaptcha";
		}
		else
		{
			$capatacha = "default";
		}
	}
	$GLOBALS['capatacha'] = $capatacha;
	return $capatacha;
}

function clientAreaValidateCaptcha()
{
	global $CONFIG;
	global $_LANG;
	global $remote_ip;
	if( $GLOBALS['capatacha'] == "recaptcha" )
	{
		$privatekey = $CONFIG['ReCAPTCHAPrivateKey'];
		$resp = recaptcha_check_answer( $privatekey, $remote_ip, $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'] );
		if( !is_object( $resp ) )
		{
			return "<li>".$resp;
		}
		if( !$resp->is_valid )
		{
			return $_LANG["recaptcha-".$resp->error] ? "<li>".$_LANG["recaptcha-".$resp->error] : "<li>".$resp->error;
		}
	}
	else if( $GLOBALS['capatacha'] == "default" && $_SESSION['image_random_value'] != md5( strtoupper( $_POST['code'] ) ) )
	{
		return "<li>".$_LANG['captchaverifyincorrect'];
	}
}

function clientAreaReCaptchaHTML()
{
	global $CONFIG;
	if( $GLOBALS['capatacha'] != "recaptcha" )
	{
		return "";
	}
	$publickey = $CONFIG['ReCAPTCHAPublicKey'];
	$recapatcha = recaptcha_get_html( $publickey );
	return $recapatcha;
}

?>