<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('item'); ?>>
	<?php the_post_thumbnail(); ?>
	<header>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
			<h3><?php the_title(); ?></h3>
		</a>
		<time datetime="<?php the_time('Y-m-d'); ?>"><?php the_date(); ?> - <?php the_time(); ?></time>
	</header>
	
	<div class="entry">
		<p><?php the_excerpt(); ?></p>
	</div>
	<!--<p class="postmetadata">Post Meta Data Section</p>-->
</article>
