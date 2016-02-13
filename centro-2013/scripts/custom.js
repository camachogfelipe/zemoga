jQuery(document).ready(function() {

	jQuery('#footer .one-fourth').last().addClass('last');
	jQuery('.widget_categories ul').addClass('sidebar-menu arrows-1');
	jQuery('blockquote.alignleft').addClass('pull-left');
	jQuery('blockquote.alignright').addClass('pull-right');
	jQuery('.pricing-column li:even').addClass('even');
	
//TOGGLE PANELS

	jQuery('.toggle-content').hide();  //hides the toggled content, if the javascript is disabled the content is visible

	jQuery('.toggle-link').click(function () {
		if (jQuery(this).is('.toggle-close')) {
			jQuery(this).removeClass('toggle-close').addClass('toggle-open').parent().next('.toggle-content').slideToggle(300);
			return false;
		} 
		
		else {
			jQuery(this).removeClass('toggle-open').addClass('toggle-close').parent().next('.toggle-content').slideToggle(300);
			return false;
		}
	});
		
});	//END of jQuery


jQuery(function(jQuery) {

	jQuery('.custom_upload_image_button').click(function() {
		formfield = jQuery(this).siblings('.custom_upload_image');
		preview = jQuery(this).siblings('.custom_preview_image');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			classes = jQuery('img', html).attr('class');
			id = classes.replace(/(.*?)wp-image-/, '');
			formfield.val(id);
			preview.attr('src', imgurl);
			preview.attr('width', 200);
			tb_remove();
		}
		return false;
	});

	jQuery('.custom_clear_image_button').click(function() {
		var defaultImage = jQuery('.custom_default_image').text();
		jQuery(this).parent().parent().find('.custom_upload_image').val('');
		jQuery(this).parent().parent().find('.custom_preview_image').attr('src', "");
		jQuery(this).parent().parent().find('.custom_preview_image').attr('width', 0);
		return false;
	});
});





