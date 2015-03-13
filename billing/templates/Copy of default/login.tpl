<div class="halfwidthcontainer">

{include file="$template/pageheader.tpl" title=$LANG.login}

{if $incorrect}
<div class="alert-message error textcenter">
    <p>{$LANG.loginincorrect}</p>
</div>
{/if}

<form method="post" action="{$systemsslurl}dologin.php" class="form-stacked" name="frmlogin">

<div class="logincontainer">

    <fieldset>

	    <div class="clearfix">
		    <label for="username">{$LANG.loginemail}:</label>
			<div class="input">
			    <input class="xlarge" name="username" id="username" type="text" />
			</div>
		</div>

		<div class="clearfix">
		    <label for="password">{$LANG.loginpassword}:</label>
			<div class="input">
			    <input class="xlarge" name="password" id="password" type="password"/>
			</div>
		</div>

        <div align="center">
		  <div class="loginbtn"><input type="submit" class="btn primary" value="{$LANG.loginbutton}" /></div>
          <div class="rememberme">
            <label>
                <input type="checkbox" name="rememberme"{if $rememberme} checked="checked"{/if} /> {$LANG.loginrememberme}
            </label>
          </div>
          <br />
          <br />
          <p><a href="pwreset.php">{$LANG.loginforgotteninstructions}</a></p>
        </div>

	</fieldset>

</div>

</form>

<script language="javascript">
document.frmlogin.username.focus();
</script>

</div>