{include file="$template/pageheader.tpl" title=$LANG.clientareanavsupporttickets desc=$LANG.supportticketsintro}

<div class="searchbox">
    <form method="get" action="supporttickets.php">
        <input type="text" name="searchterm" value="{if $searchterm}{$searchterm}{else}{$LANG.searchtickets}{/if}" onfocus="if(this.value=='{$LANG.searchtickets}')this.value=''" onblur="if(this.value=='')this.value='{$LANG.searchtickets}'" />
        <input type="submit" value="{$LANG.search}" class="btn success" />
    </form>
</div>

<div class="internalpadding"><input type="button" value="{$LANG.opennewticket}" class="btn" onclick="window.location='submitticket.php'" /></div>

<p>{$numtickets} {$LANG.recordsfound}, {$LANG.page} {$pagenumber} {$LANG.pageof} {$totalpages}</p>

<table class="zebra-striped">
    <thead>
        <tr>
            <th{if $orderby eq "date"} class="headerSort{$sort}"{/if}><a href="supporttickets.php?orderby=date">{$LANG.supportticketsdate}</a></th>
            <th{if $orderby eq "dept"} class="headerSort{$sort}"{/if}><a href="supporttickets.php?orderby=dept">{$LANG.supportticketsdepartment}</a></th>
            <th{if $orderby eq "subject"} class="headerSort{$sort}"{/if}><a href="supporttickets.php?orderby=subject">{$LANG.supportticketssubject}</a></th>
            <th{if $orderby eq "status"} class="headerSort{$sort}"{/if}><a href="supporttickets.php?orderby=status">{$LANG.supportticketsstatus}</a></th>
            <th{if $orderby eq "lastreply"} class="headerSort{$sort}"{/if}><a href="supporttickets.php?orderby=lastreply">{$LANG.supportticketsticketlastupdated}</a></th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
{foreach key=num item=ticket from=$tickets}
        <tr>
            <td>{$ticket.date}</td>
            <td>{$ticket.department}</td>
            <td><a href="viewticket.php?tid={$ticket.tid}&amp;c={$ticket.c}">{if $ticket.unread}<strong>{/if}#{$ticket.tid} - {$ticket.subject}{if $ticket.unread}</strong>{/if}</a></td>
            <td>{$ticket.status}</td>
            <td>{$ticket.lastreply}</td>
            <td class="textcenter"><form method="get" action="viewticket.php"><input type="hidden" name="tid" value="{$ticket.tid}" /><input type="hidden" name="c" value="{$ticket.c}" /><input type="submit" value="{$LANG.supportticketsviewticket}" class="btn info" /></form></td>
        </tr>
{foreachelse}
        <tr>
            <td colspan="7" class="textcenter">{$LANG.norecordsfound}</td>
        </tr>
{/foreach}
    </tbody>
</table>

<div class="recordslimit">
    <form method="post" action="{$smarty.server.PHP_SELF}" />
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
        <li class="prev{if !$prevpage} disabled{/if}"><a href="{if $prevpage}supporttickets.php?page={$prevpage}{else}javascript:return false;{/if}">&larr; {$LANG.previouspage}</a></li>
        <li class="next{if !$nextpage} disabled{/if}"><a href="{if $nextpage}supporttickets.php?page={$nextpage}{else}javascript:return false;{/if}">{$LANG.nextpage} &rarr;</a></li>
    </ul>
</div>