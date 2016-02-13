(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_map.png';
    tinymce.create('tinymce.plugins.shortcodes_map', {
        init : function(ed, url) {
            ed.addButton('shortcodes_map', {
                title : 'Google Map Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[googlemap height="" width="" src=""]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_map', tinymce.plugins.shortcodes_map);
})();