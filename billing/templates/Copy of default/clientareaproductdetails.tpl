{include file="$template/pageheader.tpl" title=$product}

{if $modulechangepwresult eq "success"}
<div class="alert-message success">
    <p>{$LANG.serverchangepasswordsuccessful}</p>
</div>
{elseif $modulechangepwresult eq "error"}
<div class="alert-message error">
    <p>{$modulechangepasswordmessage}</p>
</div>
{elseif $modulecustombuttonresult=="success"}
<div class="alert-message success">
    <p>{$LANG.moduleactionsuccess}</p>
</div>
{elseif $modulecustombuttonresult}
<div class="alert-message error">
    <p><strong>{$LANG.moduleactionfailed}:</strong> {$modulecustombuttonresult}</p>
</div>
{/if}

<div id="tabs">
    <ul class="tabs">
        <li class="active"><a href="#tab1">{$LANG.information}</a></li>
        {if $modulechangepassword}<li><a href="#tab2">{$LANG.serverchangepassword}</a></li>{/if}
        {if $downloads}<li><a href="#tab3">{$LANG.downloadstitle}</a></li>{/if}
        <li><a href="#tab4">{$LANG.clientareahostingaddons}</a></li>
        {if $packagesupgrade || $configoptionsupgrade || $showcancelbutton || $modulecustombuttons}<li class="dropdown"><a href="#" class="dropdown-toggle">{$LANG.productmanagementactions}</a>
            <ul class="dropdown-menu">
                {foreach from=$modulecustombuttons key=label item=command}
                <li><a href="clientarea.php?action=productdetails&amp;id={$id}&amp;modop=custom&amp;a={$command}">{$label}</a></li>
                {/foreach}
                {if $packagesupgrade}<li><a href="upgrade.php?type=package&amp;id={$id}">{$LANG.upgradedowngradepackage}</a></li>{/if}
                {if $configoptionsupgrade}<li><a href="upgrade.php?type=configoptions&amp;id={$id}">{$LANG.upgradedowngradeconfigoptions}</a></li>{/if}
                {if $showcancelbutton}<li><a href="clientarea.php?action=cancel&amp;id={$id}">{$LANG.clientareacancelrequestbutton}</a></li>{/if}
            </ul>
        </li>{/if}
    </ul>
</div>

<div id="tab1" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.information}</h2></div>
                <p>{$LANG.clientareaproductdetailsintro}</p>
                <br />
                <p><input type="button" value="{$LANG.backtoserviceslist}" class="btn" onclick="window.location='clientarea.php?action=products'" /></p>
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">
                <p><h4>{$LANG.orderproduct}:</h4> {$groupname} - {$product} <span class="label {$rawstatus}">{$status}</span>{if $domain}<div><a href="http://{$domain}" target="_blank">{$domain}</a></div>{/if}</p>
                {if $dedicatedip}
                <div class="col2half">
                    <p><h4>{$LANG.domainregisternsip}:</h4> {$dedicatedip}</p>
                </div>
                <div class="clear"></div>
                {/if}
                <div class="col2half">
                    <p><h4>{$LANG.firstpaymentamount}:</h4> {$firstpaymentamount}</p>
                </div>
                <div class="col2half">
                    <p><h4>{$LANG.clientareahostingregdate}:</h4> {$regdate}</p>
                </div>
                <div class="col2half">
                    <p><h4>{$LANG.recurringamount}:</h4> {$recurringamount}</p>
                </div>
                <div class="col2half">
                    <p><h4>{$LANG.clientareahostingnextduedate}:</h4> {$nextduedate}</p>
                </div>
                <div class="col2half">
                    <p><h4>{$LANG.orderbillingcycle}:</h4> {$billingcycle}</p>
                </div>
                <div class="col2half">
                    <p><h4>{$LANG.orderpaymentmethod}:</h4> {$paymentmethod}</p>
                </div>
                <div class="clear"></div>
                {if $suspendreason}<p><h4>{$LANG.suspendreason}:</h4> {$suspendreason}</p>{/if}
                {if $lastupdate}
                <div class="col2half">
                    <p><h4>{$LANG.clientareadiskusage}:</h4> {$diskusage}MB / {$disklimit}MB ({$diskpercent})</p>
                    <div class="usagecontainer"><div class="used" style="width:{$diskpercent}"></div></div>
                </div>
                <div class="col2half">
                    <p><h4>{$LANG.clientareabwusage}:</h4> {$bwusage}MB / {$bwlimit}MB ({$bwpercent})</p>
                    <div class="usagecontainer"><div class="used" style="width:{$bwpercent}"></div></div>
                </div>
                <div class="clear"></div>
                {/if}
                {foreach from=$configurableoptions item=configoption}
                <div class="col2half">
                    <p><h4>{$configoption.optionname}:</h4> {if $configoption.optiontype eq 3}{if $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.optiontype eq 4}{$configoption.selectedqty} x {$configoption.selectedoption}{else}{$configoption.selectedoption}{/if}</p>
                </div>
                {/foreach}
                {foreach from=$productcustomfields item=customfield}
                <div class="col2half">
                    <p><h4>{$customfield.name}:</h4> {$customfield.value}</p>
                </div>
                {/foreach}
                <div class="clear"></div>
                {if $moduleclientarea}<div class="moduleoutput">{$moduleclientarea|replace:'modulebutton':'btn'}</div>{/if}
            </div>
        </div>

    </div>

</div>
<div id="tab2" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.serverchangepassword}</h2></div>
                <p>{$LANG.serverchangepasswordintro}</p>
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">

                <form method="post" action="{$smarty.server.PHP_SELF}?action=productdetails">
                <input type="hidden" name="id" value="{$id}" />
                <input type="hidden" name="modulechangepassword" value="true" />

                  <fieldset class="onecol">

                    {if $username}<div class="clearfix">
                	    <label for="password">{$LANG.serverusername}/{$LANG.serverpassword}</label>
                		<div class="input">
                		    {$username}{if $password} / {$password}{/if}
                		</div>
                	</div>{/if}

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

            </div>
        </div>

    </div>

</div>
<div id="tab3" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.downloadstitle}</h2></div>
                <p>There are the following downloads associated with this product</p>
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">
                {foreach from=$downloads item=download}
                <p><h4>{$download.title} - <a href="{$download.link}">{$LANG.downloadname}</a></h4> {$download.description}</p>
                {/foreach}
            </div>
        </div>

    </div>

</div>
<div id="tab4" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.clientareahostingaddons}</h2></div>
                <p>{$LANG.clientareahostingaddonsintro}</p>
                <br />
                {if $addonsavailable}<p><a href="cart.php?gid=addons&pid={$id}">{$LANG.orderavailableaddons}</a></p>{/if}
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">
                <table>
                    <thead>
                        <tr>
                            <th>{$LANG.clientareaaddon}</th>
                            <th>{$LANG.clientareaaddonpricing}</th>
                            <th>{$LANG.clientareahostingnextduedate}</th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach key=num item=addon from=$addons}
                        <tr>
                            <td>{$addon.name}</td>
                            <td class="textcenter">{$addon.pricing}</td>
                            <td class="textcenter">{$addon.nextduedate}</td>
                        </tr>
                    {foreachelse}
                        <tr>
                            <td class="textcenter" colspan="3">{$LANG.clientareanoaddons}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>