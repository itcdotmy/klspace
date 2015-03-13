{include file="$template/pageheader.tpl" title=$LANG.clientareaproducts desc=$LANG.clientareaproductsintro}

<div class="searchbox">
    <form method="post" action="clientarea.php?action=products">
        <input type="text" name="q" value="{if $q}{$q}{else}{$LANG.searchenterdomain}{/if}" class="searchinput" onfocus="if(this.value=='{$LANG.searchenterdomain}')this.value=''" />
        <input type="submit" value="{$LANG.searchfilter}" class="btn success" />
    </form>
</div>

<br />

<p>{$numitems} {$LANG.recordsfound}, {$LANG.page} {$pagenumber} {$LANG.pageof} {$totalpages}</p>

<table class="zebra-striped">
    <thead>
        <tr>
            <th{if $orderby eq "product"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=products{if $q}&q={$q}{/if}&orderby=product">{$LANG.orderproduct}</a></th>
            <th{if $orderby eq "price"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=products{if $q}&q={$q}{/if}&orderby=price">{$LANG.orderprice}</a></th>
            <th{if $orderby eq "billingcycle"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=products{if $q}&q={$q}{/if}&orderby=billingcycle">{$LANG.orderbillingcycle}</a></th>
            <th{if $orderby eq "nextduedate"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=products{if $q}&q={$q}{/if}&orderby=nextduedate">{$LANG.clientareahostingnextduedate}</a></th>
            <th{if $orderby eq "status"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=products{if $q}&q={$q}{/if}&orderby=status">{$LANG.clientareastatus}</a></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
{foreach from=$services item=service}
        <tr>
            <td>{$service.group} - {$service.product}{if $service.domain}<br /><a href="http://{$service.domain}" target="_blank">{$service.domain}</a>{/if}</td>
            <td>{$service.amount}</td>
            <td>{$service.billingcycle}</td>
            <td>{$service.nextduedate}</td>
            <td><span class="label {$service.rawstatus}">{$service.statustext}</span></td>
            <td class="textcenter"><form method="post" action="{$smarty.server.PHP_SELF}?action=productdetails"><input type="hidden" name="id" value="{$service.id}" /><input type="submit" value="{$LANG.clientareaviewdetails}" class="btn info" /></form></td>
        </tr>
{foreachelse}
        <tr>
            <td colspan="6" class="textcenter">{$LANG.norecordsfound}</td>
        </tr>
{/foreach}
    </tbody>
</table>

<div class="recordslimit">
    <form method="post" action="{$smarty.server.PHP_SELF}?action={$clientareaaction}" />
    <select name="itemlimit" onchange="submit()">
        <option>{$LANG.resultsperpage}</option>
        <option value="10"{if $itemlimit==10} selected{/if}>10</option>
        <option value="25"{if $itemlimit==25} selected{/if}>25</option>
        <option value="50"{if $itemlimit==50} selected{/if}>50</option>
        <option value="100"{if $itemlimit==100} selected{/if}>100</option>
        <option value="all"{if $itemlimit==99999999} selected{/if}>{$LANG.clientareaunlimited}</option>
    </select>
    </form>
</div>

<div class="pagination">
    <ul>
        <li class="prev{if !$prevpage} disabled{/if}"><a href="{if $prevpage}clientarea.php?action=products{if $q}&q={$q}{/if}&amp;page={$prevpage}{else}javascript:return false;{/if}">&larr; {$LANG.previouspage}</a></li>
        <li class="next{if !$nextpage} disabled{/if}"><a href="{if $nextpage}clientarea.php?action=products{if $q}&q={$q}{/if}&amp;page={$nextpage}{else}javascript:return false;{/if}">{$LANG.nextpage} &rarr;</a></li>
    </ul>
</div>