<script language="javascript">
var ticketid = '{$ticketid}';
var pagefilename = '{$smarty.server.PHP_SELF}';
var ticketcontent = "";
var selectedTab;
{literal}
function doDeleteReply(id) {
    if (confirm("{/literal}{$_ADMINLANG.support.delreplysure}{literal}")) {
        window.location=pagefilename+'?action=viewticket&id='+ticketid+'&sub=del&idsd='+id;
    }
}
function doDeleteTicket() {
    if (confirm("{/literal}{$_ADMINLANG.support.delticketsure}{literal}")) {
        window.location=pagefilename+'?sub=deleteticket&id='+ticketid;
    }
}
function doDeleteNote(id) {
    if (confirm("{/literal}{$_ADMINLANG.support.delnotesure}{literal}")) {
        window.location=pagefilename+'?action=viewticket&id='+ticketid+'&sub=delnote&idsd='+id;
    }
}
function quoteTicket(id,ids) {
    $(".tab").removeClass("tabselected");
    $("#tab0").addClass("tabselected");
    $(".tabbox").hide();
    $("#tab0box").show();
    $.post("supporttickets.php", { action: "getquotedtext", id: id, ids: ids },
    function(data){
        $("#replymessage").val(data+"\n\n"+$("#replymessage").val());
    });
    return false;
}
function selectpredefcat(catid) {
    $.post("supporttickets.php", { action: "loadpredefinedreplies", cat: catid },
    function(data){
        $("#prerepliescontent").html(data);
    });
}
function selectpredefreply(artid) {
    $.post("supporttickets.php", { action: "getpredefinedreply", id: artid },
    function(data){
        $("#replymessage").addToReply(data);
    });
    $("#prerepliescontainer").slideToggle();
}
function searchselectclient(userid) {
    $("#clientsearchval").val(userid);
	$("#ticketclientsearchresults").slideUp("slow");
    $("#clientsearchcancel").fadeOut();
}

$(document).ready(function(){

$(".tabbox").css("display","none");
$(".tab").click(function(){
    var elid = $(this).attr("id");
    if (elid != selectedTab) {
        $(".tab").removeClass("tabselected");
        $("#"+elid).addClass("tabselected");
        $(".tabbox").slideUp();
        $("#"+elid+"box").slideDown();
        $("#tab").val(elid.substr(3));
        selectedTab = elid;
    }
});
selectedTab = "tab0";
$("#tab0").addClass("tabselected");
$("#tab0box").css("display","");
$(".editbutton").click(function () {
    var butid = $(this).attr("id");
    ticketcontent = $("#"+butid+"_box").html();
    var browsername = navigator.appName;
    if (browsername == "Microsoft Internet Explorer") {
        var ticketcontentpassback = ticketcontent.replace(/<br>/gi, '\n');
    } else {
        var ticketcontentpassback = ticketcontent.replace(/<br>/gi, '');
    }
    $("#"+butid+"_box").html("<textarea rows=\"10\" style=\"width:99%\" id=\""+butid+"_box_text\">"+ticketcontentpassback+"</textarea>");
    $(".editticketbuttons"+butid).toggle();
});
$(".savebutton").click(function () {
    var butid = $(this).attr("id");
    var newticketcontent = $("#"+butid+"_box_text").val();
    var ticketcontentpassback = newticketcontent.replace(/\n/gi, '<br>');
    $("#"+butid+"_box").html(ticketcontentpassback);
    $.post("supporttickets.php", { action: "updatereply", text: newticketcontent, id: butid });
    $(".editticketbuttons"+butid).toggle();
});
$(".cancelbutton").click(function () {
    var butid = $(this).attr("id");
    $("#"+butid+"_box").html(ticketcontent);
    $(".editticketbuttons"+butid).toggle();
});
$("#replymessage").focus(function () {
	$.post("supporttickets.php", { action: "makingreply", id: ticketid },
	function(data){
        $("#replyingadmin").html(data);
    });
    return false;
});
$("#replyfrm").submit(function () {
	var status = $("#ticketstatus").val();
	var response = $.ajax({
		type: "POST",
		url: "supporttickets.php?action=checkstatus",
		data: "id="+ticketid+"&ticketstatus="+status,
		async: false
	}).responseText;
	if (response == "true") {
    	return true;
	} else {
		if (confirm("{/literal}{$_ADMINLANG.support.statuschanged}{literal}\n\n{/literal}{$_ADMINLANG.support.stillsubmit}{literal}")) {
	        return true;
	    }
	    return false;
	}
});

$(window).unload( function () {
    $.post("supporttickets.php", { action: "endreply", id: ticketid });
});
$("#insertpredef").click(function () {
    $("#prerepliescontainer").slideToggle();
    return false;
});
$("#addfileupload").click(function () {
    $("#fileuploads").append("<input type=\"file\" name=\"attachments[]\" size=\"85\"><br />");
    return false;
});
$("#ticketstatus").change(function () {
    $.post("supporttickets.php", { action: "changestatus", id: ticketid, status: this.options[this.selectedIndex].text });
});
$("#predefq").keyup(function () {
    var intellisearchlength = $("#predefq").val().length;
    if (intellisearchlength>2) {
    $.post("supporttickets.php", { action: "loadpredefinedreplies", predefq: $("#predefq").val() },
        function(data){
            $("#prerepliescontent").html(data);
        });
    }
});

$("#clientsearchval").keyup(function () {
	var ticketuseridsearchlength = $("#clientsearchval").val().length;
	if (ticketuseridsearchlength>2) {
	$.post("search.php", { ticketclientsearch: 1, value: $("#clientsearchval").val() },
	    function(data){
            if (data) {
                $("#ticketclientsearchresults").html(data);
                $("#ticketclientsearchresults").slideDown("slow");
                $("#clientsearchcancel").fadeIn();
            }
        });
	}
});
$("#clientsearchcancel").click(function () {
    $("#ticketclientsearchresults").slideUp("slow");
    $("#clientsearchcancel").fadeOut();
});

});
{/literal}
</script>

