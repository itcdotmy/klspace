{include file="$template/pageheader.tpl" title=$LANG.clientareanavdomains desc=$LANG.clientareadomainsintro}

<div class="searchbox">
    <form method="post" action="clientarea.php?action=domains">
        <input type="text" name="q" value="{if $q}{$q}{else}{$LANG.searchenterdomain}{/if}" class="searchinput" onfocus="if(this.value=='{$LANG.searchenterdomain}')this.value=''" />
        <input type="submit" value="{$LANG.searchfilter}" class="btn success" />
    </form>
</div>

<br />

<p>{$numitems} {$LANG.recordsfound}, {$LANG.page} {$pagenumber} {$LANG.pageof} {$totalpages}</p>

<form method="post" action="clientarea.php?action=bulkdomain">

<table class="zebra-striped">
    <thead>
        <tr>
            <th class="textcenter"><input type="checkbox" onclick="toggleCheckboxes('domids')" /></th>
            <th{if $orderby eq "domain"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=domains{if $q}&q={$q}{/if}&orderby=domain">{$LANG.clientareahostingdomain}</a></th>
            <th{if $orderby eq "regdate"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=domains{if $q}&q={$q}{/if}&orderby=regdate">{$LANG.clientareahostingregdate}</a></th>
            <th{if $orderby eq "nextduedate"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=domains{if $q}&q={$q}{/if}&orderby=nextduedate">{$LANG.clientareahostingnextduedate}</a></th>
            <th{if $orderby eq "status"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=domains{if $q}&q={$q}{/if}&orderby=status">{$LANG.clientareastatus}</a></th>
            <th{if $orderby eq "autorenew"} class="headerSort{$sort}"{/if}><a href="clientarea.php?action=domains{if $q}&q={$q}{/if}&orderby=autorenew">{$LANG.domainsautorenew}</a></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
{foreach key=num item=domain from=$domains}
        <tr>
            <td class="textcenter"><input type="checkbox" name="domids[]" class="domids" value="{$domain.id}" /></td>
            <td><a href="http://{$domain.domain}/" target="_blank">{$domain.domain}</a></td>
            <td>{$domain.registrationdate}</td>
            <td>{$domain.nextduedate}</td>
            <td><span class="label {$domain.rawstatus}">{$domain.statustext}</span></td>
            <td>{if $domain.autorenew}{$LANG.domainsautorenewenabled}{else}{$LANG.domainsautorenewdisabled}{/if}</td>
            <td class="textcenter"><input type="button" class="btn info" value="{$LANG.managedomain}" onclick="window.location='clientarea.php?action=domaindetails&id={$domain.id}'" /></td>
        </tr>
{foreachelse}
        <tr>
            <td colspan="7" class="textcenter">{$LANG.norecordsfound}</td>
        </tr>
{/foreach}
    </tbody>
</table>

<div class="recordslimit">
    <select id="itemlimit" onchange="limitchange()">
        <option>{$LANG.resultsperpage}</option>
        <option value="10"{if $itemlimit==10} selected{/if}>10</option>
        <option value="25"{if $itemlimit==25} selected{/if}>25</option>
        <option value="50"{if $itemlimit==50} selected{/if}>50</option>
        <option value="100"{if $itemlimit==100} selected{/if}>100</option>
        <option value="all"{if $itemlimit==99999999} selected{/if}>{$LANG.clientareaunlimited}</option>
    </select>
</div>

<div class="pagination">
    <ul>
        <li class="prev{if !$prevpage} disabled{/if}"><a href="{if $prevpage}clientarea.php?action=domains{if $q}&q={$q}{/if}&amp;page={$prevpage}{else}javascript:return false;{/if}">&larr; {$LANG.previouspage}</a></li>
        <li class="next{if !$nextpage} disabled{/if}"><a href="{if $nextpage}clientarea.php?action=domains{if $q}&q={$q}{/if}&amp;page={$nextpage}{else}javascript:return false;{/if}">{$LANG.nextpage} &rarr;</a></li>
    </ul>
</div>

<h3>{$LANG.domainbulkmanagement}</h3>
<p>
{$LANG.withselected}:
<input type="submit" name="nameservers" value="{$LANG.domainmanagens}" class="btn" />
<input type="submit" name="autorenew" value="{$LANG.domainautorenewstatus}" class="btn" />
<input type="submit" name="reglock" value="{$LANG.domainreglockstatus}" class="btn" />
<input type="submit" name="contactinfo" value="{$LANG.domaincontactinfoedit}" class="btn" />
<input type="submit" name="renew" value="{$LANG.domainmassrenew}" class="btn" />
</p>

</form>

<form method="post" action="{$smarty.server.PHP_SELF}?action={$clientareaaction}" id="itemlimfrm" />
<input type="hidden" name="itemlimit" id="itemlim" />
</form>

<br />
<br />