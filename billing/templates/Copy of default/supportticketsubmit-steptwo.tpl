{include file="$template/pageheader.tpl" title=$LANG.navopenticket}

<script language="javascript">
var currentcheckcontent,lastcheckcontent;
{if $kbsuggestions}
{literal}
function getticketsuggestions() {
    currentcheckcontent = jQuery("#message").val();
    if (currentcheckcontent!=lastcheckcontent && currentcheckcontent!="") {
        jQuery.post("submitticket.php", { action: "getkbarticles", text: currentcheckcontent },
        function(data){
            if (data) {
                jQuery("#searchresults").html(data);
                jQuery("#searchresults").slideDown();
            }
        });
        lastcheckcontent = currentcheckcontent;
	}
    setTimeout('getticketsuggestions();', 3000);
}
getticketsuggestions();
{/literal}
{/if}
</script>

{if $errormessage}
<div class="alert-message error">
    <p class="bold">{$LANG.clientareaerrors}</p>
    <ul>
        {$errormessage}
    </ul>
</div>
{/if}

<form name="submitticket" method="post" action="{$smarty.server.PHP_SELF}?step=3" enctype="multipart/form-data" class="form-stacked">

    <fieldset>

	    <div class="row">
            <div class="multicol">
                <div class="clearfix">
        		    <label for="name">{$LANG.supportticketsclientname}</label>
        			<div class="input">
        			    {if $loggedin}<input class="xlarge disabled" type="text" id="name" value="{$clientname}" disabled="disabled" />{else}<input class="xlarge" type="text" name="name" id="name" value="{$name}" />{/if}
        			</div>
        		</div>
        	</div>
            <div class="multicol">
                <div class="clearfix">
        		    <label for="email">{$LANG.supportticketsclientemail}</label>
        			<div class="input">
        			    {if $loggedin}<input class="xlarge disabled" type="text" id="email" value="{$email}" disabled="disabled" />{else}<input class="xlarge" type="text" name="email" id="email" value="{$email}" />{/if}
        			</div>
        		</div>
        	</div>
        </div>
        <div class="row">
    	    <div class="clearfix">
    		    <label for="subject">{$LANG.supportticketsticketsubject}</label>
    			<div class="input">
    			    <input class="xlarge" type="text" name="subject" id="subject" value="{$subject}" style="width:80%;" />
    			</div>
    		</div>
		</div>
        <div class="row">
            <div class="multicol">
                <div class="clearfix">
        		    <label for="name">{$LANG.supportticketsdepartment}</label>
        			<div class="input">
        			    <select name="deptid">
                        {foreach from=$departments item=department}
                            <option value="{$department.id}"{if $department.id eq $deptid} selected="selected"{/if}>{$department.name}</option>
                        {/foreach}
                        </select>
        			</div>
        		</div>
    		</div>
{if $relatedservices}
    	     <div class="multicol">
                 <div class="clearfix">
        		    <label for="relatedservice">{$LANG.relatedservice}</label>
        			<div class="input">
        			    <select name="relatedservice" id="relatedservice">
                            <option value="">{$LANG.none}</option>
                            {foreach from=$relatedservices item=relatedservice}
                            <option value="{$relatedservice.id}">{$relatedservice.name} ({$relatedservice.status})</option>
                            {/foreach}
                        </select>
        			</div>
        		</div>
    		</div>
{/if}
            <div class="multicol">
        	    <div class="clearfix">
        		    <label for="priority">{$LANG.supportticketspriority}</label>
        			<div class="input">
        			    <select name="urgency" id="priority">
                            <option value="High"{if $urgency eq "High"} selected="selected"{/if}>{$LANG.supportticketsticketurgencyhigh}</option>
                            <option value="Medium"{if $urgency eq "Medium" || !$urgency} selected="selected"{/if}>{$LANG.supportticketsticketurgencymedium}</option>
                            <option value="Low"{if $urgency eq "Low"} selected="selected"{/if}>{$LANG.supportticketsticketurgencylow}</option>
                        </select>
        			</div>
        		</div>
    		</div>
        </div>

	    <div class="clearfix">
		    <label for="message">{$LANG.contactmessage}</label>
			<div class="input">
			    <textarea name="message" id="message" rows="12" class="fullwidth">{$message}</textarea>
			</div>
		</div>
{foreach key=num item=customfield from=$customfields}
	    <div class="clearfix">
		    <label for="customfield{$customfield.id}">{$customfield.name}</label>
			<div class="input">
			    {$customfield.input} {$customfield.description}
			</div>
		</div>
{/foreach}
	    <div class="clearfix">
		    <label for="attachments">{$LANG.supportticketsticketattachments}:</label>
			<div class="input">
			    <input type="file" name="attachments[]" style="width:70%;" /><br />
                <div id="fileuploads"></div>
                <a href="#" onclick="extraTicketAttachment();return false"><img src="images/add.gif" align="absmiddle" border="0" /> {$LANG.addmore}</a><br />
                ({$LANG.supportticketsallowedextensions}: {$allowedfiletypes})
			</div>
		</div>

    </fieldset>

<div id="searchresults" class="contentbox" style="display:none;"></div>

{if $capatacha}
<h3>{$LANG.captchatitle}</h3>
<p>{$LANG.captchaverify}</p>
{if $capatacha eq "recaptcha"}
<div align="center">{$recapatchahtml}</div>
{else}
<p align="center"><img src="includes/verifyimage.php" align="middle" /> <input type="text" name="code" class="small" maxlength="5" /></p>
{/if}
{/if}

<div class="actions">
    <input class="btn primary" type="submit" name="save" value="{$LANG.supportticketsticketsubmit}" />
    <input class="btn" type="reset" value="{$LANG.cancel}" />
</div>

</form>