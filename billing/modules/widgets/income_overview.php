<?php

function widget_income_overview($vars) {
    global $_ADMINLANG;
    
    $title = $_ADMINLANG['home']['incomeoverview'];

    $content = '<div align="center"><img src="reports.php?displaygraph=graph_daily_income&homepage=true"></div>';

    return array('title'=>$title,'content'=>$content);

}

add_hook("AdminHomeWidgets",1,"widget_income_overview");

?>