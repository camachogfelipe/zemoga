<?php
/**
 * The Homepage for our theme.
 *
 * Displays all the homepage content
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>

<?php get_header(); ?>

<!-- Add your site or application content here -->

<?php get_sidebar(); ?>

<?php if(is_home()) get_footer(); ?>