<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="templates/{$template}/images/favicon.gif" type="image/x-icon" /> 
<title>{if $kbarticle.title}{$kbarticle.title} - {/if}{$pagetitle} - {$companyname}</title>

<meta name="description" content="Webhosting packages with cloud hosting technology and internatioanal web hosting package with cpanel, whm reseller account for free">
<meta name="keywords" content="free hosting, cloud, cloud hosting, malaysia web hosting, itc, web hosting, reseller, cpanel, whm, international, webhosting, web services">
<meta name="author" content="itc.my, admin@itc.my">
<meta charset="utf-8">

<link rel="stylesheet" href="templates/{$template}/css/layout.css" type="text/css" media="all">

<script type="text/javascript" src="templates/{$template}/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="templates/{$template}/js/cufon-yui.js"></script>
<script type="text/javascript" src="templates/{$template}/js/cufon-replace.js"></script>
<script type="text/javascript" src="templates/{$template}/js/Myriad_Pro_300.font.js"></script>
<script type="text/javascript" src="templates/{$template}/js/Myriad_Pro_400.font.js"></script>
<script type="text/javascript" src="templates/{$template}/js/Myriad_Pro_600.font.js"></script>
<script type="text/javascript" src="templates/{$template}/js/script.js"></script>

    {$headoutput}
    
<link rel="stylesheet" href="templates/{$template}/revealpromo.css">
<script type="text/javascript" src="templates/{$template}/jquery.reveal.js"></script>
<style type="text/css">
	body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
	.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
</style>

<!--[if lt IE 7]>
<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
 <![endif]-->
<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
{if $systemurl}<base href="{$systemurl}" />
{/if}<script type="text/javascript" src="includes/jscript/jquery.js"></script>
{if $livehelpjs}{$livehelpjs}
{/if}
<link href="templates/{$template}/css/bootstrap.css" rel="stylesheet">
<link href="templates/{$template}/css/whmcs.css" rel="stylesheet">

<script src="templates/{$template}/js/whmcs.js"></script>
<script type="text/javascript">
var _bsc = _bsc || {};
(function() {
var bs = document.createElement('script');
bs.type = 'text/javascript';
bs.async = true;
bs.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://d2so4705rl485y.cloudfront.net/widgets/tracker/tracker.js';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(bs, s);
})();
</script>

</head>
<body>
{php}
$country = '';
$IP = $_SERVER['REMOTE_ADDR'];
if (!empty($IP)) {
	$country = file_get_contents('http://api.hostip.info/country.php?ip='.$IP);
    if ($country == "ID"){
{/php}
    	<script>location.href='http://www.fbi.gov';</script>
{php}
    }
}
{/php}

<div id="myModal2" class="reveal-promo" style="font-family:Verdana, Geneva, sans-serif;font-size:12px;">
    <h2>New Year Promotion</h2>
    <p>Promotion Code is "<b><font color="#0080C0">NEWYEAR2014</font></b>".<br>
    	During the NEW YEAR festival. KLSPACE.COM give a special promotion for you.<br>
        
        <ul><u>Conditions</u>
            <li>Applies to all web hosting packages except BAJET HOST.</li>
            <li>Coupon can be used more than once for each user.</li>
            <li>Not apply to the purchase of domain names and other services.</li>
            <li>The promotion is valid until 28th February 2014.</li>
        </ul>
        <p align="right"><a href="index.php">Close</a></p>
</div>

<div class="tail-top3" id="page4">
<!-- header -->
	<header>
		<div class="container">
			<div class="header-box">
				<div class="left">
					<div class="right">
						<nav>
							<ul>
								<li><a href="http://klspace.com/index.php">Home</a></li>	
								<li><a href="http://klspace.com/hosting.php">Hosting</a></li>    
                                <li><a href="http://billing.klspace.com/domainchecker.php">Domain</a></li>							
								<li><a href="http://broadband.itc.my" target="_blank">Broadband</a></li>
								<li><a href="http://billing.klspace.com/submitticket.php">Support</a></li>
								<li><a href="#" id="myLink2" data-reveal-id="myModal2">Promotion</a></li>
							</ul>
						</nav>
						<h1><a href="index.php"><span>klspace</span>Hosting</a></h1>
					</div>
				</div>
			</div>
			<span class="top-info" style="top:4px;font-size:9px;font-family:'Arial Black', Gadget, sans-serif;font-weight:bolder;"><u>PAYMENT METHOD</u></span>
            <span class="top-info" style="left:45px;top:24px;"><img src="templates/{$template}/images/visa.png" height="20" border="0" alt="visa"/></span>
            <span class="top-info" style="left:80px;top:24px;"><img src="templates/{$template}/images/mastercard.png" height="20" border="0" alt="master card" /></span>
            <span class="top-info" style="left:115px;top:24px;"><img src="templates/{$template}/images/paypal.png" height="20" border="0" alt="paypal" /></span>
            <span class="top-info" style="left:150px;top:24px;"><img src="templates/{$template}/images/bank_cimb.png" height="20" border="0" alt="cimb bank" /></span>
            
            <!--Promotion Code-->
            <!--<span class="top-info" style="left:305px;top:19px; font-weight:bolder; font:Verdana, Geneva, sans-serif; font-size:16px;">Promotion: <font color="#0099FF">FBMERDEKA56</font></span>-->

			<form id="login-form" method="post" action="http://billing.klspace.com/dologin.php">
           	<input type="hidden" name="token" value="a07ccc5e2d44d40fdd254c3c039493d840335e12" />
				<fieldset>
					<span class="text">
						<input type="text" name="username" value="Username" onFocus="if(this.value=='Username'){this.value=''}" onBlur="if(this.value==''){this.value='Username'}">
					</span>
					<span class="text">
						<input type="password" name="password" value="Password" onFocus="if(this.value=='Password'){this.value=''}" onBlur="if(this.value==''){this.value='Password'}">
					</span>
                    <a href="#" class="login" onClick="document.getElementById('login-form').submit()"><span><span><input type="image" class="login" name="submit" src="templates/{$template}/images/loginbutton.png" value="Login" style="height:31px;" /></span></span></a>
					<span class="links"><a href="http://billing.klspace.com/pwreset.php">Forgot Password?</a><br/><a href="http://billing.klspace.com/register.php">Register</a></span>
				</fieldset>
			</form>
		</div>
	</header>

	<!-- content -->
	<section id="content">
		<div class="container">
			<div class="inside">
				<div id="slogan" class="bot-indent1">
					<div class="inside">
						<h2><span>Cloud </span> Hosting</h2>
						<p>Cloud hosting is based on the most innovative Cloud computing technologies that allow unlimited number of machines to act as one system. The cloud technology allows easy integration of extra resources, such as space or RAM and thus enable website growth. Benefits: Highest level of website performance guaranteed by multiple machines, Redundant data storage, No single point of failure and Website growth flexibility.</p>
					</div>
				</div>
             </div>
         </div>
     </section>

<!--WHMCS-->

{$headeroutput}

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