{$infobox}

<div id="replyingadmin">
{if $replyingadmin}<div class="errorbox">{$replyingadmin.name} {$_ADMINLANG.support.viewedandstarted} @ {$replyingadmin.time}</div>{/if}
</div>

<h2>#{$tid} - {$subject} <select name="ticketstatus" id="ticketstatus" style="font-size:18px;">
{foreach from=$statuses item=statusitem}
<option{if $statusitem.title eq $status} selected{/if} style="color:{$statusitem.color}">{$statusitem.title}</option>
{/foreach}
</select></h2>

<p>{$_ADMINLANG.fields.client}: {if $userid}<a href="clientssummary.php?userid={$userid}"{if $clientgroupcolour} style="background-color:{$clientgroupcolour}"{/if} target="_blank">{$clientname}</a>{if $contactid} (<a href="clientscontacts.php?userid={$userid}&contactid={$contactid}"{if $clientgroupcolour} style="background-color:{$clientgroupcolour}"{/if} target="_blank">{$contactname}</a>){/if}{else}{$_ADMINLANG.support.notregclient}{/if} | {$_ADMINLANG.support.lastreply}: {$lastreply}</p>

{foreach from=$addons_html item=addon_html}
<div style="margin-bottom:15px;">{$addon_html}</div>
{/foreach}

<div id="tabs">
    <ul>
        <li id="tab0" class="tab"><a href="javascript:;">{$_ADMINLANG.support.addreply}</a></li>
        <li id="tab1" class="tab"><a href="javascript:;">{$_ADMINLANG.support.addnote}</a></li>
        <li id="tab2" class="tab"><a href="javascript:;">{$_ADMINLANG.setup.customfields}</a></li>
        <li id="tab3" class="tab"><a href="javascript:;">{$_ADMINLANG.fields.options}</a></li>
        <li id="tab4" class="tab"><a href="javascript:;">{$_ADMINLANG.clientsummary.log}</a></li>
    </ul>
</div>

<div id="tab0box" class="tabbox">
    <div id="tab_content">

<form method="post" action="{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}" enctype="multipart/form-data" name="replyfrm" id="replyfrm">

<textarea name="message" id="replymessage" rows="14" style="width:100%">


{$signature}</textarea>

<br /><img src="images/spacer.gif" height="8" width="1" /><br />

