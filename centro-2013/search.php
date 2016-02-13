<?php
/**
 * The search page for our theme.
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'centro' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header>

	<?php //twentyeleven_content_nav( 'nav-above' ); ?>

	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php
			/* Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );
		?>

	<?php endwhile; ?>

	<?php //twentyeleven_content_nav( 'nav-below' ); ?>

<?php else : ?>

	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Nothing Found', 'centro' ); ?></h1>
		</header><!-- END .entry-header -->

		<div class="entry-content">
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'centro' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- END .entry-content -->
	</article><!-- END #post-0 -->

<?php endif; ?>

<?php get_footer(); ?>