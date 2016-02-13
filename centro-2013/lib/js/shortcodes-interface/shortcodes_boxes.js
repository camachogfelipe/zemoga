(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_boxes.png';
    tinymce.create('tinymce.plugins.shortcodes_boxes', {
        init : function(ed, url) {
            ed.addButton('shortcodes_boxes', {
                title : 'Message Box Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[content_box color="blue/red/green/yellow"]' + ed.selection.getContent() + '[/content_box]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_boxes', tinymce.plugins.shortcodes_boxes);
})();