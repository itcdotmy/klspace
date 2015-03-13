<?php

function widget_system_overview($vars) {
    global $_ADMINLANG;

    $title = $_ADMINLANG['home']['sysoverview'];

    if ($_POST['getsystemoverview']) {

$result = full_query("SELECT COUNT(*) FROM tblclients WHERE status='Active'");
$data = mysql_fetch_array($result);
$activeclients = $data[0];

$result = full_query("SELECT COUNT(*) FROM tblhosting WHERE domainstatus='Active'");
$data = mysql_fetch_array($result);
$activeservices = $data[0];

$result = full_query("SELECT COUNT(*),SUM(total)-COALESCE(SUM((SELECT SUM(amountin) FROM tblaccounts WHERE tblaccounts.invoiceid=tblinvoices.id)),0) FROM tblinvoices WHERE tblinvoices.status='Unpaid' AND duedate<'" . date("Ymd") . "'");
$data = mysql_fetch_array($result);
$overdueinvoices = $data[0];
$overdueinvoicesbal = $data[1];

$result = full_query("SELECT COUNT(*) FROM tblcancelrequests INNER JOIN tblhosting ON tblhosting.id=tblcancelrequests.relid WHERE (tblhosting.domainstatus!='Cancelled' AND tblhosting.domainstatus!='Terminated')");
$data = mysql_fetch_array($result);
$pendingcancellations = $data[0];

$orders = array();
$orders["today"]["active"]=$orders["today"]["fraud"]=$orders["today"]["pending"]=$orders["today"]["cancelled"]=0;
$query = "SELECT status,COUNT(*) FROM tblorders WHERE date LIKE '".date("Y-m-d")."%' GROUP BY status";
$result = mysql_query($query);
while ($data = mysql_fetch_array($result)) {
    $orders["today"][strtolower($data[0])] = $data[1];
}
$orders["today"]["total"] = $orders["today"]["active"]+$orders["today"]["fraud"]+$orders["today"]["pending"]+$orders["today"]["cancelled"];
$orders["yesterday"]["active"]=$orders["yesterday"]["fraud"]=$orders["yesterday"]["pending"]=$orders["yesterday"]["cancelled"]=0;
$query = "SELECT status,COUNT(*) FROM tblorders WHERE date LIKE '".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")))."%' GROUP BY status";
$result = mysql_query($query);
while ($data = mysql_fetch_array($result)) {
    $orders["yesterday"][strtolower($data[0])] = $data[1];
}
$orders["yesterday"]["total"] = $orders["yesterday"]["active"]+$orders["yesterday"]["fraud"]+$orders["yesterday"]["pending"]+$orders["yesterday"]["cancelled"];

$statusfilter = '';
$result = select_query("tblticketstatuses","title",array("showawaiting"=>"1"));
while ($data = mysql_fetch_array($result)) $statusfilter .= "'".$data[0]."',";
$statusfilter = substr($statusfilter,0,-1);
$result = full_query("SELECT COUNT(*) FROM tbltickets WHERE status IN ($statusfilter)");
$data = mysql_fetch_array($result);
$ticketsawaitingreply = $data[0];

$statusfilter = '';
$result = select_query("tblticketstatuses","title",array("showactive"=>"1"));
while ($data = mysql_fetch_array($result)) $statusfilter .= "'".$data[0]."',";
$statusfilter = substr($statusfilter,0,-1);
$result = full_query("SELECT COUNT(*) FROM tbltickets WHERE status IN ($statusfilter) AND flag='".$vars['adminid']."'");
$data = mysql_fetch_array($result);
$ticketsflagged = $data[0];

$uninvoicedbillableitems = get_query_val("tblbillableitems","COUNT(*)",array("invoicecount"=>"0"));
$validquotes = get_query_val("tblquotes","COUNT(*)",array("validuntil"=>array("sqltype"=>">","value"=>date("Ymd"))));

echo '
<table width="100%">
<tr>
<td class="sysoverviewstat"><div class="sysoverviewbox"><a href="orders.php">'.$orders["today"]["total"].'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['todaysorders'].'</td>
<td class="sysoverviewstat"><div class="sysoverviewbox green"><a href="clients.php?status=Active">'.$activeclients.'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['activeclients'].'</a></td>
</tr>
<tr>
<td class="sysoverviewstat"><div class="sysoverviewbox"><a href="orders.php">'.$orders["yesterday"]["total"].'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['yesterdaysorders'].'</a></td>
<td class="sysoverviewstat"><div class="sysoverviewbox green"><a href="clientshostinglist.php?status=Active">'.$activeservices.'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['activeservices'].'</a></td>
</tr>
<tr>
<td class="sysoverviewstat"><div class="sysoverviewbox gold"><a href="orders.php?status=Pending">'.$orders["today"]["pending"].'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['todayspending'].'</a></td>
<td class="sysoverviewstat"><div class="sysoverviewbox red"><a href="invoices.php?status=Overdue">'.$overdueinvoices.'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['overdueinvoices'].'</a></td>
</tr>
<tr>
<td class="sysoverviewstat"><div class="sysoverviewbox green"><a href="orders.php?status=Active">'.$orders["today"]["active"].'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['todayscompleted'].'</a></td>
<td class="sysoverviewstat"><div class="sysoverviewbox gold"><a href="cancelrequests.php">'.$pendingcancellations.'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['pendingcancellations'].'</a></td>
</tr>
<tr>
<td class="sysoverviewstat"><div class="sysoverviewbox red"><a href="supporttickets.php">'.$ticketsawaitingreply.'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['ticketsawaitingreply'].'</a></td>
<td class="sysoverviewstat"><div class="sysoverviewbox"><a href="quotes.php?validity=Valid">'.$validquotes.'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['validquotes'].'</a></td>
</tr>
<tr>
<td class="sysoverviewstat"><div class="sysoverviewbox"><a href="supporttickets.php?view=flagged">'.$ticketsflagged.'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['activeflagged'].'</a></td>
<td class="sysoverviewstat"><div class="sysoverviewbox"><a href="billableitems.php?status=Uninvoiced">'.$uninvoicedbillableitems.'</a></div></td>
<td class="sysoverviewlabel">'.$_ADMINLANG['stats']['uninvoicedbillableitems'].'</a></td>
</tr>
</table>
';
exit;

    }

    $adminusername = get_query_val("tbladmins","username",array("id"=>$vars['adminid']));
    $lastlogin = get_query_vals("tbladminlog","lastvisit,ipaddress",array("adminusername"=>$adminusername),"lastvisit","DESC","1,1");
    $lastlogindate = ($lastlogin[0]) ? fromMySQLDate($lastlogin[0],true) : '(None Recorded)';
    $lastloginip = ($lastlogin[1]) ? $lastlogin[1] : '-';

    $content = '
<style>
.sysoverviewlabel {
    width: 30%;
    text-align: left;
    color: #444;
}
.sysoverviewstat {
    width: 20%;
}
.sysoverviewbox {
    margin: 0 10px 0 auto;
    padding: 0;
    width: 100px;
    background-color: #fff;
    border: 1px dashed #ccc;
    color: #fff;
    font-size: 1.6em;
    text-align: center;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -o-border-radius: 5px;
    border-radius: 5px;
}
.sysoverviewbox a {
    padding: 2px;
    color: #1A4D80;
    text-decoration: none;
    display: block;
}
.sysoverviewbox.red a {
    color: #cc0000;
}
.sysoverviewbox.gold a {
    color: #D5AA00;
}
.sysoverviewbox.green a {
    color: #61AB3D;
}
.lastlogin {
    margin-top:5px;
    padding:3px;
    background-color:#efefef;
    text-align: center;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;
}
</style>

<div id="systemoverviewstats">'.$vars['loading'].'</div>

<div style="clear:both;"></div>

<div class="lastlogin">'.$_ADMINLANG['home']['lastlogin'].': <b>'.$lastlogindate.'</b> '.$_ADMINLANG['home']['lastloginip'].' <b>'.$lastloginip.'</b></div>

';

    $jquerycode = 'jQuery.post("index.php", { getsystemoverview: 1 },
    function(data){
        jQuery("#systemoverviewstats").html(data);
});';

    return array('title'=>$title,'content'=>$content,'jquerycode'=>$jquerycode);

}

add_hook("AdminHomeWidgets",1,"widget_system_overview");

?>