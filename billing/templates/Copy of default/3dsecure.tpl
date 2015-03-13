<br /><br />

<p class="textcenter">{$LANG.creditcard3dsecure}</p>

<br />

<div class="textcenter">

{$code}

<br /><br />

<iframe name="3dauth" width="400" height="500" scrolling="auto" src="about:blank" style="border:1px solid #fff;"></iframe>

</div>

<br /><br /><br />

{literal}
<script language="javascript">
setTimeout ( "autoForward()" , 1000 );
function autoForward() {
	document.forms[0].submit()
}
</script>
{/literal}