{include file="$template/pageheader.tpl" title=$LANG.managing|cat:' '|cat:$domain}

{if $updatesuccess}
<div class="alert-message success">
    <p>{$LANG.changessavedsuccessfully}</p>
</div>
{elseif $registrarcustombuttonresult=="success"}
<div class="alert-message success">
    <p>{$LANG.moduleactionsuccess}</p>
</div>
{elseif $error}
<div class="alert-message error">
    <p>{$error}</p>
</div>
{elseif $registrarcustombuttonresult}
<div class="alert-message error">
    <p><strong>{$LANG.moduleactionfailed}:</strong> {$registrarcustombuttonresult}</p>
</div>
{elseif $lockstatus=="unlocked"}
<div class="alert-message error">
    <p><strong>{$LANG.domaincurrentlyunlocked}</strong> {$LANG.domaincurrentlyunlockedexp}</p>
</div>
{/if}

<div id="tabs">
    <ul class="tabs">
        <li class="active"><a href="#tab1">{$LANG.information}</a></li>
        <li><a href="#tab2">{$LANG.domainsautorenew}</a></li>
        {if $managens}<li><a href="#tab3">{$LANG.domainnameservers}</a></li>{/if}
        {if $lockstatus}{if $tld neq "co.uk" && $tld neq "org.uk" && $tld neq "ltd.uk" && $tld neq "plc.uk" && $tld neq "me.uk"}<li><a href="#tab4">{$LANG.domainregistrarlock}</a></li>{/if}{/if}
        {if $releasedomain}<li><a href="#tab5">{$LANG.domainrelease}</a></li>{/if}
        {if $managecontacts || $registerns || $dnsmanagement || $emailforwarding || $getepp}<li class="dropdown"><a href="#" class="dropdown-toggle">{$LANG.domainmanagementtools}</a>
            <ul class="dropdown-menu">
                {if $managecontacts}<li><a href="clientarea.php?action=domaincontacts&domainid={$domainid}">{$LANG.domaincontactinfo}</a></li>{/if}
                {if $registerns}<li><a href="clientarea.php?action=domainregisterns&domainid={$domainid}">{$LANG.domainregisterns}</a></li>{/if}
                {if $dnsmanagement}<li><a href="clientarea.php?action=domaindns&domainid={$domainid}">{$LANG.clientareadomainmanagedns}</a></li>{/if}
                {if $emailforwarding}<li><a href="clientarea.php?action=domainemailforwarding&domainid={$domainid}">{$LANG.clientareadomainmanageemailfwds}</a></li>{/if}
                {if $getepp}<li class="divider"></li>
                <li><a href="clientarea.php?action=domaingetepp&domainid={$domainid}">{$LANG.domaingeteppcode}</a></li>{/if}
                {if $registrarcustombuttons}<li class="divider"></li>
                {foreach from=$registrarcustombuttons key=label item=command}
                <li><a href="clientarea.php?action=domaindetails&amp;id={$domainid}&amp;modop=custom&amp;a={$command}">{$label}</a></li>
                {/foreach}{/if}
            </ul>
        </li>{/if}
    </ul>
</div>

<div id="tab1" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.information}</h2></div>
                <p>{$LANG.domaininfoexp}</p>
                <br />
                <p><input type="button" value="{$LANG.backtodomainslist}" class="btn" onclick="window.location='clientarea.php?action=domains'" /></p>
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">
                <p><h4><strong>{$LANG.clientareahostingdomain}:</strong></h4> {$domain} <span class="label {$rawstatus}">{$status}</span></p>
                <p><h4><strong>{$LANG.clientareahostingregdate}:</strong></h4> {$registrationdate}</p>
                <p><h4><strong>{$LANG.clientareahostingnextduedate}:</strong></h4> {$nextduedate}</p>
                <p><h4><strong>{$LANG.firstpaymentamount}:</strong></h4> {$firstpaymentamount}</p>
                <p><form method="post" action="cart.php?gid=renewals"><h4><strong>{$LANG.recurringamount}:</strong></h4> {$recurringamount} {$LANG.every} {$registrationperiod} {$LANG.orderyears}{if $renew} &nbsp;&nbsp; <input type="hidden" name="domainid" value="{$domainid}" /><input type="submit" value="{$LANG.domainsrenewnow}" class="btn" />{/if}</form></p>
                <p><h4><strong>{$LANG.orderpaymentmethod}:</strong></h4> {$paymentmethod}</p>
                {if $registrarclientarea}<div class="moduleoutput">{$registrarclientarea|replace:'modulebutton':'btn'}</div>{/if}
            </div>
        </div>

    </div>

