<?php
/**
 * The default template for displaying content.
 *
 * Template name: Blog
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
get_header();
?>
<div class="template-content template-blog">
	<!-- left sidebar -->
	<aside>
		<nav class="internal-nav">
			<ul>
            	<?php
					centro_menu_categories();
				?>                
			</ul>
		</nav>
        <nav id="conect-nav">
			<ul>
				<?php dynamic_sidebar('blog-sidebar'); ?>
                <li class="follow">
					<div>
						Follow Us
                        <?php echo do_shortcode('[social_icons]'); ?>
                    </div>
				</li>
			</ul>
		</nav>
	</aside>

	<div class="layout-standard">
		
		<nav class="breadcrumb-nav">
			<ul>
				<?php
                	$blog = $wp_query->queried_object;
					if(is_single()) : the_breadcrumb(get_the_ID());
					else : the_breadcrumb($blog->ID);
					endif;
				?>
			</ul>
		</nav>	

		<header class="entry-header">
			<h1 class="page-title"><?php echo $blog->post_title; ?></h1>
		</header>
        
        <div class="layout-content content"><?php echo $blog->post_content; ?></div>
        
        <hr />
        
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
		<article class="post-<?php the_ID(); ?> <?php post_class(); ?>" id="post-<?php the_ID(); ?>">
			
			<div class="post-head-area">
				<h4><a rel="bookmark" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<p class="entry-meta">By <span class="author"><?php the_author(); ?></span> on <?php echo get_the_date(); ?></p>
				<div class="social-media"><?php echo st_makeEntries(); ?></div>
			</div>
			<div class="entry-content">
                	<?php
						if ( get_the_post_thumbnail($post->ID) != '' ) {
							echo '<div class="entry-image">';
							echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
							the_post_thumbnail();
							echo '</a>';
							echo '</div>';
						} else {
							$image = catch_that_image();
							if(!is_null($image)) :
								echo '<div class="entry-image">';
								echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
								echo '<img src="';
								echo catch_that_image();
								echo '" alt="" />';
								echo '</a>';
								echo '</div>';
							endif;
						
						}
					?>
						<!--<img alt="thumb-9951" src="http://cambelt.co/410x300/Feat+Image+1?color=006699" style="width:">	-->
				<?php the_excerpt(); ?>
			</div>

			<div class="entry-data">
				<?php $tags_list = get_the_tag_list(' ', ' - '); if ($tags_list): ?>
					<?php printf('<p>Tagged as: <span class="tag-list">%s</span>', $tags_list ); ?>
				<?php endif; ?>
                <a href="<?php comments_link(); ?>" class="link-comments"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></a></p></div>
		</article>
        <?php
        		endwhile;
		?>


		<?php
			if(function_exists('wp_pagenavi') ) :
				echo "<nav>";
				wp_pagenavi();
				echo "</nav>";
			endif;
        ?>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!-- END home grid content -->	

	</div>
	<!-- ./ left sidebar -->
</div>
<!-- ./ template-blog -->

