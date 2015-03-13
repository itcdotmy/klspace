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
if( isset( $_POST['usessl'] ) )
{
	define( "FORCESSL", true );
}
require( "dbconnect.php" );
require( "includes/functions.php" );
require( "includes/clientareafunctions.php" );
require( "includes/ticketfunctions.php" );
$pagetitle = $_LANG['announcementstitle'];
$breadcrumbnav = "<a href=\"index.php\">".$_LANG['globalsystemname']."</a> > <a href=\"announcements.php\">".$_LANG['announcementstitle']."</a>";
$pageicon = "images/announcements_big.gif";
initialiseClientArea( $pagetitle, $pageicon, $breadcrumbnav );
$twitterusername = $CONFIG['TwitterUsername'];
$smartyvalues['twitterusername'] = $CONFIG['TwitterUsername'];
$smartyvalues['twittertweet'] = $CONFIG['AnnouncementsTweet'];
$smartyvalues['facebookrecommend'] = $CONFIG['AnnouncementsFBRecommend'];
$smartyvalues['facebookcomments'] = $CONFIG['AnnouncementsFBComments'];
$smartyvalues['googleplus1'] = $CONFIG['GooglePlus1'];
if( $action == "twitterfeed" )
{
	$twitterposts = curlCall( "http://api.twitter.com/1/statuses/user_timeline.xml?screen_name={$twitterusername}", "" );
	$twitterposts = XMLtoArray( $twitterposts );
	$tweets = array();
	foreach( $twitterposts['STATUSES'] as $values )
	{
		$twitterdate = strtotime( $values['CREATED_AT'] );
		$tweets[] = array(
			"date" => fromMySQLDate( date( "Y-m-d H:i", $twitterdate ), true ),
			"tweet" => ticketAutoHyperlinks( $values['TEXT'] )
		);
	}
	$smartyvalues['tweets'] = $tweets;
	$numtweets = $_POST['numtweets'] ? $_POST['numtweets'] : "3";
	$smartyvalues['numtweets'] = $numtweets;
	echo processSingleTemplate( "/templates/".$CONFIG['Template']."/twitterfeed.tpl" );
	exit();
}
$supportmodulepath = "modules/support/".$CONFIG['SupportModule']."/announcements.php";
$smartyvalues['seofriendlyurls'] = $CONFIG['SEOFriendlyUrls'];
if( $CONFIG['SupportModule'] && file_exists( $supportmodulepath ) )
{
	$usingsupportmodule = true;
	require( $supportmodulepath );
}
else if( !$id )
{
	$pagelimit = 10;
	if( !$page )
	{
		$page = 1;
	}
	$templatefile = "announcements";
	$result = select_query( "tblannouncements", "", array( "published" => "on" ), "date", "DESC", ( ( $page - 1 ) * $pagelimit ).",{$pagelimit}" );
	while( $data = mysql_fetch_array( $result ) )
	{
		$id = $data['id'];
		$date = $data['date'];
		$title = $data['title'];
		$announcement = $data['announcement'];
		$result2 = select_query( "tblannouncements", "", array(
			"parentid" => $id,
			"language" => $_SESSION['Language']
		) );
		$data = mysql_fetch_array( $result2 );
		if( $data['title'] )
		{
			$title = $data['title'];
		}
		if( $data['announcement'] )
		{
			$announcement = $data['announcement'];
		}
		$timestamp = strtotime( $date );
		$date = fromMySQLDate( $date, true );
		$announcements[] = array(
			"id" => $id,
			"date" => $date,
			"timestamp" => $timestamp,
			"title" => $title,
			"urlfriendlytitle" => getModRewriteFriendlyString( $title ),
			"text" => $announcement
		);
	}
	$smarty->assign( "announcements", $announcements );
	$result = select_query( "tblannouncements", "COUNT(*)", array( "published" => "on" ) );
	$data = mysql_fetch_array( $result );
	$numannouncements = $data[0];
	$totalpages = ceil( $numannouncements / $pagelimit );
	if( $page != 1 )
	{
		$prevpage = $page - 1;
	}
	if( $page != $totalpages && $numannouncements )
	{
		$nextpage = $page + 1;
	}
	if( !$totalpages )
	{
		$totalpages = 1;
	}
	$smarty->assign( "numannouncements", $numannouncements );
	$smarty->assign( "pagenumber", $page );
	$smarty->assign( "totalpages", $totalpages );
	$smarty->assign( "prevpage", $prevpage );
	$smarty->assign( "nextpage", $nextpage );
}
else
{
	$templatefile = "viewannouncement";
	$result = select_query( "tblannouncements", "", array(
		"published" => "on",
		"id" => $id
	) );
	$data = mysql_fetch_array( $result );
	$id = $data['id'];
	if( !$id )
	{
		exit( "Invalid Access Attempt" );
	}
	$date = $data['date'];
	$title = $data['title'];
	$announcement = $data['announcement'];
	$timestamp = strtotime( $date );
	$date = fromMySQLDate( $date, true );
	$result2 = select_query( "tblannouncements", "", array(
		"parentid" => $id,
		"language" => $_SESSION['Language']
	) );
	$data = mysql_fetch_array( $result2 );
	if( $data['title'] )
	{
		$title = $data['title'];
	}
	if( $data['announcement'] )
	{
		$announcement = $data['announcement'];
	}
	$breadcrumbnav = "<a href=\"".$CONFIG['SystemURL']."/index.php\">".$_LANG['globalsystemname']."</a> > <a href=\"".$CONFIG['SystemURL']."/announcements.php\">".$_LANG['announcementstitle']."</a> > <a href=\"".$CONFIG['SystemURL']."/";
	$urlfriendlytitle = getModRewriteFriendlyString( $title );
	if( $CONFIG['SEOFriendlyUrls'] )
	{
		$breadcrumbnav .= "announcements/{$id}/{$urlfriendlytitle}.html";
	}
	else
	{
		$breadcrumbnav .= "announcements.php?id={$id}";
	}
	$breadcrumbnav .= "\">{$title}</a>";
	$smarty->assign( "breadcrumbnav", $breadcrumbnav );
	$smarty->assign( "id", $id );
	$smarty->assign( "date", $date );
	$smarty->assign( "timestamp", $timestamp );
	$smarty->assign( "title", $title );
	$smarty->assign( "text", $announcement );
	$smarty->assign( "urlfriendlytitle", $urlfriendlytitle );
}
outputClientArea( $templatefile );
?>