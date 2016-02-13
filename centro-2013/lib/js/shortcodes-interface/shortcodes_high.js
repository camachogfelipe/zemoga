(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_high.png';
    tinymce.create('tinymce.plugins.shortcodes_high', {
        init : function(ed, url) {
            ed.addButton('shortcodes_high', {
                title : 'Highlight Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[highlight type="regular/alternative-1/alternative-2"]' + ed.selection.getContent() + '[/highlight]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_high', tinymce.plugins.shortcodes_high);
})();