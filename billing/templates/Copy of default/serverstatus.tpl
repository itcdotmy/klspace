{include file="$template/pageheader.tpl" title=$LANG.networkstatustitle desc=$LANG.networkstatusintro}

<div class="alert-message block-message warning">
<p class="textcenter fontsize3">
<a href="{$smarty.server.PHP_SELF}?view=open" class="networkissuesopen">{$opencount} {$LANG.networkissuesstatusopen}</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href="{$smarty.server.PHP_SELF}?view=scheduled" class="networkissuesscheduled">{$scheduledcount} {$LANG.networkissuesstatusscheduled}</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href="{$smarty.server.PHP_SELF}?view=resolved" class="networkissuesclosed">{$resolvedcount} {$LANG.networkissuesstatusresolved}</a>
</p>
</div>

{foreach from=$issues item=issue}

{if $issue.clientaffected}<div class="alert-message block-message warning">{/if}

    <h3>{$issue.title} ({$issue.status})</h3>
    <p><strong>{$LANG.networkissuesaffecting} {$issue.type}</strong> - {if $issue.type eq $LANG.networkissuestypeserver}{$issue.server}{else}{$issue.affecting}{/if} | <strong>{$LANG.networkissuespriority}</strong> - {$issue.priority}</span></p>
    <br />
    <blockquote>
    {$issue.description}
    </blockquote>
    <p><strong>{$LANG.networkissuesdate}</strong> - {$issue.startdate}{if $issue.enddate} - {$issue.enddate}{/if}</p>
    <p><strong>{$LANG.networkissueslastupdated}</strong> - {$issue.lastupdate}</p>

{if $issue.clientaffected}</div>{/if}

{foreachelse}

<p class="textcenter"><strong>{$noissuesmsg}</strong></p>

{/foreach}

<div class="pagination">
    <ul>
        <li class="prev{if !$prevpage} disabled{/if}"><a href="{if $prevpage}{$smarty.server.PHP_SELF}?{if $view}view={$view}&amp;{/if}page={$prevpage}{else}javascript:return false;{/if}">&larr; {$LANG.previouspage}</a></li>
        <li class="next{if !$nextpage} disabled{/if}"><a href="{if $nextpage}{$smarty.server.PHP_SELF}?{if $view}view={$view}&amp;{/if}page={$nextpage}{else}javascript:return false;{/if}">{$LANG.nextpage} &rarr;</a></li>
    </ul>
</div>

{if $servers}

{include file="$template/subheader.tpl" title=$LANG.serverstatustitle}

<p>{$LANG.serverstatusheadingtext}</p>

<br />

<div class="center80">

<table class="zebra-striped">
    <thead>
        <tr>
            <th>{$LANG.servername}</th>
            <th class="textcenter">HTTP</th>
            <th class="textcenter">FTP</th>
            <th class="textcenter">POP3</th>
            <th class="textcenter">{$LANG.serverstatusphpinfo}</th>
            <th class="textcenter">{$LANG.serverstatusserverload}</th>
            <th class="textcenter">{$LANG.serverstatusuptime}</th>
        </tr>
    </thead>
    <tbody>
{foreach from=$servers key=num item=server}
        <tr>
            <td>{$server.name}</td>
            <td class="textcenter">{get_port_status num="$num" port="80"}</td>
            <td class="textcenter">{get_port_status num="$num" port="21"}</td>
            <td class="textcenter">{get_port_status num="$num" port="110"}</td>
            <td class="textcenter"><a href="{$server.phpinfourl}" target="_blank">{$LANG.serverstatusphpinfo}</a></td>
            <td class="textcenter">{$server.serverload}</td>
            <td class="textcenter">{$server.uptime|replace:'Days':$LANG.days}</td>
        </tr>
{foreachelse}
        <tr>
            <td colspan="7">{$LANG.serverstatusnoservers}</td>
        </tr>
{/foreach}
    </tbody>
</table>

</div>

{/if}

{if $loggedin}<p>{$LANG.networkissuesaffectingyourservers}</p>{/if}

<br />
<br />