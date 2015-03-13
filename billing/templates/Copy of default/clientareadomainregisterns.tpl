{include file="$template/pageheader.tpl" title=$LANG.domainregisterns}

<div class="alert-message block-message info">
    <p>{$LANG.domainname}: <strong>{$domain}</strong</p>
</div>

<p>{$LANG.domainregisternsexplanation}</p>

<br />

{if $result}
    <div class="alert-message error">
        <p class="bold textcenter">{$result}</p>
    </div>
{/if}

<form method="post" action="{$smarty.server.PHP_SELF}?action=domainregisterns">
<input type="hidden" name="sub" value="register" />
<input type="hidden" name="domainid" value="{$domainid}" />

{include file="$template/subheader.tpl" title=$LANG.domainregisternsreg}

<fieldset class="onecol">

    <div class="clearfix">
	    <label for="ns1">{$LANG.domainregisternsns}</label>
		<div class="input">
		    <input type="text" name="ns" id="ns1" class="small" /> . {$domain}
		</div>
	</div>

    <div class="clearfix">
	    <label for="ip1">{$LANG.domainregisternsip}</label>
		<div class="input">
		    <input type="text" name="ipaddress" id="ip1" />
		</div>
	</div>

    <p align="center"><input type="submit" value="{$LANG.clientareasavechanges}" class="btn primary" /></p>

</fieldset>

</form>

<br />

<form method="post" action="{$smarty.server.PHP_SELF}?action=domainregisterns">
<input type="hidden" name="sub" value="modify" />
<input type="hidden" name="domainid" value="{$domainid}" />

{include file="$template/subheader.tpl" title=$LANG.domainregisternsmod}

<fieldset class="onecol">

    <div class="clearfix">
	    <label for="ns2">{$LANG.domainregisternsns}</label>
		<div class="input">
		    <input type="text" name="ns" id="ns2" class="small" /> . {$domain}
		</div>
	</div>

    <div class="clearfix">
	    <label for="ip2">{$LANG.domainregisternscurrentip}</label>
		<div class="input">
		    <input type="text" name="currentipaddress" id="ip2" />
		</div>
	</div>

    <div class="clearfix">
	    <label for="ip3">{$LANG.domainregisternsnewip}</label>
		<div class="input">
		    <input type="text" name="newipaddress" id="ip3" />
		</div>
	</div>

    <p align="center"><input type="submit" value="{$LANG.clientareasavechanges}" class="btn primary" /></p>

</fieldset>

</form>

<br />

<form method="post" action="{$smarty.server.PHP_SELF}?action=domainregisterns">
<input type="hidden" name="sub" value="delete" />
<input type="hidden" name="domainid" value="{$domainid}" />

{include file="$template/subheader.tpl" title=$LANG.domainregisternsdel}

<fieldset class="onecol">

    <div class="clearfix">
	    <label for="ns3">{$LANG.domainregisternsns}</label>
		<div class="input">
		    <input type="text" name="ns" id="ns3" class="small" /> . {$domain}
		</div>
	</div>

    <p align="center"><input type="submit" value="{$LANG.clientareasavechanges}" class="btn primary" /></p>

</fieldset>

</form>

<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
<input type="hidden" name="id" value="{$domainid}" />
<p><input type="submit" value="{$LANG.clientareabacklink}" class="btn" /></p>
</form>