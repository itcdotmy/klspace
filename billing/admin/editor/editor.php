<script language="javascript" type="text/javascript" src="editor/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
    entity_encoding: "raw",
    convert_urls : false,
	relative_urls : false,
    plugins : "style,table,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,visualchars,xhtmlxtras",
    theme_advanced_buttons1 : "cut,copy,paste,pastetext,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,search,replace",
    theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,|,forecolor,backcolor,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,cleanup,code,help",
    theme_advanced_buttons3 : "", // tablecontrols
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true
});
function toggleEditor() {
    if (!tinyMCE.get('email_msg1')) {
    <?php for ( $k = 1; $k <= $i; $k++ ) { ?>
        tinyMCE.execCommand('mceAddControl', false, 'email_msg<?php echo $k ?>');
    <?php } ?>
    } else {
        <?php for ( $k = 1; $k <= $i; $k++ ) { ?>
        tinyMCE.execCommand('mceRemoveControl', false, 'email_msg<?php echo $k ?>');
    <?php } ?>
    }
}
function insertMergeField(field) {
    tinyMCE.execInstanceCommand("email_msg1","mceInsertContent",false,'{$'+field+'}');
}
</script>