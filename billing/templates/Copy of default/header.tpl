<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset={$charset}" />
    <title>{if $kbarticle.title}{$kbarticle.title} - {/if}{$pagetitle} - {$companyname}</title>

    {if $systemurl}<base href="{$systemurl}" />
    {/if}<script type="text/javascript" src="includes/jscript/jquery.js"></script>
    {if $livehelpjs}{$livehelpjs}
    {/if}
    <link href="templates/{$template}/css/bootstrap.css" rel="stylesheet">
    <link href="templates/{$template}/css/whmcs.css" rel="stylesheet">

    <script src="templates/{$template}/js/whmcs.js"></script>

    {$headoutput}

  </head>

  <body>

{$headeroutput}

<div id="whmcsheader">
    <div class="whmcscontainer">
        <div id="whmcstxtlogo"><a href="index.php">{$companyname}</a></div>
        <div id="whmcsimglogo"><img src="templates/{$template}/img/whmcslogo.png" alt="{$companyname}" /></div>
    </div>
</div>

	<div class="topbar">
	  <div class="fill">
		<div class="whmcscontainer">

		  <ul>
			<li><a href="{if $loggedin}clientarea{else}index{/if}.php">{$LANG.hometitle}</a></li>
		  </ul>
{if $loggedin}
		  <ul>
			<li class="menu">
			  <a href="#" class="menu">{$LANG.navservices}</a>
			  <ul class="menu-dropdown">
				<li><a href="clientarea.php?action=products">{$LANG.clientareanavservices}</a></li>
				<li class="divider"></li>
				<li><a href="cart.php">{$LANG.navservicesorder}</a></li>
				<li><a href="cart.php?gid=addons">{$LANG.clientareaviewaddons}</a></li>
			  </ul>
			</li>
		  </ul>

		  <ul>
			<li class="menu">
			  <a href="#" class="menu">{$LANG.navdomains}</a>
			  <ul class="menu-dropdown">
				<li><a href="clientarea.php?action=domains">{$LANG.clientareanavdomains}</a></li>
				<li class="divider"></li>
				<li><a href="cart.php?gid=renewals">{$LANG.navrenewdomains}</a></li>
				<li><a href="cart.php?a=add&domain=register">{$LANG.navregisterdomain}</a></li>
				<li><a href="cart.php?a=add&domain=transfer">{$LANG.navtransferdomain}</a></li>
				<li class="divider"></li>
				<li><a href="domainchecker.php">{$LANG.navwhoislookup}</a></li>
			  </ul>
			</li>
		  </ul>

		  <ul>
			<li class="menu">
			  <a href="#" class="menu">{$LANG.navbilling}</a>
			  <ul class="menu-dropdown">
				<li><a href="clientarea.php?action=invoices">{$LANG.invoices}</a></li>
				<li><a href="clientarea.php?action=quotes">{$LANG.quotestitle}</a></li>
				<li class="divider"></li>
				{if $condlinks.addfunds}<li><a href="clientarea.php?action=addfunds">{$LANG.addfunds}</a></li>{/if}
				{if $condlinks.masspay}<li><a href="clientarea.php?action=masspay&all=true">{$LANG.masspaytitle}</a></li>{/if}
				{if $condlinks.updatecc}<li><a href="clientarea.php?action=creditcard">{$LANG.navmanagecc}</a></li>{/if}
			  </ul>
			</li>
		  </ul>

          <ul>
			<li class="menu">
			  <a href="#" class="menu">{$LANG.navsupport}</a>
			  <ul class="menu-dropdown">
				<li><a href="supporttickets.php">{$LANG.navtickets}</a></li>
				<li><a href="knowledgebase.php">{$LANG.knowledgebasetitle}</a></li>
				<li><a href="downloads.php">{$LANG.downloadstitle}</a></li>
				<li><a href="serverstatus.php">{$LANG.networkstatustitle}</a></li>
			  </ul>
			</li>
		  </ul>

          <ul>
            <li><a href="submitticket.php">{$LANG.navopenticket}</a></li>
          </ul>

          <ul>
            <li><a href="affiliates.php">{$LANG.affiliatestitle}</a></li>
          </ul>

		  <ul class="nav secondary-nav">
			<li class="menu">
			  <a href="#" class="menu">{$LANG.hello}, {$loggedinuser.firstname}!</a>
			  <ul class="menu-dropdown">
				<li><a href="clientarea.php?action=details">{$LANG.editaccountdetails}</a></li>
				{if $condlinks.updatecc}<li><a href="clientarea.php?action=creditcard">{$LANG.navmanagecc}</a></li>{/if}
				<li><a href="clientarea.php?action=contacts">{$LANG.clientareanavcontacts}</a></li>
				{if $condlinks.addfunds}<li><a href="clientarea.php?action=addfunds">{$LANG.addfunds}</a></li>{/if}
				<li><a href="clientarea.php?action=emails">{$LANG.navemailssent}</a></li>
				<li><a href="clientarea.php?action=changepw">{$LANG.clientareanavchangepw}</a></li>
				<li class="divider"></li>
				<li><a href="logout.php">{$LANG.logouttitle}</a></li>
			  </ul>
			</li>
		  </ul>
{else}
		  <ul>
			<li><a href="announcements.php">{$LANG.announcementstitle}</a></li>
		  </ul>
          <ul>
			<li><a href="knowledgebase.php">{$LANG.knowledgebasetitle}</a></li>
		  </ul>
		  <ul>
			<li><a href="serverstatus.php">{$LANG.networkstatustitle}</a></li>
		  </ul>
		  <ul>
			<li><a href="affiliates.php">{$LANG.affiliatestitle}</a></li>
		  </ul>
		  <ul>
			<li><a href="contact.php">{$LANG.contactus}</a></li>
		  </ul>

		  <ul class="nav secondary-nav">
			<li class="menu">
			  <a href="#" class="menu">{$LANG.account}</a>
			  <ul class="menu-dropdown">
				<li><a href="clientarea.php">{$LANG.login}</a></li>
				<li><a href="register.php">{$LANG.register}</a></li>
				<li class="divider"></li>
				<li><a href="pwreset.php">{$LANG.forgotpw}</a></li>
			  </ul>
			</li>
		  </ul>
{/if}
		</div>
	  </div>
	</div>

<div class="whmcscontainer">
    <div class="contentpadded">

{if $pagetitle eq $LANG.carttitle}<div id="whmcsorderfrm">{/if}

