{if $error}

<p>{$LANG.supportticketinvalid}</p>

{else}

{include file="$template/pageheader.tpl" title=$LANG.supportticketsviewticket|cat:' #'|cat:$tid}

{if $errormessage}
<div class="alert-message error">
    <p class="bold">{$LANG.clientareaerrors}</p>
    <ul>
        {$errormessage}
    </ul>
</div>
{/if}

<h2>{$subject}</h2>

<div class="ticketdetailscontainer">
    <div class="col4">
        <div class="internalpadding">
            {$LANG.supportticketsubmitted}
            <div class="detail">{$date}</div>
        </div>
    </div>
    <div class="col4">
        <div class="internalpadding">
            {$LANG.supportticketsdepartment}
            <div class="detail">{$department}</div>
        </div>
    </div>
    <div class="col4">
        <div class="internalpadding">
            {$LANG.supportticketspriority}
            <div class="detail">{$urgency}</div>
        </div>
    </div>
    <div class="col4">
        <div class="internalpadding">
            Status
            <div class="detail">{$status}</div>
        </div>
    </div>
    <div class="clear"></div>
</div>

{if $customfields}
<table>
{foreach from=$customfields item=customfield}
<tr><td>{$customfield.name}:</td><td>{$customfield.value}</td></tr>
{/foreach}
</table>
{/if}

<p><input type="button" value="{$LANG.clientareabacklink}" class="btn" onclick="window.location='supporttickets.php'" /> <input type="button" value="Reply" class="btn primary" onclick="jQuery('#replycont').slideToggle()" />{if $showclosebutton} <input type="button" value="Close Ticket" class="btn error" onclick="window.location='{$smarty.server.PHP_SELF}?tid={$tid}&amp;c={$c}&amp;closeticket=true'" />{/if}</p>

<div id="replycont" class="ticketreplybox{if !$smarty.get.postreply} hidden{/if}">
<form method="post" action="{$smarty.server.PHP_SELF}?tid={$tid}&amp;c={$c}&amp;postreply=true" enctype="multipart/form-data" class="form-stacked">

    <fieldset>

	    <div class="row">
            <div class="multicol">
                <div class="clearfix">
        		    <label for="name">{$LANG.supportticketsclientname}</label>
        			<div class="input">
        			    {if $loggedin}<input class="xlarge disabled" type="text" id="name" value="{$clientname}" disabled="disabled" />{else}<input class="xlarge" type="text" name="replyname" id="name" value="{$replyname}" />{/if}
        			</div>
        		</div>
        	</div>
            <div class="multicol">
                <div class="clearfix">
        		    <label for="email">{$LANG.supportticketsclientemail}</label>
        			<div class="input">
        			    {if $loggedin}<input class="xlarge disabled" type="text" id="email" value="{$email}" disabled="disabled" />{else}<input class="xlarge" type="text" name="replyemail" id="email" value="{$replyemail}" />{/if}
        			</div>
        		</div>
        	</div>
        </div>

	    <div class="clearfix">
		    <label for="message">{$LANG.contactmessage}</label>
			<div class="input">
			    <textarea name="replymessage" id="message" rows="12" class="fullwidth">{$replymessage}</textarea>
			</div>
		</div>

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

    <p align="center"><input type="submit" value="{$LANG.supportticketsticketsubmit}" class="btn primary" /></p>

</form>
</div>

