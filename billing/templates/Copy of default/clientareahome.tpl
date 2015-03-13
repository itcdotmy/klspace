<div class="row">

    <div class="col60">
        <div class="internalpadding">

            <div class="page-header">
                <div class="styled_title">
                    <h2>{$LANG.accountinfo} &nbsp;&nbsp;&nbsp;<small><a href="clientarea.php?action=details">{$LANG.clientareaupdateyourdetails}</a></small></h2>
                </div>
            </div>
            <p><strong>{$clientsdetails.firstname} {$clientsdetails.lastname} {if $clientsdetails.companyname}({$clientsdetails.companyname}){/if}</strong></p>
            <p>{$clientsdetails.address1}{if $clientsdetails.address2}, {$clientsdetails.address2}{/if}</p>
            <p>{if $clientsdetails.city}{$clientsdetails.city}, {/if}{if $clientsdetails.state}{$clientsdetails.state}, {/if}{$clientsdetails.postcode}</p>
            <p>{$clientsdetails.countryname}</p>
            <p><a href="mailto:{$clientsdetails.email}">{$clientsdetails.email}</a></p>

        </div>
    </div>
    <div class="col40">
        <div class="internalpadding">

            <div class="page-header">
                <div class="styled_title">
                    <h2>{$LANG.accountoverview}</h2>
                </div>
            </div>

            <p>{$LANG.statsnumproducts}: <a href="clientarea.php?action=products"><strong>{$clientsstats.productsnumactive}</strong> ({$clientsstats.productsnumtotal}) - {$LANG.view} &raquo;</a></p>
            <p>{$LANG.statsnumdomains}: <a href="clientarea.php?action=domains"><strong>{$clientsstats.numactivedomains}</strong> ({$clientsstats.numdomains}) - {$LANG.view} &raquo;</a></p>
            <p>{$LANG.statsnumtickets}: <a href="supporttickets.php"><strong>{$clientsstats.numtickets}</strong> - {$LANG.view} &raquo;</a></p>
            <p>{$LANG.statsnumreferredsignups}: <a href="affiliates.php"><strong>{$clientsstats.numaffiliatesignups}</strong> - {$LANG.view} &raquo;</a></p>
            <p>{$LANG.creditcardyourinfo}: <strong>{if $defaultpaymentmethod}{$defaultpaymentmethod}{else}{$LANG.paymentmethoddefault}{/if}</strong> {if $clientsdetails.cctype}({$clientsdetails.cctype}-{$clientsdetails.cclastfour}) - <a href="clientarea.php?action=creditcard">Update &raquo;</a></p>{/if}

        </div>
    </div>
</div>

{if $announcements}
<div class="alert-message warning">
    <p><strong>{$LANG.ourlatestnews}:</strong> {$announcements.0.text|truncate:100:'...'} - <a href="announcements.php?id={$announcements.0.id}">{$LANG.more}...</a></p>
</div>
{/if}
{if $ccexpiringsoon}
<div class="alert-message error">
    <p><strong>{$LANG.ccexpiringsoon}:</strong> {$LANG.ccexpiringsoondesc|sprintf2:'<a href="clientarea.php?action=creditcard">':'</a>'}</p>
</div>
{/if}
{if $clientsstats.incredit}
<div class="alert-message success">
    <p><strong>{$LANG.availcreditbal}:</strong> {$LANG.availcreditbaldesc|sprintf2:$clientsstats.creditbalance}</p>
</div>
{/if}
{if $clientsstats.numoverdueinvoices>0}
<div class="alert-message block-message error">
    <p><strong>{$LANG.youhaveoverdueinvoices|sprintf2:$clientsstats.numoverdueinvoices}:</strong> {$LANG.overdueinvoicesdesc|sprintf2:'<a href="clientarea.php?action=masspay&all=true">':'</a>'}</p>
</div>
{/if}

<form method="post" action="domainchecker.php">
<div class="well textcenter">
    <div class="styled_title">
        <h3>{$LANG.domaincheckerchecknewdomain}</h3>
    </div>
    <input class="bigfield" name="domain" type="text" value="{$LANG.domaincheckerdomainexample}" onfocus="if(this.value=='{$LANG.domaincheckerdomainexample}')this.value=''" onblur="if(this.value=='')this.value='{$LANG.domaincheckerdomainexample}'" />
    <div class="internalpadding">
        <input type="submit" value="{$LANG.checkavailability}" class="btn primary large" />
        <input type="submit" name="transfer" value="{$LANG.domainstransfer}" class="btn success large" />
        <input type="submit" name="hosting" value="{$LANG.domaincheckerhostingonly}" class="btn large" />
    </div>
</div>
</form>

{foreach from=$addons_html item=addon_html}
<div style="margin:15px 0;">{$addon_html}</div>
{/foreach}

{if in_array('tickets',$contactpermissions)}

