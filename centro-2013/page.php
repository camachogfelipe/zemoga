<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>

<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'content', 'page' ); ?>

	 <?php if ( comments_open( $post_id ) and is_home() ) : ?>
		<?php comments_template( '', true ); ?>
    <?php endif;?>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>