</div>
<div id="tab2" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.domainsautorenew}</h2></div>
                <p>{$LANG.domainrenewexp}</p>
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">
                <p><h4><strong>{$LANG.domainautorenewstatus}:</strong></h4></p>
                <div class="internalpadding">
                    <p><strong>{if $autorenew}{$LANG.domainsautorenewenabled}{else}{$LANG.domainsautorenewdisabled}{/if}</strong></p>
                </div>
                <hr />
                <br />
                <div class="internalpadding">
                    <form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
                    <input type="hidden" name="id" value="{$domainid}" />
                    {if $autorenew}
                    <input type="hidden" name="autorenew" value="disable" />
                    <p><input type="submit" class="btn large danger" value="{$LANG.domainsautorenewdisable}" /></p>
                    {else}
                    <input type="hidden" name="autorenew" value="enable" />
                    <p><input type="submit" class="btn large success" value="{$LANG.domainsautorenewenable}" /></p>
                    {/if}
                    </form>
                </div>
                <br />
                <br />
                <br />
                <br />
            </div>
        </div>

    </div>

</div>
<div id="tab3" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.domainnameservers}</h2></div>
                <p>{$LANG.domainnsexp}</p>
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">
                <form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails" class="form-stacked">
                <input type="hidden" name="id" value="{$domainid}" />
                <input type="hidden" name="sub" value="savens" />
                <p><label class="full"><input type="radio" name="nschoice" value="default" onclick="disableFields('domnsinputs',true)"{if $defaultns} checked{/if} /> {$LANG.nschoicedefault}</label><br />
                <label class="full"><input type="radio" name="nschoice" value="custom" onclick="disableFields('domnsinputs','')"{if !$defaultns} checked{/if} /> {$LANG.nschoicecustom}</label></p>
                <fieldset>
                    <div class="clearfix">
                        <label for="ns1">{$LANG.domainnameserver1}</label>
                        <div class="input">
                            <input class="xlarge domnsinputs" id="ns1" name="ns1" type="text" value="{$ns1}" />
                        </div>
                    </div>
                    <div class="clearfix">
                        <label for="ns2">{$LANG.domainnameserver2}</label>
                        <div class="input">
                            <input class="xlarge domnsinputs" id="ns2" name="ns2" type="text" value="{$ns2}" />
                        </div>
                    </div>
                    <div class="clearfix">
                        <label for="ns3">{$LANG.domainnameserver3}</label>
                        <div class="input">
                            <input class="xlarge domnsinputs" id="ns3" name="ns3" type="text" value="{$ns3}" />
                        </div>
                    </div>
                    <div class="clearfix">
                        <label for="ns4">{$LANG.domainnameserver4}</label>
                        <div class="input">
                            <input class="xlarge domnsinputs" id="ns4" name="ns4" type="text" value="{$ns4}" />
                        </div>
                    </div>
                    <div class="clearfix">
                        <label for="ns5">{$LANG.domainnameserver5}</label>
                        <div class="input">
                            <input class="xlarge domnsinputs" id="ns5" name="ns5" type="text" value="{$ns5}" />
                        </div>
                    </div>
                    <div class="internalpadding">
                        <p><input type="submit" class="btn large primary" value="{$LANG.changenameservers}" /></p>
                    </div>
                </fieldset>
                </form>

            </div>
        </div>

    </div>

</div>
<div id="tab4" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.domainregistrarlock}</h2></div>
                <p>{$LANG.domainlockingexp}</p>
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">
                <p><h4><strong>{$LANG.domainreglockstatus}:</strong></h4></p>
                <p><strong>{if $lockstatus=="locked"}{$LANG.domainsautorenewenabled}{else}{$LANG.domainsautorenewdisabled}{/if}</strong></p>
                <hr />
                <div class="internalpadding">
                    <form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
                    <input type="hidden" name="id" value="{$domainid}" />
                    <input type="hidden" name="sub" value="savereglock" />
                    {if $lockstatus=="locked"}
                    <p><input type="submit" class="btn danger" value="{$LANG.domainreglockdisable}" /></p>
                    {else}
                    <p><input type="submit" name="reglock" class="btn success" value="{$LANG.domainreglockenable}" /></p>
                    {/if}
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
<div id="tab5" class="tab_content">

    <div class="row">

        <div class="col30">
            <div class="internalpadding">
                <div class="styled_title"><h2>{$LANG.domainrelease}</h2></div>
                <p>Lock your domain to prevent it from being transferred away without your authorization.</p>
            </div>
        </div>
        <div class="col70">
            <div class="internalpadding">
                {if $releasedomain}
                <p><strong>&nbsp;&raquo;&nbsp;&nbsp;{$LANG.domainrelease}</strong></p>
                <form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
                <input type="hidden" name="sub" value="releasedomain">
                <input type="hidden" name="id" value="{$domainid}">
                <table cellspacing="1" cellpadding="0" class="frame"><tr><td>
                <table width="100%" cellpadding="2">
                <tr><td class="fieldarea" width="150">{$LANG.domainreleasetag}:</td><td><input type="text" name="transtag" size="20" /> {$LANG.domainreleasedescription}</td></tr>
                </table>
                </td></tr></table>
                <p align="center"><input type="submit" value="{$LANG.domainrelease}" class="buttonwarn" /></p>
                </form>
                {/if}
            </div>
        </div>

    </div>

</div>