{include file="$template/pageheader.tpl" title=$LANG.clientareanavchangepw}

{include file="$template/clientareadetailslinks.tpl"}

{if $successful}
<div class="alert-message success">
    <p>{$LANG.changessavedsuccessfully}</p>
</div>
{/if}

{if $errormessage}
<div class="alert-message error">
    <p class="bold">{$LANG.clientareaerrors}</p>
    <ul>
        {$errormessage}
    </ul>
</div>
{/if}

<form method="post" action="{$smarty.server.PHP_SELF}?action=changepw">

  <fieldset class="onecol">

    <div class="clearfix">
	    <label for="existingpw">{$LANG.existingpassword}</label>
		<div class="input">
		    <input type="password" name="existingpw" id="existingpw" />
		</div>
	</div>

    <div class="clearfix">
	    <label for="password">{$LANG.newpassword}</label>
		<div class="input">
		    <input type="password" name="newpw" id="password" />
		</div>
	</div>

    <div class="clearfix">
	    <label for="confirmpw">{$LANG.confirmnewpassword}</label>
		<div class="input">
		    <input type="password" name="confirmpw" id="confirmpw" />
		</div>
	</div>

    <div class="clearfix">
	    <label for="passstrength">{$LANG.pwstrength}</label>
		<div class="input">
            {include file="$template/pwstrength.tpl"}
		</div>
	</div>

  </fieldset>

  <div class="actions">
    <input class="btn primary" type="submit" name="submit" value="{$LANG.clientareasavechanges}" />
    <input class="btn" type="reset" value="{$LANG.cancel}" />
  </div>

</form>