(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_blog.png';
    tinymce.create('tinymce.plugins.shortcodes_blog', {
        init : function(ed, url) {
            ed.addButton('shortcodes_blog', {
                title : 'Recent Posts Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[recent_posts]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_blog', tinymce.plugins.shortcodes_blog);
})();