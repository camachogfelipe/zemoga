<?php
/**
 * The default template for displaying content.
 *
 * Template name: Thank you page
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
get_header();
?>
<div class="template-content template-form">
	<!-- left sidebar -->
	<aside>
		<nav class="internal-nav">
			<ul>
            	<?php
					$args = array(
						'title_li'     => '',
						'post_status'  => 'publish',
						'link_before'  => '<em>&gt;</em> ',
						'depth'        => 0,
						'echo'		   => 1,
						'child_of'	   => get_post_top_ancestor_id(),
						'exclude'	   => get_page_exclude()
					);
					
					/*if($post->post_parent > 0) $args['child_of'] = $post->ID;
					else $args['child_of'] = $post->post_parent;
					$menu = wp_list_pages($args);
					$args['echo'] = 1;
					if(!empty($menu)) :						
						$args['child_of'] = $post->ID;
						wp_list_pages($args);
					else :
						//$parent = get_post($post->post_parent);
						$args['child_of'] = $post->post_parent;
						wp_list_pages($args);
					endif;*/
					wp_list_pages( $args );
				?>                
			</ul>
		</nav>

		<div class="callouts">
			<?php get_callout_post(get_the_ID()); ?>
		</div>
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
		
        <section class="primary-content">
        	<?php the_content(); ?>
		</section>

		<section class="secondary-content">
			<?php
                $co = centro_get_callouts(get_the_id(), "body");
                if(!empty($co)) :
					if(!empty($co[0]['image'])) echo '<img src="'.$co[0]['image'].'" />';
					echo $co[0]['text'];
					if(!empty($co[0]['cta-link'])) :
						echo '<p><a href="'.$co[0]['cta-link'].'" class="default-btn small">';
						echo '<em class="cta-arrow left icon">&raquo;</em>';
						echo '<span>'.$co[0]['cta-label'].'</span>';
						echo '</a></p>';
					endif;
				endif;
            ?>
		</section>


		<?php dynamic_sidebar('common-pages-sidebar-social'); ?>
        <?php dynamic_sidebar('common-pages-sidebar-newsletter'); ?>

	</article>
	<!-- ./template content -->
</div>
<!-- ./ template-Thank you page -->
<?php get_footer(); ?>

