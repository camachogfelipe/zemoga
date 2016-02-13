<?php
if ( ! is_admin() ) {

	// Include jQuery
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'jquery-ui-core-cdn', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js', false, '1.0' );
	wp_enqueue_script( 'jquery-ui-core-cdn' );
	
	// Include Easing script
	wp_register_script( 'centro_easing', get_template_directory_uri() . '/scripts/easing.js', false, '1.0' );
	wp_enqueue_script( 'centro_easing' );
	
	// Include Cycle script
	wp_register_script( 'centro_cycle', get_template_directory_uri() . '/scripts/jquery.cycle.all.js', false, '1.0' );
	wp_enqueue_script( 'centro_cycle' );
	
	// Include Tools script
	wp_register_script( 'centro_tools', get_template_directory_uri() . '/scripts/jquery.tools.min.js', false, '1.0' );
	wp_enqueue_script( 'centro_tools' );
	
	// Include Custom jQuery script
	wp_register_script( 'centro_custom', get_template_directory_uri() . '/scripts/custom.js', false, '1.0' );
	wp_enqueue_script( 'centro_custom' );

}

function add_admin_scripts( $hook ) {
	global $post;
	if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		// Include Custom jQuery script
		wp_register_script( 'centro_custom', get_template_directory_uri() . '/scripts/custom.js', false, '1.0' );
		wp_enqueue_script( 'centro_custom' );
	}
}
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );
?>