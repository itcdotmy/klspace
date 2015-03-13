jQuery(document).ready(function(){

  // Dropdown for topbar nav
  // ===============================

  jQuery("html").bind("click", function (e) {
    jQuery('.dropdown-toggle, a.menu').parent("li").removeClass("open");
  });

  jQuery(".dropdown-toggle, a.menu").click(function(e) {
    //  First look an see if a menu is open.  If it is, then just close it.
    if (jQuery(this).parent("li").hasClass("open")) {
        jQuery("ul").find('li').removeClass('open');
    }
    //  If menu was not open, then close any other menus that were open and just open the one.
    else {
        jQuery("ul").find('li').removeClass('open');
        jQuery(this).parent("li").addClass('open');
    }
    return false;
  });

  // Tabs Changer
  // ===============================

	//Default Action
	jQuery(".tab_content").hide(); //Hide all content
	jQuery("#tabs ul.tabs li:first").addClass("active").show(); //Activate first tab
	jQuery(".tab_content:first").show(); //Show first tab content

	//On Click Event
	jQuery("#tabs ul.tabs li").click(function() {
        jQuery("ul").find('li').removeClass('open');
		jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
		jQuery(this).addClass("active"); //Add "active" class to selected tab
		var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
        if (activeTab.substr(0,1)=="#" && activeTab.substr(1)!="") { //Determine if a tab or link
            jQuery(".tab_content").hide(); //Hide all tab content
    		jQuery(activeTab).fadeIn(); //Fade in the active content
            return false;
        } else {
            return true; // If link allow redirect
        }
	});

});

// Checkboxes Toggle
// ===============================

function toggleCheckboxes(classname) {
    jQuery("."+classname).attr('checked',!jQuery("."+classname+":first").is(':checked'));
}

// Disable Field Class
// ===============================

function disableFields(classname,disable) {
    if (disable) jQuery("."+classname).attr("disabled","disabled");
    else jQuery("."+classname).removeAttr("disabled");
}

// Open Centered Popup
// ===============================

function popupWindow(addr,popname,w,h,features) {
  var winl = (screen.width-w)/2;
  var wint = (screen.height-h)/2;
  if (winl < 0) winl = 0;
  if (wint < 0) wint = 0;
  var settings = 'height=' + h + ',';
  settings += 'width=' + w + ',';
  settings += 'top=' + wint + ',';
  settings += 'left=' + winl + ',';
  settings += features;
  win = window.open(addr,popname,settings);
  win.window.focus();
}

// Support Tickets
// ===============================

function extraTicketAttachment() {
    jQuery("#fileuploads").append('<input type="file" name="attachments[]" style="width:70%;" /><br />');
}

function rating_hover(id) {
    var selrating=id.split('_');
    for(var i=1; i<=5; i++){
        if(i<=selrating[1]) document.getElementById(selrating[0]+'_'+i).style.background="url(images/rating_pos.png)";
        if(i>selrating[1]) document.getElementById(selrating[0]+'_'+i).style.background="url(images/rating_neg.png)";
    }
}
function rating_leave(id){
    for(var i=1; i<=5; i++){
        document.getElementById(id+'_'+i).style.background="url(images/rating_neg.png)";
    }
}
function rating_select(tid,c,id){
    window.location='viewticket.php?tid='+tid+'&c='+c+'&rating='+id;
}

// Records Per Page
// ===============================

function limitchange() {
    jQuery("#itemlim").val(jQuery("#itemlimit").val());
    jQuery("#itemlimfrm").submit();
}