<div class="styled_title">
    <h3>{$clientsstats.numactivetickets} {$LANG.supportticketsopentickets} &nbsp;&nbsp;&nbsp;<small><a href="submitticket.php">{$LANG.opennewticket}</a></small></h3>
</div>

<table class="zebra-striped">
    <thead>
        <tr>
            <th><a href="supporttickets.php?orderby=date">{$LANG.supportticketsdate}</a></th>
            <th><a href="supporttickets.php?orderby=dept">{$LANG.supportticketsdepartment}</a></th>
            <th><a href="supporttickets.php?orderby=subject">{$LANG.supportticketssubject}</a></th>
            <th><a href="supporttickets.php?orderby=status">{$LANG.supportticketsstatus}</a></th>
            <th class="headerSortdesc"><a href="supporttickets.php?orderby=lastreply">{$LANG.supportticketsticketlastupdated}</a></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
{foreach from=$tickets item=ticket}
    <tr>
        <td>{$ticket.date}</td>
        <td>{$ticket.department}</td>
        <td><img src="images/article.gif" alt="Ticket" />&nbsp;<a href="viewticket.php?tid={$ticket.tid}&amp;c={$ticket.c}">{if $ticket.unread}<strong>{/if}#{$ticket.tid} - {$ticket.subject}{if $ticket.unread}</strong>{/if}</a></td>
        <td>{$ticket.status}</td>
        <td>{$ticket.lastreply}</td>
            <td class="textcenter"><form method="get" action="viewticket.php"><input type="hidden" name="tid" value="{$ticket.tid}" /><input type="hidden" name="c" value="{$ticket.c}" /><input type="submit" value="{$LANG.supportticketsviewticket}" class="btn info" /></form></td>
    </tr>
{foreachelse}
    <tr>
        <td colspan="6" class="textcenter">{$LANG.supportticketsnoneopen}</td>
    </tr>
{/foreach}
    </tbody>
</table>

{/if}

{if in_array('invoices',$contactpermissions)}

<div class="styled_title">
    <h3>{$clientsstats.numdueinvoices} {$LANG.invoicesdue}</h3>
</div>

<form method="post" action="clientarea.php?action=masspay">

<table class="zebra-striped">
    <thead>
        <tr>
            {if $masspay}<th class="textcenter"><input type="checkbox" onclick="toggleCheckboxes('invids')" /></th>{/if}
            <th class="headerSortdesc"><a href="clientarea.php?action=invoices&orderby=id">{$LANG.invoicestitle}</a></th>
            <th{if $orderby eq "date"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=invoices&orderby=date">{$LANG.invoicesdatecreated}</a></th>
            <th{if $orderby eq "duedate"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=invoices&orderby=duedate">{$LANG.invoicesdatedue}</a></th>
            <th{if $orderby eq "total"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=invoices&orderby=total">{$LANG.invoicestotal}</a></th>
            <th{if $orderby eq "status"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=invoices&orderby=status">{$LANG.invoicesstatus}</a></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
{foreach from=$invoices item=invoice}
        <tr>
            {if $masspay}<td class="textcenter"><input type="checkbox" name="invoiceids[]" value="{$invoice.id}" class="invids" /></td>{/if}
            <td><a href="viewinvoice.php?id={$invoice.id}" target="_blank">{$invoice.invoicenum}</a></td>
            <td>{$invoice.datecreated}</td>
            <td>{$invoice.datedue}</td>
            <td>{$invoice.total}</td>
            <td><span class="label {$invoice.rawstatus}">{$invoice.statustext}</span></td>
            <td class="textcenter"><input type="button" class="btn info" value="{$LANG.invoicesview}" onclick="window.open('viewinvoice.php?id={$invoice.id}')" /></td>
        </tr>
{foreachelse}
        <tr>
            <td colspan="{if $masspay}7{else}6{/if}" class="textcenter">{$LANG.invoicesnoneunpaid}</td>
        </tr>
{/foreach}
{if $invoices}
        <tr>
            <td colspan="{if $masspay}3{else}2{/if}">{if $masspay}<input type="submit" value="{$LANG.masspayselected}" class="btn" /> <input type="button" value="{$LANG.masspayall}" onclick="window.location='clientarea.php?action=masspay&all=true'" class="btn primary" />{/if}</td>
            <td class="textright"><strong>{$LANG.invoicestotaldue}</strong></td>
            <td><strong>{$totalbalance}</strong></td>
            <td colspan="2">&nbsp;</td>
        </tr>
{/if}
    </tbody>
</table>

</form>

{/if}

{if $files}

<div class="styled_title">
    <h3>{$LANG.clientareafiles}</h3>
</div>

<div class="row">
<div class="clearfix">
{foreach from=$files item=file}
    <div class="col4">
        <div class="internalpadding">
            <img src="images/file.png" /> <a href="dl.php?type=f&id={$file.id}" class="fontsize2"><strong>{$file.title}</strong></a><br />
            {$LANG.clientareafilesdate}: {$file.date}
        </div>
    </div>
{/foreach}
</div>
</div>

{/if}