<div class="halfwidthcontainer">

{include file="$template/pageheader.tpl" title=$LANG.pwreset}

{if $errormessage}

  <div class="alert-message error">
    <p>{$errormessage}</p>
  </div>

{else}

  <div class="alert-message success">
    <p>{$LANG.pwresetvalidationsuccess}</p>
  </div>

  <p>{$LANG.pwresetvalidationsuccessdesc}</p>

{/if}

</div>