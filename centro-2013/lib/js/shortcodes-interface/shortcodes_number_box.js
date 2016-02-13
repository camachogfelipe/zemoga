(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_numbered.png';
    tinymce.create('tinymce.plugins.shortcodes_number_box', {
        init : function(ed, url) {
            ed.addButton('shortcodes_number_box', {
                title : 'Numbered Box Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[numbered_box number="" title="" subtitle=""]' + ed.selection.getContent() + '[/numbered_box]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_number_box', tinymce.plugins.shortcodes_number_box);
})();