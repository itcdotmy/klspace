{php}

$serviceid = $this->_tpl_vars['serviceid'];
$result = full_query("SELECT mod_licensing.licensekey,mod_licensing.validdomain,mod_licensing.validip,mod_licensing.validdirectory,mod_licensing.status,tblproducts.configoption3 FROM tblhosting,tblproducts,mod_licensing WHERE tblhosting.packageid=tblproducts.id AND tblhosting.id=mod_licensing.serviceid AND tblproducts.servertype='licensing' AND tblhosting.id=".(int)$serviceid);
$data = mysql_fetch_array($result);
$licensekey = $data["licensekey"];
$validdomain = $data["validdomain"];
$validip = $data["validip"];
$validdirectory = $data["validdirectory"];
$status = $data["status"];
$allowreissues = $data["configoption3"];

if ($status=="Reissued") {
    echo '<div class="alert-message success">The Valid Domain, IP and Directory will be detected & saved the next time the license is used.</div>';
}

{/php}

<p><h4>License Key:</h4> {$domain}</p>
<p><h4>Valid Domains:</h4> <textarea rows=2 style="width:60%;" readonly=true>{php}echo $validdomain;{/php}</textarea></p>
<p><h4>Valid IPs:</h4> <textarea rows=2 style="width:60%;" readonly=true>{php}echo $validip;{/php}</textarea></p>
<p><h4>Valid Directory:</h4> <textarea rows=2 style="width:60%;" readonly=true>{php}echo $validdirectory;{/php}</textarea></p>
<p><h4>License Status:</h4> {php}echo $status;{/php}</p>

{php}
if (($allowreissues)AND($status=="Active")) {
{/php}
<form method="post" action="clientarea.php?action=productdetails">
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="serveraction" value="custom" />
<input type="hidden" name="a" value="reissue" />
<p align="center"><br /><input type="submit" value="Reissue License" class="btn" /></p>
</form>
{php}
}
{/php}
