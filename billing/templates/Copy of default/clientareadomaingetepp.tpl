{include file="$template/pageheader.tpl" title=$LANG.domaingeteppcode}

<div class="alert-message block-message info">
    <p>{$LANG.domainname}: <strong>{$domain}</strong</p>
</div>

<p>{$LANG.domaingeteppcodeexplanation}</p>

<br />

{if $error}
<div class="alert-message error textcenter">
    {$LANG.domaingeteppcodefailure} {$error}
</div>
{else}
    {if $eppcode}
    <div class="alert-message warn textcenter">
        {$LANG.domaingeteppcodeis} {$eppcode}
    </div>
    {else}
    <div class="alert-message warn textcenter">
        {$LANG.domaingeteppcodeemailconfirmation}
    </div>
    {/if}
{/if}

<br />

<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
<input type="hidden" name="id" value="{$domainid}" />
<p><input type="submit" value="{$LANG.clientareabacklink}" class="btn" /></p>
</form>