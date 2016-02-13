(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_pricing.png';
    tinymce.create('tinymce.plugins.shortcodes_pricing', {
        init : function(ed, url) {
            ed.addButton('shortcodes_pricing', {
                title : 'Pricing Table Shortcode',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[pricing_table title="" price="" color="green/blue/red/grey"]' + ed.selection.getContent() + '[/pricing_table]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_pricing', tinymce.plugins.shortcodes_pricing);
})();