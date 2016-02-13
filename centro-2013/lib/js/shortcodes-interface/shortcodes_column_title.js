(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_column_title.png';
    tinymce.create('tinymce.plugins.shortcodes_column_title', {
        init : function(ed, url) {
            ed.addButton('shortcodes_column_title', {
                title : 'Title Column Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[title_column title=""]' + ed.selection.getContent() + '[/title_column]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_column_title', tinymce.plugins.shortcodes_column_title);
})();