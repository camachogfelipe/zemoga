<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
get_header();
?>

<?php if ( have_posts() ) : ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="template-content template-blog-detail">
	<!-- left sidebar -->
	<aside>
		<nav class="internal-nav">
			<ul>
            	<?php
					$post_categories = get_the_category($post->ID);
					if(count($post_categories) == 1) :
						$categoryid = $post_categories[0]->term_id;
					endif;
					centro_menu_categories($categoryid);
				?>
			</ul>
		</nav>
        
        <nav id="conect-nav">
			<ul>
				<?php dynamic_sidebar('blog-sidebar'); ?>
                <li class="follow">
					<div>
						Follow Us
						<!--<a class="twitter" href="#">twitter</a>
						<a class="facebook" href="#">facebook</a>
						<a class="youtube" href="#">youtube</a>
						<a class="linkedin" href="#">linkedin</a>
						<a class="google" href="#">google</a>
						<a class="rss" href="#">rss</a>-->
                        <?php echo do_shortcode('[social_icons]'); ?>
                    </div>
				</li>
			</ul>
		</nav>
	</aside>
	<!-- ./ left sidebar -->
	
	<!-- template content -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('layout-standard'); ?>>
		<!-- breadcrumb -->
		<nav class="breadcrumb-nav">
			<ul>
				<?php the_breadcrumb(get_the_ID()); ?>
			</ul>
		</nav>	
		<!-- ./breadcrumb -->

		<header class="entry-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>
        <div class="post-head-area">
            <p class="entry-meta">By <span class="author"><?php the_author(); ?></span> on <?php echo get_the_date(); ?></p>
        </div>
		
		<div class="layout-content content"><?php the_content(); ?></div>
        
        <div class="social-media"><?php echo st_makeEntries(); ?></div>
        
        <div class="entry-data">
			<?php $tags_list = get_the_tag_list(' ', ' - '); if ($tags_list): ?>
                <?php printf('<p>Tagged as: <span class="tag-list">%s</span>', $tags_list ); ?>
            <?php endif; ?>
            <a href="<?php comments_link(); ?>" class="link-comments"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></a></p>
        </div>
        
        <?php //if ( comments_open( $post_id ) and is_home() ) : ?>
        	<?php comments_template( '', true ); ?>
		<?php //endif;?>

	</article>
	<!-- ./template content -->
</div>
<!-- ./ template-single -->

<?php endwhile;?>

<?php endif;?>

<?php get_footer(); ?>