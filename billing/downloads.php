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
function dlGetCatIds( $catid )
{
	global $idnumbers;
	$result = select_query( "tbldownloadcats", "id", array(
		"parentid" => $catid,
		"hidden" => ""
	) );
	while ( $data = mysql_fetch_array( $result ) )
	{
		$cid = $data[0];
		$idnumbers[] = $cid;
		dlGetCatIds( $cid );
	}
}

function formatFileSize( $val, $digits = 3 )
{
	$factor = 1024;
	$symbols = array( "", "k", "M", "G", "T", "P", "E", "Z", "Y" );
	$i = 0;
	while ( $i < count( $symbols ) - 1 && $factor <= $val )
	{
		$val /= $factor;
		++$i;
	}
	$p = strpos( $val, "." );
	if( $p !== false && $digits < $p )
	{
		$val = round( $val );
	}
	else if( $p !== false )
	{
		$val = round( $val, $digits - $p );
	}
	return round( $val, $digits )." ".$symbols[$i]."B";
}

function createDownloadsArray( $result )
{
	global $CONFIG;
	global $downloads_dir;
	$downloads = array();
	while ( $data = mysql_fetch_array( $result ) )
	{
		$id = $data['id'];
		$category = $data['category'];
		$type = $data['type'];
		$ttitle = $data['title'];
		$description = $data['description'];
		$filename = $data['location'];
		$numdownloads = $data['downloads'];
		$clientsonly = $data['clientsonly'];
		$filesize = @filesize( $downloads_dir.$filename );
		$filesize = formatfilesize( $filesize );
		$fileext = end( explode( ".", $filename ) );
		if( $fileext == "doc" )
		{
			$type = "doc";
		}
		if( $fileext == "gif" || $fileext == "jpg" || $fileext == "jpeg" || $fileext == "png" )
		{
			$type = "picture";
		}
		if( $fileext == "txt" )
		{
			$type = "txt";
		}
		if( $fileext == "zip" )
		{
			$type = "zip";
		}
		$type = "<img src=\"images/".$type.".png\" align=\"absmiddle\" alt=\"\" />";
		$downloads[] = array(
			"type" => $type,
			"title" => $ttitle,
			"urlfriendlytitle" => getModRewriteFriendlyString( $ttitle ),
			"description" => $description,
			"downloads" => $numdownloads,
			"filesize" => $filesize,
			"clientsonly" => $clientsonly,
			"link" => $CONFIG['SystemURL']."/dl.php?type=d&amp;id={$id}"
		);
	}
	return $downloads;
}

