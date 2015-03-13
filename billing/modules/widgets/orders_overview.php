<?php

function widget_orders_overview($vars) {
    global $_ADMINLANG;

    $title = $_ADMINLANG['home']['ordersoverview'];

    $content = '<div align="center"><img src="reports.php?displaygraph=graph_monthly_signups&homepage=true"></div>';

    return array('title'=>$title,'content'=>$content);

}

add_hook("AdminHomeWidgets",1,"widget_orders_overview");

?>