
</div>

<div class="footerbar">
<div class="left">{$_ADMINLANG.global.staffonline}: {$adminsonline}</div>
<div class="right">Copyright &copy; <a href="http://dereferer.ws/?http://www.whmcs.com/" target="_blank">WHMCompleteSolution</a>.  All Rights Reserved.</div>
</div>

<div class="intellisearch">
<form method="get" onsubmit="intellisearch();return false">
<div align="center" id="intellisearch"><img src="images/icons/search.png" alt="Search" width="16" height="16" align="absmiddle" /> <input type="text" id="intellisearchval" size="25" />
</div>
<input type="submit" style="display:none;">
</form>
</div>

<div id="greyout"></div>

<div id="popupcontainer">
<div id="searchresults">
<div align="right"><a href="#" onclick="searchclose();return false"><img src="images/delete.gif" width="16" height="16" align="absmiddle" border="0" /> {$_ADMINLANG.clientsummary.close}</a></div>
<div id="searchresultsscroller"></div>
<form method="get" action="search.php">
<img src="images/icons/search.png" class="absmiddle" width="16" height="16" /> {$_ADMINLANG.global.advancedsearch}
    <select name="type" id="searchtype" onchange="populate(this)">
      <option value="clients">Clients</option>
      <option value="orders">Orders</option>
      <option value="services">Services</option>
      <option value="domains">Domains</option>
      <option value="invoices">Invoices</option>
      <option value="tickets">Tickets</option>
    </select> <select name="field" id="searchfield">
      <option>Client ID</option>
      <option selected="selected">Client Name</option>
      <option>Company Name</option>
      <option>Email Address</option>
      <option>Address 1</option>
      <option>Address 2</option>
      <option>City</option>
      <option>State</option>
      <option>Postcode</option>
      <option>Country</option>
      <option>Phone Number</option>
      <option>CC Last Four</option>
    </select> <input type="text" name="q" size="15" style="border: 1px solid #ccc;padding:3px;" /> <input type="submit" value="{$_ADMINLANG.global.search}" />
</form>
</div>
<div id="mynotes">
<div align="right"><a href="#" onclick="notesclose('');return false"><img src="images/delete.gif" width="16" height="16" align="absmiddle" border="0" /> {$_ADMINLANG.clientsummary.close}</a></div>
<textarea id="mynotesbox" rows="15">{$admin_notes}</textarea><br /><input type="button" value="{$_ADMINLANG.global.savechanges}" onclick="notesclose('1');return false" /></div>
</div>
{$footeroutput}
</body>
</html>