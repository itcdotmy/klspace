<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$description = "This graph shows a breakdown of the income for each month of the year.";

if ($statsonly) { return false; }

if (!checkPermission("View Income Totals",true)) die("Access Denied");

$week = date("W");
$week2 = $week-1;
if ($week2==0) $week2 = '52';

$chartdata = $chartdata2 = array();

for ($i=7;$i>=1;$i--) {
    $timestamp = mktime(0,0,0,date("m"),date("d")-($i-1),date("Y"));
	$query = "SELECT SUM((amountin-amountout)/rate) FROM tblaccounts WHERE date LIKE '".date("Y-m-d",$timestamp)."%'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$totalincome = $data[0];
	if (!$totalincome) $totalincome = 0;
	$chartdata[date("D",$timestamp)] = format_as_currency($totalincome);
}

for ($i=7;$i>=1;$i--) {
    $timestamp = mktime(0,0,0,date("m"),date("d")-7-($i-1),date("Y"));
	$query = "SELECT SUM((amountin-amountout)/rate) FROM tblaccounts WHERE date LIKE '".date("Y-m-d",$timestamp)."%'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$totalincome = $data[0];
	if (!$totalincome) $totalincome = 0;
	$chartdata2[date("D",$timestamp)] = format_as_currency($totalincome);
}

if ($homepage) $graph=new WHMCSGraph(500,250);
else $graph=new WHMCSGraph(780,450);
$graph->addData($chartdata,$chartdata2);
$graph->setTitle("Daily Income Comparison for the Past 2 Weeks");
$graph->setLegendTitle('Week '.$week,'Week '.$week2);
$graph->setBarColor("51,102,204", "220,57,18");
$graph->setDataValues(true);
$graph->setLegend(true);
$graph->setTitleLocation("left");
$graph->setXValuesHorizontal(true);

?>