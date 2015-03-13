<?php

function widget_supporttickets_overview($vars) {
    global $_ADMINLANG;

    $title = "Support Tickets Overview";

    if ($_POST['getsupportticketsoverview']) {

        if (!function_exists("getShortLastReplyTime")) require(ROOTDIR.'/includes/ticketfunctions.php');

        $result = select_query("tbladmins","supportdepts",array("id"=>$_SESSION['adminid']));
        $data = mysql_fetch_array($result);
        $admin_supportdepts = $data["supportdepts"];
        $admin_supportdepts_qry = array();
        $admin_supportdepts = explode(',',$admin_supportdepts);
        foreach ($admin_supportdepts AS $deptid) if (trim($deptid)) $admin_supportdepts_qry[] = (int)$deptid;

        $allactive=$awaitingreply=0;
        $ticketcounts = array();
        $result = select_query("tbltickets","COUNT(*)","status!='Closed' AND flag='".(int)$_SESSION["adminid"]."'");
    	$data = mysql_fetch_array($result);
        $ticketcounts[] = array("id"=>"flagged","title"=>"My Flagged","count"=>$data[0]);
        $query = "SELECT tblticketstatuses.id,tblticketstatuses.title,(SELECT COUNT(*) FROM tbltickets WHERE did IN (".implode(',',$admin_supportdepts).") AND tbltickets.status=tblticketstatuses.title),showactive,showawaiting FROM tblticketstatuses ORDER BY sortorder ASC";
    	$result = mysql_query($query);
    	while ($data = mysql_fetch_array($result)) {
    	    $ticketcounts[] = array("id"=>$data[0],"title"=>$data[1],"count"=>$data[2]);
            if ($data['showactive']) $allactive += $data[2];
            if ($data['showawaiting']) $awaitingreply += $data[2];
        }
        $ticketcounts = array_reverse($ticketcounts);

        echo '<div class="ticketstatuses">';
        foreach ($ticketcounts AS $vals) echo '<div onclick="loadTickets(\''.$vals['id'].'\')">'.$vals['title'].' ('.$vals['count'].')</div>';
        echo '</div>
<div class="clear"></div>
<div class="ticketsoverviewcontainer">
<table width="100%" bgcolor="#cccccc" cellspacing="1">
<tr bgcolor="#efefef" style="text-align:center;font-weight:bold;"><td width="20"></td><td>'.$_ADMINLANG['fields']['date'].'</td><td>'.$_ADMINLANG['support']['department'].'</td><td>'.$_ADMINLANG['fields']['subject'].'</td><td>'.$_ADMINLANG['support']['lastreply'].'</td></tr>
';
        if (is_numeric($_REQUEST['statusid'])) {
            $status = get_query_val("tblticketstatuses","title",array("id"=>$_REQUEST['statusid']));
            $result = select_query("tbltickets","tbltickets.*,(SELECT name FROM tblticketdepartments WHERE tblticketdepartments.id=tbltickets.did) AS deptname","did IN (".implode(',',$admin_supportdepts).") AND status='".db_escape_string($status)."'","lastreply","DESC");
        } elseif ($_REQUEST['statusid']=="flagged" || !$_REQUEST['statusid']) {
            $result = select_query("tbltickets","tbltickets.*,(SELECT name FROM tblticketdepartments WHERE tblticketdepartments.id=tbltickets.did) AS deptname","flag=".(int)$_SESSION['adminid'],"lastreply","DESC");
            $status = 'flagged';
        }
		$notickets = true;
        while ($data = mysql_fetch_array($result)) {
            $id = $data['id'];
            $date = $data['date'];
            $deptname = $data['deptname'];
            $tid = $data['tid'];
            $title = $data['title'];
            $priority = $data['urgency'];
            $lastreply = $data['lastreply'];
            $lastreply = getShortLastReplyTime($lastreply);
            $title = (strlen($title)>60) ? substr($title,0,60).'...' : $title;
			echo '<tr bgcolor="#ffffff"><td align="center"><img src="images/'.strtolower($priority).'priority.gif" width="16" height="16" alt="'.$priority.'" class="absmiddle" /></td><td align="center">'.fromMySQLDate($date,1).'</td><td align="center">'.$deptname.'</td><td><a href="supporttickets.php?action=viewticket&id='.$id.'">#'.$tid.' - '.$title.'</a></td><td align="center">'.$lastreply.'</td></tr>';
            $notickets = false;
		}
        if ($notickets) echo '<tr bgcolor="#ffffff"><td colspan="5" align="center">'.$_ADMINLANG['global']['norecordsfound'].'</td></tr>';
		echo '</table>
<div class="ticketoverviewlink"><a href="supporttickets.php?view='.$status.'">'.$_ADMINLANG['home']['viewall'].' &raquo;</a></div>
</div>';
		exit;
    }

$content = '
<style>
.ticketstatuses div {
    float: right;
    margin: 0 5px 5px 0;
    padding: 3px 7px;
    background-color:#1A4D80;
    font-size: 11px;
    color:#fff;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    -o-border-radius: 6px;
    border-radius: 6px;
}
.ticketstatuses div:hover {
    background-color:#E5E5E5;
    color:#000;
    cursor: hand;
    cursor: pointer;
}
.ticketsoverviewcontainer {
    max-height:150px;
    overflow:auto;
}
.ticketoverviewlink {
    padding: 8px 10px 4px 0;
    text-align: right;
}
</style>
<div id="ticketsoverviewtable">'.$vars['loading'].'</div>
';

    $jscode = 'function loadTickets(status) {
    $("#ticketsoverviewcontainer").html("'.str_replace('"','\"',$vars['loading']).'");
    jQuery.post("index.php", { getsupportticketsoverview: 1, statusid: status },
	    function(data){
		    jQuery("#ticketsoverviewtable").html(data);
	    });
}';
    $jquerycode = 'loadTickets();';

    return array('title'=>$title,'content'=>$content,'jquerycode'=>$jquerycode,'jscode'=>$jscode);

}

add_hook("AdminHomeWidgets",1,"widget_supporttickets_overview");

?>