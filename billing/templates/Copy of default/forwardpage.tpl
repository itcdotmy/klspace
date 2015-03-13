<br /><br />

<div class="alert-message block-message warn">
    <p>{$message}</p>
</div>

<p class="textcenter"><img src="images/loading.gif" alt="Loading" border="0" /></p>

<br />

<div class="textcenter">{$code}</div>

<form method="post" action="{if $invoiceid}viewinvoice.php?id={$invoiceid}{else}clientarea.php{/if}"></form>

<br /><br /><br />

{literal}
<script language="javascript">
setTimeout ( "autoForward()" , 5000 );
function autoForward() {
	document.forms[0].submit()
}
</script>
{/literal}