<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td width="15%" class="fieldlabel">{$_ADMINLANG.support.postreply}</td><td class="fieldarea"><select name="postaction">
<option value="return">{$_ADMINLANG.support.setansweredreturn}
<option value="answered">{$_ADMINLANG.support.setansweredremain}
{foreach from=$statuses item=statusitem}
{if $statusitem.id > 4}<option value="setstatus{$statusitem.id}">{$_ADMINLANG.support.setto} {$statusitem.title} {$_ADMINLANG.support.andremain}</option>{/if}
{/foreach}
<option value="close">{$_ADMINLANG.support.closereturn}
<option value="note">{$_ADMINLANG.support.addprivatenote}
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" onClick="window.open('supportticketskbarticle.php','kbartwnd','width=500,height=400,scrollbars=yes');return false">{$_ADMINLANG.support.insertkblink}</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" id="insertpredef">{$_ADMINLANG.support.insertpredef}</a>
</td></tr>
<tr><td class="fieldlabel">{$_ADMINLANG.support.attachments}</td><td class="fieldarea"><input type="file" name="attachments[]" size="85"> <a href="#" id="addfileupload"><img src="images/icons/add.png" align="absmiddle" border="0" /> {$_ADMINLANG.support.addmore}</a><br /><div id="fileuploads"></div></td></tr>
{if $userid}<tr><td class="fieldlabel">{$_ADMINLANG.support.addbilling}</td><td class="fieldarea"><input type="text" name="billingdescription" size="60" value="{$_ADMINLANG.support.toinvoicedes}" onfocus="if(this.value=='{$_ADMINLANG.support.toinvoicedes}')this.value=''" /> @ <input type="text" name="billingamount" size="10" value="{$_ADMINLANG.fields.amount}" /> <select name="billingaction">
<option value="3" /> {$_ADMINLANG.billableitems.invoiceimmediately}</option>
<option value="0" /> {$_ADMINLANG.billableitems.dontinvoicefornow}</option>
<option value="1" /> {$_ADMINLANG.billableitems.invoicenextcronrun}</option>
<option value="2" /> {$_ADMINLANG.billableitems.addnextinvoice}</option>
</select></td></tr>{/if}
</table>

<div id="prerepliescontainer" style="display:none;">
    <img src="images/spacer.gif" height="8" width="1" />
    <br />
    <div style="border:1px solid #DFDCCE;background-color:#F7F7F2;padding:5px;text-align:left;">
        <div style="float:right;">Search: <input type="text" id="predefq" size="25" /></div>
        <div id="prerepliescontent">{$predefinedreplies}</div>
    </div>
</div>

<img src="images/spacer.gif" height="8" width="1" />
<br />
<div align="center"><input type="submit" value="{$_ADMINLANG.support.addresponse}" name="postreply" class="button" id="postreplybutton" /></div>

</form>

    </div>
</div>
<div id="tab1box" class="tabbox">
    <div id="tab_content">

<form method="post" action="{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}">
<input type="hidden" name="postaction" value="note" />

<textarea name="message" id="replymessage" rows="14" style="width:100%"></textarea>

<br />
<img src="images/spacer.gif" height="8" width="1" />
<br />

<div align="center"><input type="submit" value="{$_ADMINLANG.support.addnote}" class="button" name="postreply" /></div>

</form>

    </div>
</div>
<div id="tab2box" class="tabbox">
    <div id="tab_content">

<form method="post" action="{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}&sub=savecustomfields">

{if !$numcustomfields}
<div align="center">{$_ADMINLANG.support.nocustomfields}</div>
{else}
<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
{foreach from=$customfields item=customfield}
<tr><td width="25%" class="fieldlabel">{$customfield.name}</td><td class="fieldarea">{$customfield.input}</td></tr>
{/foreach}
</table>
<img src="images/spacer.gif" height="10" width="1" /><br />
<div align="center"><input type="submit" value="{$_ADMINLANG.global.savechanges}" class="button"></div>
</form>
{/if}

    </div>
</div>
<div id="tab3box" class="tabbox">
    <div id="tab_content">

<form method="post" action="{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}">

