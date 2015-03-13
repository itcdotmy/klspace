<script type="text/javascript" src="includes/jscript/statesdropdown.js"></script>

{include file="$template/pageheader.tpl" title=$LANG.creditcard}

<form method="post" action="creditcard.php">
<input type="hidden" name="action" value="submit">
<input type="hidden" name="invoiceid" value="{$invoiceid}">

<div class="alert-message block-message warn">
    <p class="textcenter"><strong>Paying Invoice #{$invoiceid}</strong> - Balance Due: <strong>{$balance}</strong></p>
</div>

{if $errormessage}
    <div class="alert-message error">
        <p class="bold">{$LANG.clientareaerrors}</p>
        <ul>
            {$errormessage}
        </ul>
    </div>
{/if}

<fieldset>

<div class="clearfix">
    <div class="col2half">
        <div class="internalpadding">

        	{include file="$template/subheader.tpl" title=$LANG.creditcardyourinfo}

            <div class="clearfix">
        	    <label for="firstname">{$LANG.clientareafirstname}</label>
        		<div class="input">
        		    <input type="text" name="firstname" id="firstname" value="{$firstname}"{if in_array('firstname',$uneditablefields)} disabled="" class="disabled"{/if} />
        		</div>
        	</div>

            <div class="clearfix">
        	    <label for="lastname">{$LANG.clientarealastname}</label>
        		<div class="input">
        		    <input type="text" name="lastname" id="lastname" value="{$lastname}"{if in_array('lastname',$uneditablefields)} disabled="" class="disabled"{/if} />
        		</div>
        	</div>

            <div class="clearfix">
        	    <label for="address1">{$LANG.clientareaaddress1}</label>
        		<div class="input">
        		    <input type="text" name="address1" id="address1" value="{$address1}"{if in_array('address1',$uneditablefields)} disabled="" class="disabled"{/if} />
        		</div>
        	</div>

            <div class="clearfix">
        	    <label for="address2">{$LANG.clientareaaddress2}</label>
        		<div class="input">
        		    <input type="text" name="address2" id="address2" value="{$address2}"{if in_array('address2',$uneditablefields)} disabled="" class="disabled"{/if} />
        		</div>
        	</div>

            <div class="clearfix">
        	    <label for="city">{$LANG.clientareacity}</label>
        		<div class="input">
        		    <input type="text" name="city" id="city" value="{$city}"{if in_array('city',$uneditablefields)} disabled="" class="disabled"{/if} />
        		</div>
        	</div>

            <div class="clearfix">
        	    <label for="state">{$LANG.clientareastate}</label>
        		<div class="input">
        		    <input type="text" name="state" id="state" value="{$state}"{if in_array('state',$uneditablefields)} disabled="" class="disabled"{/if} />
        		</div>
        	</div>

            <div class="clearfix">
        	    <label for="postcode">{$LANG.clientareapostcode}</label>
        		<div class="input">
        		    <input type="text" name="postcode" id="postcode" value="{$postcode}"{if in_array('postcode',$uneditablefields)} disabled="" class="disabled"{/if} />
        		</div>
        	</div>

            <div class="clearfix">
        	    <label for="country">{$LANG.clientareacountry}</label>
        		<div class="input">
        		    {$countriesdropdown}
        		</div>
        	</div>


            <div class="clearfix">
        	    <label for="phonenumber">{$LANG.clientareaphonenumber}</label>
        		<div class="input">
        		    <input type="text" name="phonenumber" id="phonenumber" value="{$phonenumber}"{if in_array('phonenumber',$uneditablefields)} disabled="" class="disabled"{/if} />
        		</div>
        	</div>

        </div>
    </div>
    <div class="col2half">
        <div class="internalpadding">

            {include file="$template/subheader.tpl" title=$LANG.creditcarddetails}

            <p><label class="full"><input type="radio" name="ccinfo" value="useexisting" onclick="disableFields('newccinfo',true)"{if $cardnum} checked{else} disabled{/if} /> {$LANG.creditcarduseexisting}{if $cardnum} ({$cardnum}){/if}</label></p>
{if $cardnum}
            <br />

            <div class="clearfix">
                <label for="cccvv2">{$LANG.creditcardcvvnumber}</label>
        		<div class="input"><input type="text" name="cccvv2" id="cccvv2" size="5" value="{$cccvv}" autocomplete="off" class="small" />&nbsp;<a href="#" onclick="window.open('images/ccv.gif','','width=280,height=200,scrollbars=no,top=100,left=100');return false">{$LANG.creditcardcvvwhere}</a></div>
        	</div>
{/if}
            <p><label class="full"><input type="radio" name="ccinfo" value="new" onclick="disableFields('newccinfo',false)"{if !$cardnum || $ccinfo eq "new"} checked{/if} /> {$LANG.creditcardenternewcard}</label></p>

            <br />
            <br />

            <div class="clearfix">
                <label for="cctype">{$LANG.creditcardcardtype}</label>
                <div class="input">
                	<select name="cctype" id="cctype" class="newccinfo">
                    {foreach from=$acceptedcctypes item=cardtype}
                        <option{if $cctype eq $cardtype} selected{/if}>{$cardtype}</option>
                    {/foreach}
                    </select>
        		</div>
            </div>

            <div class="clearfix">
                <label for="ccnumber">{$LANG.creditcardcardnumber}</label>
        		<div class="input"><input type="text" name="ccnumber" id="ccnumber" size="30" value="{$ccnumber}" autocomplete="off" class="newccinfo" /></div>
        	</div>

            <div class="clearfix">
                <label for="ccexpirymonth">{$LANG.creditcardcardexpires}</label>
        		<div class="input"><select name="ccexpirymonth" id="ccexpirymonth" class="newccinfo">{foreach from=$months item=month}<option>{$month}</option>{/foreach}</select> / <select name="ccexpiryyear" class="newccinfo">{foreach from=$years item=year}<option>{$year}</option>{/foreach}</select></div>
        	</div>

           {if $showccissuestart}
            <div class="clearfix">
                <label for="ccstartmonth">{$LANG.creditcardcardstart}</label>
        		<div class="input"><input type="text" name="ccstartmonth" id="ccstartmonth" maxlength="2" class="newccinfo" style="width:30px;" /> / <input type="text" name="ccstartyear" id="ccstartyear" maxlength="2" class="newccinfo" style="width:30px;" /> (MM/YY)</div>
        	</div>

            <div class="clearfix">
                <label for="ccissuenum">{$LANG.creditcardcardissuenum}</label>
        		<div class="input"><input type="text" name="ccissuenum" id="ccissuenum" size="5" maxlength="3" value="{$ccissuenum}" class="small newccinfo" /></div>
        	</div>
            {/if}

            <div class="clearfix">
                <label for="cccvv">{$LANG.creditcardcvvnumber}</label>
        		<div class="input"><input type="text" name="cccvv" id="cccvv" size="5" value="{$cccvv}" autocomplete="off" class="small newccinfo" />&nbsp;<a href="#" onclick="window.open('images/ccv.gif','','width=280,height=200,scrollbars=no,top=100,left=100');return false">{$LANG.creditcardcvvwhere}</a></div>
        	</div>

        	{if $shownostore}
            <p><label class="full"><input type="checkbox" name="nostore" id="nostore" class="newccinfo" /> {$LANG.creditcardnostore}</label></p>
        	{/if}

            <br />
            <br />

            <p class="textcenter"><input class="btn large primary" type="submit" value="{$LANG.ordercontinuebutton}" onclick="this.value='{$LANG.pleasewait}'" /></p>

        </div>
    </div>
</div>

<p align="center"><img src="images/padlock.gif" alt="Secure" /> {$LANG.creditcardsecuritynotice}</p>

</fieldset>

{if !$cardnum || $ccinfo eq "new"}{else}
<script> disableFields('newccinfo',true); </script>
{/if}

</form>