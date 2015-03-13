{if $affiliatesystemenabled}

{include file="$template/pageheader.tpl" title=$LANG.affiliatesactivate}

<div class="alert-message block-message info">

    <h2>{$LANG.affiliatesignuptitle}</h2>

    <p>{$LANG.affiliatesignupintro}</p>

</div>

<ul>
<li>{$LANG.affiliatesignupinfo1}</li>
<li>{$LANG.affiliatesignupinfo2}</li>
<li>{$LANG.affiliatesignupinfo3}</li>
</ul>

<br />

<form method="post" action="affiliates.php">
<input type="hidden" name="activate" value="true" />
<p align="center"><input type="submit" value="{$LANG.affiliatesactivate}" class="btn success" /></p>
</form>

{else}

{include file="$template/pageheader.tpl" title=$LANG.affiliatestitle}

<div class="alert-message warning">
    <p>{$LANG.affiliatesdisabled}</p>
</div>

{/if}

<br />
<br />
<br />