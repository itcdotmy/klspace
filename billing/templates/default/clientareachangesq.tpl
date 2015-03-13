{include file="$template/pageheader.tpl" title=$LANG.clientareanavsecurityquestions}

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

<form method="post" action="{$smarty.server.PHP_SELF}?action=changesq">

  <fieldset class="onecol">

{if !$nocurrent}
    <div class="clearfix">
	    <label for="currentans">{$currentquestion}</label>
		<div class="input">
		    <input type="password" name="currentsecurityqans" id="currentans" />
		</div>
	</div>
{/if}
    <div class="clearfix">
	    <label for="securityqid">{$LANG.clientareasecurityquestion}</label>
		<div class="input">
		    <select name="securityqid" id="securityqid">
            {foreach key=num item=question from=$securityquestions}
            	<option value={$question.id}>{$question.question}</option>
            {/foreach}
            </select>
		</div>
	</div>

    <div class="clearfix">
	    <label for="securityqans">{$LANG.clientareasecurityanswer}</label>
		<div class="input">
		    <input type="password" name="securityqans" id="securityqans" />
		</div>
	</div>

    <div class="clearfix">
	    <label for="securityqans2">{$LANG.clientareasecurityconfanswer}</label>
		<div class="input">
		    <input type="password" name="securityqans2" id="securityqans2" />
		</div>
	</div>

  </fieldset>

  <div class="actions">
    <input class="btn primary" type="submit" name="submit" value="{$LANG.clientareasavechanges}" />
    <input class="btn" type="reset" value="{$LANG.cancel}" />
  </div>

</form>