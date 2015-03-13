<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>WHMCS - {$pagetitle}</title>
<link href="templates/v4/style.css" rel="stylesheet" type="text/css" />
<link href="../includes/jscript/css/ui.all.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jscript/jquery.js"></script>
<script type="text/javascript" src="../includes/jscript/jqueryui.js"></script>
<script type="text/javascript" src="../includes/jscript/adminsearchbox.js"></script>
{literal}<script>
  $(document).ready(function(){
     $("#shownotes").click(function () {
        $("#mynotes").toggle("slow");
        return false;
    });
    $("#savenotes").click(function () {
        $("#mynotes").toggle("slow");
        $.post("index.php", { action: "savenotes", notes: $("#mynotesbox").val() });
    });
    $("#intellisearchval").keyup(function () {
        var intellisearchlength = $("#intellisearchval").val().length;
        if (intellisearchlength>2) {
        $.post("search.php", { intellisearch: "true", value: $("#intellisearchval").val() },
          function(data){
            $("#searchresults").html(data);
            $("#searchresults").slideDown("slow");
          });
        }
    });
    $("#intellisearchcancel").click(function () {
        $("#intellisearchval").val("");
        $("#searchresults").slideUp("slow");
    });
    $(".datepick").datepicker({
        dateFormat: "{/literal}{$datepickerformat}{literal}",
        showOn: "button",
        buttonImage: "images/showcalendar.gif",
        buttonImageOnly: true,
        showButtonPanel: true
    });
    {/literal}{$jquerycode}{literal}
  });{/literal}
  {$jscode}
</script>
{$headoutput}
</head>
<body>
{$headeroutput}
  <div id="headerWrapper" align="center">
    <div id="bodyContentWrapper" align="left">
      <div id="mynotes"><textarea id="mynotesbox" rows="15" cols="80">{$admin_notes}</textarea><br /><input type="button" value="Save" id="savenotes" /></div>
      <div id="topnav">
        <div id="welcome">{$_ADMINLANG.global.welcomeback} <strong>{$admin_username}</strong>&nbsp;&nbsp;- <a href="../" title="Client Area">{$_ADMINLANG.global.clientarea}</a> | <a href="#" id="shownotes" title="My Notes">{$_ADMINLANG.global.mynotes}</a> | <a href="myaccount.php" title="My Account">{$_ADMINLANG.global.myaccount}</a> | <a href="logout.php" title="Logout">{$_ADMINLANG.global.logout}</a></div>
        <div id="date">{$smarty.now|date_format:"%A | %d %B %Y | %H:%M %p"}</div>
        <div class="clear"></div>
      </div>
      <div id="intellisearch"><strong>{$_ADMINLANG.global.intellisearch}</strong><br />
        <div style="padding-top: 5px;" align="center">
          <input type="text" id="intellisearchval" />
          <img src="images/icons/delete.png" alt="Cancel" width="16" height="16" class="absmiddle" id="intellisearchcancel" />
          </div>
        <div align="left" id="searchresults"></div>
      </div>
      <a title="WHMCS Home" href="./" id="logo"></a>
      <div class="navigation">
        <ul id="menu">
          {include file="v4/menu.tpl"}
        </ul>
      </div>
    </div>
  </div>
  <div id="content_container">
    <div id="left_side">

  {include file="v4/sidebar.tpl"}

    </div>
    <div id="content">
      {if $helplink}<div class="contexthelp"><a href="http://dereferer.ws/?http://docs.whmcs.com/{$helplink}" target="_blank"><img src="images/icons/help.png" border="0" align="absmiddle" /> {$_ADMINLANG.help.contextlink}</a></div>{/if}
      <h1>{$pagetitle}</h1>
      <div id="content_padded">
