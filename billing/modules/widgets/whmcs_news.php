<?php

function widget_whmcs_news($vars) {
    global $_ADMINLANG;

    $title = $_ADMINLANG['home']['whmcsnewsfeed'];

    if ($_POST['getwhmcsnews']) {
        if (!function_exists("ticketAutoHyperlinks")) require(ROOTDIR.'/includes/ticketfunctions.php');
        $twitterposts = curlCall("http://api.twitter.com/1/statuses/user_timeline.xml?screen_name=whmcs","");
        $twitterposts = XMLtoArray($twitterposts);
        $i = 0;
        echo '<div style="float:right;margin:15px 15px 10px 10px;padding:8px 20px;text-align:center;background-color:#efefef;border:1px dashed #ccc;-moz-border-radius: 5px;-webkit-border-radius: 5px;-o-border-radius: 5px;border-radius: 5px;">Follow Us<br /><a href="http://twitter.com/whmcs" target="_blank" style="font-size:16px;">@whmcs</a></div>';
        foreach ($twitterposts['STATUSES'] AS $values) {
            if ($i>5) break;
            $twitterdate = strtotime($values['CREATED_AT']);
            echo '<b>'.date("l, F jS, Y",$twitterdate).'</b><br />'.ticketAutoHyperlinks($values['TEXT']).'<br /><img src="images/spacer.gif" width="1" height="5" /><br />';
            $i++;
        }
        exit;
    }

    $content = '<div id="whmcsnewsfeed">'.$vars['loading'].'</div>';

    $jquerycode = '$.post("index.php", { getwhmcsnews: 1 },
    function(data){
        jQuery("#whmcsnewsfeed").html(data);
    });';

    return array('title'=>$title,'content'=>$content,'jquerycode'=>$jquerycode);

}

add_hook("AdminHomeWidgets",1,"widget_whmcs_news");

?>