<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
<tr><td width="15%" class="fieldlabel">{$_ADMINLANG.support.department}</td><td class="fieldarea"><select name="deptid">
{foreach from=$departments item=department}
<option value="{$department.id}"{if $department.id eq $deptid} selected{/if}>{$department.name}</option>
{/foreach}
</select></td><td width="15%" class="fieldlabel">{$_ADMINLANG.fields.clientid}</td><td class="fieldarea"><input type="text" name="userid" size="15" id="clientsearchval" value="{$userid}" /> <img src="images/icons/delete.png" alt="Cancel" class="absmiddle" id="clientsearchcancel" height="16" width="16"><div id="ticketclientsearchresults"></div></td></tr>
<tr><td class="fieldlabel">{$_ADMINLANG.fields.subject}</td><td class="fieldarea"><input type="text" name="subject" value="{$subject}" style="width:80%"></td><td class="fieldlabel">{$_ADMINLANG.support.flag}</td><td class="fieldarea"><select name="flagto">
<option value="0">{$_ADMINLANG.global.none}</option>
{foreach from=$staff item=staffmember}
<option value="{$staffmember.id}"{if $staffmember.id eq $flag} selected{/if}>{$staffmember.name}</option>
{/foreach}
</select></td></tr>
<tr><td class="fieldlabel">{$_ADMINLANG.fields.status}</td><td class="fieldarea"><select name="status">
{foreach from=$statuses item=statusitem}
<option{if $statusitem.title eq $status} selected{/if} style="color:{$statusitem.color}">{$statusitem.title}</option>
{/foreach}
</select></td><td class="fieldlabel">{$_ADMINLANG.support.priority}</td><td class="fieldarea"><select name="priority">
<option value="High"{if $priority eq "High"} selected{/if}>{$_ADMINLANG.status.high}</option>
<option value="Medium"{if $priority eq "Medium"} selected{/if}>{$_ADMINLANG.status.medium}</option>
<option value="Low"{if $priority eq "Low"} selected{/if}>{$_ADMINLANG.status.low}</option>
</select></td></tr>
<tr><td class="fieldlabel">{$_ADMINLANG.support.ccrecepients}</td><td class="fieldarea"><input type="text" name="cc" value="{$cc}" size="40"> ({$_ADMINLANG.transactions.commaseparated})</td><td class="fieldlabel">{$_ADMINLANG.support.mergeticket}</td><td class="fieldarea"><input type="text" name="mergetid" size="10"> ({$_ADMINLANG.support.notocombine})</td></tr>
</table>

<img src="images/spacer.gif" height="10" width="1"><br>
<div align="center"><input type="submit" value="{$_ADMINLANG.global.savechanges}" class="button"></div>
</form>

    </div>
</div>
<div id="tab4box" class="tabbox">
    <div id="tab_content">

<table cellspacing=1 bgcolor=#cccccc width=100%>
<tr style="background-color:#f2f2f2;font-weight:bold;text-align:center;"><td>{$_ADMINLANG.fields.date}</td><td>{$_ADMINLANG.permissions.action}</td></tr>
{foreach from=$ticketlog item=log}
<tr bgcolor="#ffffff"><td align=center width=160>{$log.date}</td><td>{$log.action}</td></tr>
{/foreach}
</table>

    </div>
</div>

<br />

{if $numnotes}
<h2>{$_ADMINLANG.support.privatestaffnote}</h2>
{foreach from=$notes item=note}
<div class="ticketstaffnotes">
<table class="ticketstaffnotestable">
<tr><td><strong>{$note.admin}</strong></td><td align="right"><strong>{$note.date}</strong></td><td width="16"><a href="#" onClick="doDeleteNote('{$note.id}');return false"><img src="images/delete.gif" alt="{$_ADMINLANG.support.deleteticketnote}" border="0" align="absmiddle"></a></td></tr>
</table>
{$note.message}
</div><br />
{/foreach}
{/if}

{if $relatedservices}
<div class="tablebg">
<table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
<tr><th>{$_ADMINLANG.fields.product}</th><th>{$_ADMINLANG.fields.amount}</th><th>{$_ADMINLANG.fields.billingcycle}</th><th>{$_ADMINLANG.fields.signupdate}</th><th>{$_ADMINLANG.fields.nextduedate}</th><th>{$_ADMINLANG.fields.status}</th></tr>
{foreach from=$relatedservices item=relatedservice}
<tr{if $relatedservice.selected} class="rowhighlight"{/if}><td>{$relatedservice.name}</td><td>{$relatedservice.amount}</td><td>{$relatedservice.billingcycle}</td><td>{$relatedservice.regdate}</td><td>{$relatedservice.nextduedate}</td><td>{$relatedservice.status}</td></tr>
{/foreach}
</table>
</div>
{/if}

