(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_social.png';
    tinymce.create('tinymce.plugins.shortcodes_social', {
        init : function(ed, url) {
            ed.addButton('shortcodes_social', {
                title : 'Social Profiles Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[social_profiles]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_social', tinymce.plugins.shortcodes_social);
})();