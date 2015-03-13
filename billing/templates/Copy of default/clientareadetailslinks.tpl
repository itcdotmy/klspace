<div>
    <ul class="tabs">

        {if $clientareaaction eq "details"}<li class="active"><a href="clientarea.php?action=details">{$LANG.clientareanavdetails}</a></li>{else}<li><a href="clientarea.php?action=details">{$LANG.clientareanavdetails}</a></li>{/if}

        {if $condlinks.updatecc}{if $clientareaaction eq "creditcard"}<li class="active"><a href="{$smarty.server.PHP_SELF}?action=creditcard">{$LANG.clientareanavccdetails}</a></li>{else}<li><a href="{$smarty.server.PHP_SELF}?action=creditcard">{$LANG.clientareanavccdetails}</a></li>{/if}{/if}

        {if $clientareaaction eq "contacts" ||  $clientareaaction eq "addcontact"}<li class="active"><a href="{$smarty.server.PHP_SELF}?action=contacts">{$LANG.clientareanavcontacts}</a></li>{else}<li><a href="{$smarty.server.PHP_SELF}?action=contacts">{$LANG.clientareanavcontacts}</a></li>{/if}

        {if $clientareaaction eq "changepw"}<li class="active"><a href="{$smarty.server.PHP_SELF}?action=changepw">{$LANG.clientareanavchangepw}</a></li>{else}<li><a href="{$smarty.server.PHP_SELF}?action=changepw">{$LANG.clientareanavchangepw}</a></li>{/if}

        {if $condlinks.updatesq}{if $clientareaaction eq "changesq"}<li class="active"><a href="{$smarty.server.PHP_SELF}?action=changesq">{$LANG.clientareanavsecurityquestions}</a></li>{else}<li><a href="{$smarty.server.PHP_SELF}?action=changesq">{$LANG.clientareanavsecurityquestions}</a></li>{/if}{/if}

    </ul>
</div>
<div class="clear"></div>