(function(){
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_tabs.png';
	tinymce.create('tinymce.plugins.shortcodes_tabs', {
		createControl : function(id, controlManager) {
			if (id == 'shortcodes_tabs_button') {
				var button = controlManager.createButton('shortcodes_tabs_button', {
					title : 'Insert Tabs Shortcode',
					image :  icon_url,
					onclick : function() {
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Insert Tabs Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes-tabs-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	tinymce.PluginManager.add('shortcodes_tabs', tinymce.plugins.shortcodes_tabs);
	
	jQuery(function(){
		var form = jQuery('\
			<div id="shortcodes-tabs-form">\
				<div id="shortcodes-tabs-container" class="shortcodes-container">\
					<div class="left">\
						<label for="celta_tab_title_1">Tab Title</label>\
						<input type="text" id="celta_tab_title_1" name="celta_tab_title_1" value="" class="activeTitle" />\
						<small>Insert the title of the tab.</small>\
					</div>\
					<div class="clear"></div>\
					<div class="full">\
						<label for="celta_tab_content_1">Tab Content</label>\
						<textarea id="celta_tab_content_1" name="celta_tab_content_1" rows="5" class="activeContent">Content of the Tab</textarea>\
						<small>Insert the content of the tab.</small>\
					</div>\
					<div class="full">\
						<a href="#" class="addTab" rel="tab2">Add one more tab</a>\
					</div>\
					<div class="left tab2">\
						<label for="celta_tab_title_2">Tab Title</label>\
						<input type="text" id="celta_tab_title_2" name="celta_tab_title_2" value="" />\
						<small>Insert the title of the tab.</small>\
					</div>\
					<div class="clear tab2"></div>\
					<div class="full tab2">\
						<label for="celta_tab_content_2">Tab Content</label>\
						<textarea id="celta_tab_content_2" name="celta_tab_content_2" rows="5">Content of the Tab</textarea>\
						<small>Insert the content of the tab.</small>\
					</div>\
					<div class="full tab2">\
						<a href="#" class="addTab" rel="tab3">Add one more tab</a>\
					</div>\
					<div class="left tab3">\
						<label for="celta_tab_title_3">Tab Title</label>\
						<input type="text" id="celta_tab_title_3" name="celta_tab_title_3" value="" />\
						<small>Insert the title of the tab.</small>\
					</div>\
					<div class="clear tab3"></div>\
					<div class="full tab3">\
						<label for="celta_tab_content_3">Tab Content</label>\
						<textarea id="celta_tab_content_3" name="celta_tab_content_3" rows="5">Content of the Tab</textarea>\
						<small>Insert the content of the tab.</small>\
					</div>\
					<div class="full tab3">\
						<a href="#" class="addTab" rel="tab4">Add one more tab</a>\
					</div>\
					<div class="left tab4">\
						<label for="celta_tab_title_4">Tab Title</label>\
						<input type="text" id="celta_tab_title_4" name="celta_tab_title_4" value="" />\
						<small>Insert the title of the tab.</small>\
					</div>\
					<div class="clear tab4"></div>\
					<div class="full tab4">\
						<label for="celta_tab_content_4">Tab Content</label>\
						<textarea id="celta_tab_content_4" name="celta_tab_content_4" rows="5">Content of the Tab</textarea>\
						<small>Insert the content of the tab.</small>\
					</div>\
					<div class="full tab4">\
						<a href="#" class="addTab" rel="tab5">Add one more tab</a>\
					</div>\
					<div class="left tab5">\
						<label for="celta_tab_title_5">Tab Title</label>\
						<input type="text" id="celta_tab_title_5" name="celta_tab_title_5" value="" />\
						<small>Insert the title of the tab.</small>\
					</div>\
					<div class="clear tab5"></div>\
					<div class="full tab5">\
						<label for="celta_tab_content_5">Tab Content</label>\
						<textarea id="celta_tab_content_5" name="celta_tab_content_5" rows="5">Content of the Tab</textarea>\
						<small>Insert the content of the tab.</small>\
					</div>\
					<div class="full tab5">\
						<a href="#" class="addTab" rel="tab6">Add one more tab</a>\
					</div>\
					<div class="left tab6">\
						<label for="celta_tab_title_6">Tab Title</label>\
						<input type="text" id="celta_tab_title_6" name="celta_tab_title_6" value="" />\
						<small>Insert the title of the tab.</small>\
					</div>\
					<div class="clear tab6"></div>\
					<div class="full tab6">\
						<label for="celta_tab_content_6">Tab Content</label>\
						<textarea id="celta_tab_content_6" name="celta_tab_content_6" rows="5">Content of the Tab</textarea>\
						<small>Insert the content of the tab.</small>\
					</div>\
					<div class="full">\
						<p class="submit">\
							<input type="button" id="shortcodes-tabs-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
						</p>\
		</div></div></div>');
		
		var table = form.find('#shortcodes-tabs-form');
		form.appendTo('body').hide();
		
		form.find('.tab2, .tab3, .tab4, .tab5, .tab6').hide();
		
		jQuery('.addTab').click( function() {
			var tab = jQuery(this).attr('rel');
			jQuery('.' + tab).find('input').addClass('activeTitle');
			jQuery('.' + tab).find('textarea').addClass('activeContent');
			jQuery('.' + tab).fadeIn();
		});
		
		form.find('#shortcodes-tabs-submit').click(function(){

			var shortcode = '[tabs] ';
			
			shortcode += '[tabsNav] ';
			
			var i = 1;
			
			while (i < 7) {
				var title = jQuery('#celta_tab_title_' + i).attr('class');
				if (title === 'activeTitle') {
					shortcode += '[tabLink]' + jQuery('#celta_tab_title_' + i).val() + '[/tabLink] ';
				}
				i++;
			}
			
			shortcode += '[/tabsNav] ';
			
			var i = 1;
			
			while (i < 7) {
				var title = jQuery('#celta_tab_content_' + i).attr('class');
				if (title === 'activeContent') {
					shortcode += '[tab id="' + jQuery('#celta_tab_title_' + i).val() + '"]' + jQuery('#celta_tab_content_' + i).val() + '[/tab] ';
				}
				i++;
			}
			
			shortcode += '[/tabs]';
			
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			tb_remove();
		});
	});
})()