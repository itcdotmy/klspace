{include file="$template/pageheader.tpl" title=$LANG.sslconfsslcertificate}

{if $errormessage}
<div class="alert-message error">
    <p class="bold">{$LANG.clientareaerrors}</p>
    <ul>
        {$errormessage}
    </ul>
</div>
{/if}

{include file="$template/subheader.tpl" title=$LANG.sslcertinfo}

<div class="row">
<div class="col2half">
    <p><h4>{$LANG.sslcerttype}:</h4> {$certtype}</p>
</div>
<div class="col2half">
    <p><h4>{$LANG.sslorderdate}:</h4> {$date}</p>
</div>
{if $domain}<div class="col2half">
    <p><h4>{$LANG.domainname}:</h4> {$domain}</p>
</div>{/if}
<div class="col2half">
    <p><h4>{$LANG.orderprice}:</h4> {$price}</p>
</div>
<div class="col2half">
    <p><h4>{$LANG.sslstatus}:</h4> {$status}</p>
</div>
{foreach from=$displaydata key=displaydataname item=displaydatavalue}
<div class="col2half">
    <p><h4>{$displaydataname}:</h4> {$displaydatavalue}</p>
</div>
{/foreach}
</div>

<form method="post" action="{$smarty.server.PHP_SELF}?cert={$cert}&step=3">

{include file="$template/subheader.tpl" title=$LANG.sslcertapproveremail}

<p>{$LANG.sslcertapproveremaildetails}</p>

<fieldset class="onecol">

    <div class="clearfix">
	    <label for="servertype">{$LANG.sslcertapproveremail}</label>
		<div class="input">
            {foreach from=$approveremails item=approveremail key=num}
            <label class="full"><input type="radio" name="approveremail" value="{$approveremail}"{if $num eq 0} checked{/if} /> {$approveremail}</label><br />
            {/foreach}
		</div>
	</div>

</fieldset>

<p class="textcenter"><input type="submit" value="{$LANG.ordercontinuebutton}" class="btn primary" /></p>

</form>

<br />
<br />
<br />