<div class="halfwidthcontainer">

{include file="$template/pageheader.tpl" title=$LANG.pwreset}

{if $success}

  <div class="alert-message success">
    <p>{$LANG.pwresetvalidationsent}</p>
  </div>

  <p>{$LANG.pwresetvalidationcheckemail}

  <br />
  <br />
  <br />
  <br />

{else}

{if $errormessage}
<div class="alert-message error textcenter">
    <p>{$errormessage}</p>
</div>
{/if}

<form method="post" action="pwreset.php"  class="form-stacked">
<input type="hidden" name="action" value="reset" />

{if $securityquestion}

<input type="hidden" name="email" value="{$email}" />

<p>{$LANG.pwresetsecurityquestionrequired}</p>

<div class="logincontainer">

    <fieldset>

	    <div class="clearfix">
		  <label for="answer">{$securityquestion}:</label>
		  <div class="input">
		    <input class="xlarge" name="answer" id="answer" type="text" value="{$answer}" />
		  </div>
		</div>

        <div>
		  <p align="center"><input type="submit" class="btn primary" value="{$LANG.pwresetsubmit}" /></p>
        </div>

    </fieldset>

</div>

{else}

<p>{$LANG.pwresetdesc}</p>

<div class="logincontainer">

    <fieldset>

	    <div class="clearfix">
		  <label for="email">{$LANG.loginemail}:</label>
		  <div class="input">
		    <input class="xlarge" name="email" id="email" type="text" />
		  </div>
		</div>

        <div>
		  <p align="center"><input type="submit" class="btn primary" value="{$LANG.pwresetsubmit}" /></p>
        </div>

    </fieldset>

</div>

{/if}

</form>

{/if}

</div>