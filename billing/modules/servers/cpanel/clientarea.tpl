{if $producttype=="hostingaccount"}

    <form action="http{if $serversecure}s{/if}://{if $serverhostname}{$serverhostname}{else}{$serverip}{/if}:{if $serversecure}2083{else}2082{/if}/login/" method="post" target="_blank">
		<input type="hidden" name="user" value="{$username}" />
		<input type="hidden" name="pass" value="{$password}" />
		<input type="submit" value="{$LANG.clientareacpanellink}" class="modulebutton" />
		<input type="button" value="{$LANG.clientareawebmaillink}" onClick="window.open('http{if $serversecure}s{/if}://{if $serverhostname}{$serverhostname}{else}{$serverip}{/if}:{if $serversecure}2096{else}2095{/if}/')" class="modulebutton" />
		</form>

{elseif $producttype=="reselleraccount"}

    <form action="http{if $serversecure}s{/if}://{if $serverhostname}{$serverhostname}{else}{$serverip}{/if}:{if $serversecure}2087{else}2086{/if}/login/" method="post" target="_blank">
		<input type="hidden" name="user" value="{$username}" />
		<input type="hidden" name="pass" value="{$password}" />
		<input type="submit" value="{$LANG.clientareawhmlink}" class="modulebutton" />
		</form>

{/if}