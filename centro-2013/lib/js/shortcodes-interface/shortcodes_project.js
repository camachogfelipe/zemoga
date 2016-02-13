(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_project.png';
    tinymce.create('tinymce.plugins.shortcodes_project', {
        init : function(ed, url) {
            ed.addButton('shortcodes_project', {
                title : 'Simple Project Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[project title="" type="image/video" link="image-or-video-to-be-opened-in-lightbox" image="full-path-to-image"]' + ed.selection.getContent() + '[/project]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_project', tinymce.plugins.shortcodes_project);
})();