<div class="ticketmsgs">
{foreach from=$descreplies key=num item=reply}
    <div class="{if $reply.admin}admin{else}client{/if}header">
        <div style="float:right;">{$reply.date}</div>
        {if $reply.admin}
            {$reply.name} || {$LANG.supportticketsstaff}
        {elseif $reply.contactid}
            {$reply.name} || {$LANG.supportticketscontact}
        {elseif $reply.userid}
            {$reply.name} || {$LANG.supportticketsclient}
        {else}
            {$reply.name} || {$reply.email}
        {/if}
    </div>
    <div class="{if $reply.admin}admin{else}client{/if}msg">

        {$reply.message}

        {if $reply.attachments}
        <div class="attachments">
            <strong>{$LANG.supportticketsticketattachments}:</strong><br />
            {foreach from=$reply.attachments key=num item=attachment}
            &nbsp; <img src="images/article.gif" align="middle" /> <a href="dl.php?type=ar&id={$reply.id}&i={$num}">{$attachment}</a><br />
            {/foreach}
        </div>
        {/if}

        {if $reply.id && $reply.admin && $ratingenabled}
        {if $reply.rating}
        <table class="ticketrating" align="right">
            <tr>
                <td>{$LANG.ticketreatinggiven}&nbsp</td>
                {foreach from=$ratings item=rating}
                <td background="images/rating_{if $reply.rating>=$rating}pos{else}neg{/if}.png"></td>
                {/foreach}
            </tr>
        </table>
        {else}
        <table class="ticketrating" align="right">
            <tr onmouseout="rating_leave('rate{$reply.id}')">
                <td>{$LANG.ticketratingquestion}&nbsp</td>
                <td class="point" onmouseover="rating_hover('rate{$reply.id}_1')" onclick="rating_select('{$tid}','{$c}','rate{$reply.id}_1')"><strong>{$LANG.ticketratingpoor}&nbsp;</strong></td>
                {foreach from=$ratings item=rating}
                <td class="star" id="rate{$reply.id}_{$rating}" onmouseover="rating_hover(this.id)" onclick="rating_select('{$tid}','{$c}',this.id)"></td>
                {/foreach}
                <td class="point" onmouseover="rating_hover('rate{$reply.id}_5')" onclick="rating_select('{$tid}','{$c}','rate{$reply.id}_5')"><strong>&nbsp;{$LANG.ticketratingexcellent}</strong></td>
            </tr>
        </table>
{/if}
<div class="clear"></div>
{/if}

    </div>
{/foreach}
</div>

<p><input type="button" value="{$LANG.clientareabacklink}" class="btn" onclick="window.location='supporttickets.php'" /> <input type="button" value="Reply" class="btn primary" onclick="jQuery('#replycont2').slideToggle()" />{if $showclosebutton} <input type="button" value="Close Ticket" class="btn error" onclick="window.location='{$smarty.server.PHP_SELF}?tid={$tid}&amp;c={$c}&amp;closeticket=true'" />{/if}</p>

<div id="replycont2" class="ticketreplybox hidden">
<form method="post" action="{$smarty.server.PHP_SELF}?tid={$tid}&amp;c={$c}&amp;postreply=true" enctype="multipart/form-data" class="form-stacked">

    <fieldset>

	    <div class="row">
            <div class="multicol">
                <div class="clearfix">
        		    <label for="name">{$LANG.supportticketsclientname}</label>
        			<div class="input">
        			    {if $loggedin}<input class="xlarge disabled" type="text" id="name" value="{$clientname}" disabled="disabled" />{else}<input class="xlarge" type="text" name="replyname" id="name" value="{$replyname}" />{/if}
        			</div>
        		</div>
        	</div>
            <div class="multicol">
                <div class="clearfix">
        		    <label for="email">{$LANG.supportticketsclientemail}</label>
        			<div class="input">
        			    {if $loggedin}<input class="xlarge disabled" type="text" id="email" value="{$email}" disabled="disabled" />{else}<input class="xlarge" type="text" name="replyemail" id="email" value="{$replyemail}" />{/if}
        			</div>
        		</div>
        	</div>
        </div>

	    <div class="clearfix">
		    <label for="message">{$LANG.contactmessage}</label>
			<div class="input">
			    <textarea name="replymessage" id="message" rows="12" class="fullwidth">{$replymessage}</textarea>
			</div>
		</div>

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

    <p align="center"><input type="submit" value="{$LANG.supportticketsticketsubmit}" class="btn primary" /></p>

</form>
</div>

{/if}