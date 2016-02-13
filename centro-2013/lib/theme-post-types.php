<?php
function centro_post_types() {
	register_post_type( 'slide',
		array(
			'labels' => array(
				'name' => __( 'Slider Items' ),
				'singular_name' => __( 'Slide' ),
				'add_new' => __( 'Add New Slide' ),
				'add_new_item' => __( 'Add New Slide' ),
				'edit' => __( 'Edit Slide' ),
				'edit_item' => __( 'Edit Slide' ),
			),
			'description' => __( 'Slider Items.' ),
			'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);/*
	define('EP_THANKYOU', 131072); // 2^17. 2^13 is used by core.
	register_post_type( 'centro_thankyou_page',
		array(
			'labels' => array(
				'name' => __( 'Thank you pages' ),
				'singular_name' => __( 'Thank you page' )
			),
			'hierarchical' => true,
			'show_ui' => true,
			'description' => __( 'Thank you pages.' ),
			'public' => true,
			'capability_type' => 'page',
			'supports' => array( 'title',
								 'editor', 
								 'author', 
								 'thumbnail', 
								 'page-attributes' ),
			'exclude_from_search' => true,
			'menu_position' => 20,
			'permalink_epmask' => EP_THANKYOU,
		)
	);
	add_rewrite_endpoint('history', EP_THANKYOU);*/
}
?>