<?php

function hook_services_tab_demo($vars) {

return array("Field1"=>'<input type="text" name="x" />',"Field2"=>'<input type="text" name="x2" />');

}

function hook_services_tab_demo_save($vars) {

}

function hook_domains_tab_demo_save($vars) {
print_r($vars);exit;
}

#add_hook("AdminClientServicesTabFields",1,"hook_services_tab_demo");
add_hook("AdminClientDomainsTabFields",1,"hook_services_tab_demo");
add_hook("AdminClientServicesTabFieldsSave",1,"hook_services_tab_demo_save");
add_hook("AdminClientDomainsTabFieldsSave",1,"hook_domains_tab_demo_save");

?>