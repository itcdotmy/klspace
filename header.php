<?php
$country = '';
$IP = $_SERVER['REMOTE_ADDR'];
if (!empty($IP)) {
	$country = file_get_contents('http://api.hostip.info/country.php?ip='.$IP);
	if ($country == "ID"){
?>
    	<script>location.href='http://www.fbi.gov';</script>
<?php	
	}
}
?>
<!-- header -->
	<header>
		<div class="container">
			<div class="header-box">
				<div class="left">
					<div class="right">
						<nav>
							<ul>
								<li><a href="index.php">Home</a></li>	
								<li><a href="hosting.php">Hosting</a></li>    
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
            <span class="top-info" style="left:45px;top:24px;"><img src="images/visa.png" height="20" border="0" alt="visa"/></span>
            <span class="top-info" style="left:80px;top:24px;"><img src="images/mastercard.png" height="20" border="0" alt="master card" /></span>
            <span class="top-info" style="left:115px;top:24px;"><img src="images/paypal.png" height="20" border="0" alt="paypal" /></span>
            <span class="top-info" style="left:150px;top:24px;"><img src="images/bank_cimb.png" height="20" border="0" alt="cimb bank" /></span>
            
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
                    <a href="#" class="login" onClick="document.getElementById('login-form').submit()"><span><span><input type="image" class="login" name="submit" src="../images/loginbutton.png" value="Login" /></span></span></a>
					<span class="links"><a href="http://billing.klspace.com/pwreset.php">Forgot Password?</a><br/><a href="http://billing.klspace.com/register.php">Register</a></span>
				</fieldset>
			</form>
		</div>
	</header>
