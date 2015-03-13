{include file="$template/pageheader.tpl" title=$LANG.clientareanavccdetails}

{include file="$template/clientareadetailslinks.tpl"}

{if $remoteupdatecode}

  <div align="center">
    {$remoteupdatecode}
  </div>

{else}

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

<form method="post" action="{$smarty.server.PHP_SELF}?action=creditcard">

  <fieldset class="onecol">

    <div class="clearfix">
	    <label>{$LANG.creditcardcardtype}</label>
		<div class="input">
		    <input type="text" value="{$cardtype}" disabled="true" />
		</div>
	</div>

    <div class="clearfix">
	    <label>{$LANG.creditcardcardnumber}</label>
		<div class="input">
		    <input type="text" value="{$cardnum}" disabled="true" />
		</div>
	</div>

    <div class="clearfix">
	    <label>{$LANG.creditcardcardexpires}</label>
		<div class="input">
		    <input type="text" value="{$cardexp}" disabled="true" class="small" />
		</div>
	</div>
{if $cardissuenum}
    <div class="clearfix">
	    <label>{$LANG.creditcardcardissuenum}</label>
		<div class="input">
		    <input type="text" value="{$cardissuenum}" disabled="true" class="small" />
		</div>
	</div>
{/if}{if $cardstart}
    <div class="clearfix">
	    <label>{$LANG.creditcardcardstart}</label>
		<div class="input">
		    <input type="text" value="{$cardstart}" disabled="true" class="small" />
		</div>
	</div>
{/if}
{if $allowcustomerdelete && $cardtype}
    <div class="clearfix">
        <label>&nbsp;</label>
        <div class="input">
            <input class="btn" type="button" value="{$LANG.creditcarddelete}" onclick="window.location='clientarea.php?action=creditcard&delete=true'" />
        </div>
    </div>
{/if}
  </fieldset>

<div class="styled_title"><h3>{$LANG.creditcardenternewcard}</h3></div>

  <fieldset class="onecol">

    <div class="clearfix">
	    <label for="cctype">{$LANG.creditcardcardtype}</label>
		<div class="input">
		    <select name="cctype" id="cctype">
            {foreach key=num item=cardtype from=$acceptedcctypes}
                <option>{$cardtype}</option>
            {/foreach}
            </select>
		</div>
	</div>

    <div class="clearfix">
	    <label for="ccnumber">{$LANG.creditcardcardnumber}</label>
		<div class="input">
		    <input type="text" name="ccnumber" id="ccnumber" autocomplete="off" />
		</div>
	</div>

    <div class="clearfix">
	    <label for="ccexpirymonth">{$LANG.creditcardcardexpires}</label>
		<div class="input">
		    <select name="ccexpirymonth" id="ccexpirymonth">{foreach from=$months item=month}<option>{$month}</option>{/foreach}</select> / <select name="ccexpiryyear">{foreach from=$years item=year}<option>{$year}</option>{/foreach}</select>
		</div>
	</div>
{if $showccissuestart}
    <div class="clearfix">
	    <label for="ccstartmonth">{$LANG.creditcardcardstart}</label>
		<div class="input">
		    <input type="text" name="ccstartmonth" id="ccstartmonth" maxlength="2" class="small" style="width:30px;" /> / <input type="text" name="ccstartyear" id="ccstartyear" maxlength="2" class="small" style="width:30px;" /> (MM/YY)
		</div>
	</div>

    <div class="clearfix">
	    <label for="ccissuenum">{$LANG.creditcardcardissuenum}</label>
		<div class="input">
		    <input type="text" name="ccissuenum" id="ccissuenum" maxlength="3" class="small" />
		</div>
	</div>
{/if}

  </fieldset>

  <div class="actions">
    <input class="btn primary" type="submit" name="submit" value="{$LANG.clientareasavechanges}" />
    <input class="btn" type="reset" value="{$LANG.cancel}" />
  </div>

</form>

{/if}