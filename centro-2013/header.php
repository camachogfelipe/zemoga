<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
         <title><?php
				if ( is_front_page() ) {
					bloginfo( 'name' );
				} elseif ( is_category() ) {
					_e( 'Category: ', LANGUAGE ); wp_title( );
				} elseif ( function_exists( 'is_tag' ) && is_tag() ) {
					single_tag_title( __( 'Tag Archive for &quot;', LANGUAGE ) );
				} elseif ( is_archive() ) {
					wp_title( '' ); _e( ' Archive - ', LANGUAGE );
				} elseif ( is_page() ) {
					echo wp_title( );
				} elseif ( is_search() ) {
					_e( 'Search for &quot;', LANGUAGE ); echo esc_html( $s );
				} elseif ( ! ( is_404() ) && ( is_single() ) || ( is_page() ) ) {
					wp_title( '' ) ; echo ' - ';
				} elseif ( is_404() ) {
					_e( 'Not Found - ', LANGUAGE );
				}
			 ?></title>
        <meta name="description" content="<?php
        if (is_single()) {
            single_post_title();
        } else {
            bloginfo('description');
        }
        ?>
        ">
        <meta name="viewport" content="width=device-width">

        <?php
			global $options;
			foreach ( $options as $value ) {
				if ( isset( $value['id'] ) ) {
					if ( get_option( $value['id'] ) === FALSE ) {
						$$value['id'] = $value['std'];
					} else {
						$$value['id'] = get_option( $value['id'] );
					}
				}
			}
		?>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        
        <link rel="shortcut icon" href="<?php echo $centro_favicon; ?>" />

        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/normalize.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />

        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

        <?php wp_head(); ?> 
    </head>
    <body <?php body_class(); ?>>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div id="wrap">
            <div class="shadow-left"></div>
            <header id="header">
                <div class="layout-container">
                    <a href="<?php echo home_url( '/' ); ?>" class="logo sprite-item" title="Centro Home">
                        Centro
                    <!-- <img src="<?php echo get_stylesheet_directory_uri() ?>/_img/centro_logo.png" alt="Centro: <?php bloginfo('description'); ?>" class="top_logo_alt"> -->
                    </a>
                    
                     <!-- search form -->
                    <?php get_search_form( true ); ?>
                    <!-- END search form -->

                    <!-- top menu -->
                    <?php
                    $defaults = array(
                        'theme_location'    => 'top_menu',
                        'menu'              => '',
                        'container'         => 'nav',
                        'container_class'   => 'main-nav l-stacked-right',
                        'container_id'      => '',
                        'menu_class'        => '',
                        'menu_id'           => '',
                        'echo'              => true,
                        'fallback_cb'       => 'wp_page_menu',
                        'before'            => '',
                        'after'             => '',
                        'link_before'       => '',
                        'link_after'        => '',
                        'items_wrap'        => '<ul>%3$s</ul>',
                        'depth'             => 0,
                        'walker'            => ''
                    );

                    wp_nav_menu( $defaults );

                    ?>
                    <!-- END top menu -->
                </div>
                
            </header>
            <?php
				if (is_front_page()) :
					get_template_part('content', 'featured');
				endif;
			?>

            <?php get_template_part('header', 'nav'); ?>

			<div id="content">