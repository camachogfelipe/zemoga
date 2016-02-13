<?php
/**
 * The template for displaying 404 pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
?>
<?php
	$nfpage = get_page(get_page_by_path('not-found'));
?>
<?php get_header(); ?>
<div class="template-content template-404">
	<h2>404 Error</h2>
	<h3>Sorry, page not found</h3>
	<a href="/" class="default-btn light-skin">
        <span>GO TO HOME PAGE</span>
        <em class="cta icon">»</em>
    </a>
</div>
<?php get_footer(); ?>