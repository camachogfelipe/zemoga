<?php
// slide Post Meta Box
$meta_box_slide = array(
	'id' => 'slide-meta-box',
	'title' => __( 'Slide Settings' ),
	'page' => 'slide',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Custom Link',
			'desc' => 'If you want to display a "Continue Reading" button, write its URL here.',
			'id'   => $prefix . 'slide_link',
			'type' => 'text',
			'std'  => ''
		),
		array(
			'name' => 'Color of button',
			'desc' => 'Color of button if you want to display a "Continue Reading"',
			'id'   => $prefix . 'slide_color_button',
			'type' => 'select',
			'options' => array("light", "dark"),
			'std'  => 'Dark'
		)
	)
);

function centro_slide_add_box() {
	global $meta_box_slide;
	add_meta_box($meta_box_slide['id'], $meta_box_slide['title'], 'centro_slide_show_box', $meta_box_slide['page'], $meta_box_slide['context'], $meta_box_slide['priority']);
}

function centro_slide_show_box() {
	global $meta_box_slide, $post;
	echo '<input type="hidden" name="centro_slide_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
		foreach ($meta_box_slide['fields'] as $field) {
			$meta = get_post_meta($post->ID, $field['id'], true);
			echo '<tr>',
					'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
					'<td>';
			switch ($field['type']) {
				case 'text':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:65%" />',
						'<br />', $field['desc'];
					break;
				case 'upload':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:65%" /><input class="optionsUploadButton" type="button" value="Upload Image" />',
						'<br />', $field['desc'];
					break;
				case 'textarea':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
						'<br />', $field['desc'];
					break;
				case 'select':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					foreach ($field['options'] as $option) {
						echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
					echo '</select>';
					break;
				case 'radio':
					foreach ($field['options'] as $option) {
						echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
					}
					break;
				case 'checkbox':
					echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />',
						$field['desc'];
					break;
			}
			echo '<td>';
			echo '</tr>';
		}
	echo '</table>';
}

function centro_slide_save_data($post_id) {
	global $meta_box_slide;
	if ( isset( $_POST['centro_slide_meta_box_nonce'] ) && !wp_verify_nonce($_POST['centro_slide_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	foreach ($meta_box_slide['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		if ( isset( $_POST[$field['id']] ) )
			$new = $_POST[$field['id']];
		
		if ( isset( $new ) && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ( isset( $new ) && '' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
?>