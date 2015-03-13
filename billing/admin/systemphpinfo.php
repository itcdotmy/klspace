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
$aInt = new adminInterface( "View PHP Info" );
$aInt->title = $aInt->lang( "system", "phpinfo" );
$aInt->sidebar = "utilities";
$aInt->icon = "phpinfo";
ob_start();
phpinfo();
$info = ob_get_contents();
ob_end_clean();
$info = preg_replace( "%^.*<body>(.*)</body>.*\$%ms", "\$1", $info );
ob_start();
echo "<style type=\"text/css\">\r\n.e {background-color: #EFF2F9; font-weight: bold; color: #000000;}\r\n.v {background-color: #efefef; color: #000000;}\r\n.vr {background-color: #efefef; text-align: right; color: #000000;}\r\nhr {width: 600px; background-color: #cccccc; border: 0px; height: 1px; color: #000000;}\r\n</style>\r\n";
echo $info;
$content = ob_get_contents();
ob_end_clean();
$aInt->content = $content;
$aInt->display();
?>