<br />

<table width=100% cellpadding=5 cellspacing=1 bgcolor="#cccccc" align=center>
{foreach from=$replies item=reply}
<tr><td rowspan="2" bgcolor="{cycle values="#F4F4F4,#F8F8F8"}" width="200" valign="top">

{if $reply.admin}

<strong>{$reply.admin}</strong><br />
{$_ADMINLANG.support.staff}<br />

{if $reply.rating}
<br />
{$_ADMINLANG.support.rating}: {$reply.rating}
<br />
{/if}

{else}

<strong>{$reply.clientname}</strong><br />

{if $reply.contactid}
{$_ADMINLANG.fields.contact}<br />
{elseif $reply.userid}
{$_ADMINLANG.fields.client}<br />
{else}
<a href="mailto:{$reply.clientemail}">{$reply.clientemail}</a>
<br />
<input type="button" value="{$_ADMINLANG.support.blocksender}" style="font-size:9px;" onclick="window.location='{$smarty.server.PHP_SELF}?action=viewticket&id={$ticketid}&blocksender=true'"><br>
{/if}

{/if}

{if $reply.id}

<br />
<div class="editticketbuttons{$reply.id}"><input type="button" value="{$_ADMINLANG.global.edit}" class="editbutton" id="{$reply.id}" /></div><div class="editticketbuttons{$reply.id}" style="display:none"><input type="button" value="{$_ADMINLANG.global.savechanges}" class="savebutton" id="{$reply.id}" >&nbsp;<input type="button" value="{$_ADMINLANG.global.cancelchanges}" class="cancelbutton" id="{$reply.id}" /></div>

{/if}

</td><td bgcolor="#F4F4F4">

{if $reply.id}
<a href="#" onClick="doDeleteReply('{$reply.id}');return false">
{else}
<a href="#" onClick="doDeleteTicket();return false">
{/if}
<img src="images/icons/delete.png" alt="{$_ADMINLANG.support.deleteticket}" align="right" border="0" hspace="5"></a>

{if $reply.id}
<a href="#" onClick="quoteTicket('','{$reply.id}')">
{else}
<a href="#" onClick="quoteTicket('{$ticketid}','')">
{/if}
<img src="images/icons/quote.png" align="right" border="0"></a> {$reply.date}

</td></tr>
<tr><td bgcolor="#F4F4F4"{if $reply.id} id="{$reply.id}_box"{/if}>

{$reply.message}

{if $reply.numattachments}
<p>
<b>{$_ADMINLANG.support.attachments}</b>
<br />
{foreach from=$reply.attachments key=num item=attachment}
{if $thumbnails}
<div class="ticketattachmentcontainer">
<a href="../{$attachment.dllink}"><img src="../includes/thumbnail.php?{if $reply.id}rid={$reply.id}{else}tid={$ticketid}{/if}&i={$num}" class="ticketattachmentthumb" /><br />
<img src="images/icons/attachment.png" align="absmiddle" /> {$attachment.filename}</a><br /><small><a href="{$attachment.deletelink}" onclick="return confirm('{$_ADMINLANG.support.delattachment|escape:'javascript'}')" style="color:#cc0000">{$_ADMINLANG.support.remove}</a></small>
</div>
{else}
<a href="../{$attachment.dllink}"><img src="images/icons/attachment.png" align="absmiddle" /> {$attachment.filename}</a> <small><a href="{$attachment.deletelink}" onclick="return confirm('{$_ADMINLANG.support.delattachment|escape:'javascript'}')" style="color:#cc0000">{$_ADMINLANG.support.remove}</a></small><br />
{/if}
{/foreach}
</p>
{/if}

</td></tr>
{/foreach}
</table>

<p align="center"><a href="supportticketsprint.php?id={$ticketid}" target="_blank">{$_ADMINLANG.support.viewprintable}</a></p>