define( "CLIENTAREA", true );
require( "dbconnect.php" );
require( "includes/functions.php" );
require( "includes/clientareafunctions.php" );
$pagetitle = $_LANG['downloadstitle'];
$breadcrumbnav = "<a href=\"".$CONFIG['SystemURL']."/index.php\">".$_LANG['globalsystemname']."</a> > <a href=\"".$CONFIG['SystemURL']."/downloads.php\">".$_LANG['downloadstitle']."</a>";
$pageicon = "images/downloads_big.gif";
initialiseClientArea( $pagetitle, $pageicon, $breadcrumbnav );
$supportmodulepath = "modules/support/".$CONFIG['SupportModule']."/downloads.php";
if( isset( $catid ) && !is_numeric( $catid ) )
{
	redir();
}
if( isset( $id ) && !is_numeric( $id ) )
{
	redir();
}
$proddlrestrict = !$CONFIG['DownloadsIncludeProductLinked'] ? " AND productdownload=''" : "";
$smartyvalues['seofriendlyurls'] = $CONFIG['SEOFriendlyUrls'];
if( $CONFIG['SupportModule'] && file_exists( $supportmodulepath ) )
{
	$usingsupportmodule = true;
	require( $supportmodulepath );
}
else
{
	if( $action == "displaycat" || $action == "displayarticle" )
	{
		$result = select_query( "tbldownloadcats", "", array(
			"id" => $catid
		) );
		$data = mysql_fetch_array( $result );
		$catid = $data['id'];
		if( !$catid )
		{
			header( "Location: downloads.php" );
			exit();
		}
		$catparentid = $data['parentid'];
		$catname = $data['name'];
		if( $CONFIG['SEOFriendlyUrls'] )
		{
			$catbreadcrumbnav = " > <a href=\"downloads/".$catid."/".getModRewriteFriendlyString( $catname )."\">".$catname."</a>";
		}
		else
		{
			$catbreadcrumbnav = " > <a href=\"downloads.php?action=displaycat&amp;catid=".$catid."\">".$catname."</a>";
		}
		while ( $catparentid != "0" )
		{
			$result = select_query( "tbldownloadcats", "", array(
				"id" => $catparentid
			) );
			$data = mysql_fetch_array( $result );
			$cattempid = $data['id'];
			$catparentid = $data['parentid'];
			$catname = $data['name'];
			if( $CONFIG['SEOFriendlyUrls'] )
			{
				$catbreadcrumbnav = " > <a href=\"downloads/".$cattempid."/".getModRewriteFriendlyString( $catname )."\">".$catname."</a>".$catbreadcrumbnav;
			}
			else
			{
				$catbreadcrumbnav = " > <a href=\"downloads.php?action=displaycat&amp;catid=".$cattempid."\">".$catname."</a>".$catbreadcrumbnav;
			}
		}
		$breadcrumbnav .= $catbreadcrumbnav;
	}
	if( $action == "search" )
	{
		$breadcrumbnav .= " > <a href=\"downloads.php?action=search&amp;search=".$search."\">Search</a>";
	}
	$smarty->assign( "breadcrumbnav", $breadcrumbnav );
	if( $action == "displaycat" )
	{
		$templatefile = "downloadscat";
		$i = 1;
		$result = select_query( "tbldownloadcats", "", array(
			"parentid" => $catid,
			"hidden" => ""
		), "name", "ASC" );
		while ( $data = mysql_fetch_array( $result ) )
		{
			$idkb = $data['id'];
			$dlcats[$i] = array(
				"id" => $idkb,
				"name" => $data['name'],
				"urlfriendlyname" => getModRewriteFriendlyString( $data['name'] ),
				"description" => $data['description']
			);
			$idnumbers = array();
			$idnumbers[] = $idkb;
			dlgetcatids( $idkb );
			$queryreport = "";
			foreach ( $idnumbers as $idnumber )
			{
				$queryreport .= " OR category='{$idnumber}'";
			}
			$queryreport = substr( $queryreport, 4 );
			$dlcats[$i]['numarticles'] = get_query_val( "tbldownloads", "COUNT(*)", "({$queryreport}) AND hidden=''".$proddlrestrict );
			++$i;
		}
		$smarty->assign( "dlcats", $dlcats );
		$result = select_query( "tbldownloads", "", "category={$catid} AND hidden=''".$proddlrestrict, "title", "ASC" );
		$downloads = createdownloadsarray( $result );
		$smarty->assign( "downloads", $downloads );
	}
	else if( $action == "search" )
	{
		if( !trim( $search ) )
		{
			redir();
		}
		$templatefile = "downloadscat";
		$result = select_query( "tbldownloads", "tbldownloads.*", "(title like '%".db_escape_string( $search )."%' OR tbldownloads.description like '%".db_escape_string( $search )."%') AND tbldownloads.hidden='' AND tbldownloadcats.hidden=''".$proddlrestrict, "title", "ASC", "", "tbldownloadcats ON tbldownloadcats.id=tbldownloads.category" );
		$downloads = createdownloadsarray( $result );
		$smarty->assign( "search", $search );
		$smarty->assign( "downloads", $downloads );
	}
	else
	{
		$templatefile = "downloads";
		$i = 1;
		$result = select_query( "tbldownloadcats", "", array( "parentid" => "0", "hidden" => "" ), "name", "ASC" );
		while ( $data = mysql_fetch_array( $result ) )
		{
			$idkb = $data['id'];
			$dlcats[$i] = array(
				"id" => $idkb,
				"name" => $data['name'],
				"urlfriendlyname" => getModRewriteFriendlyString( $data['name'] ),
				"description" => $data['description']
			);
			$idnumbers = array();
			$idnumbers[] = $idkb;
			dlgetcatids( $idkb );
			$queryreport = "";
			foreach ( $idnumbers as $idnumber )
			{
				$queryreport .= " OR category='{$idnumber}'";
			}
			$queryreport = substr( $queryreport, 4 );
			$dlcats[$i]['numarticles'] = get_query_val( "tbldownloads", "COUNT(*)", "({$queryreport}) AND hidden=''".$proddlrestrict );
			++$i;
		}
		$smarty->assign( "dlcats", $dlcats );
		$result = select_query( "tbldownloads", "tbldownloads.*", "tbldownloadcats.hidden='' AND tbldownloads.hidden=''".$proddlrestrict, "downloads", "DESC", "0,5", "tbldownloadcats ON tbldownloadcats.id=tbldownloads.category" );
		$downloads = createdownloadsarray( $result );
		$smarty->assign( "mostdownloads", $downloads );
	}
}
outputClientArea( $templatefile );
?>