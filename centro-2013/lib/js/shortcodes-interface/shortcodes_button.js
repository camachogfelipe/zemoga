(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_button.gif';
    tinymce.create('tinymce.plugins.shortcodes_button', {
        init : function(ed, url) {
            ed.addButton('shortcodes_button', {
                title : 'Button Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[button link=""]' + ed.selection.getContent() + '[/button]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_button', tinymce.plugins.shortcodes_button);
})();