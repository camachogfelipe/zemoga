(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_drop.png';
    tinymce.create('tinymce.plugins.shortcodes_drop', {
        init : function(ed, url) {
            ed.addButton('shortcodes_drop', {
                title : 'Dropcap Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[dropcap type="colored/simple"]' + ed.selection.getContent() + '[/dropcap]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_drop', tinymce.plugins.shortcodes_drop);
})();