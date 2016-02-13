<?php
/**
 * The default template for displaying content.
 *
 * Template name: Connect with us
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
		
		<?php
			$co = centro_get_callouts(get_the_id(), "body");
			if(!empty($co)) echo $co[0]['text'];
        ?>

		<!--<p class="required-info">(<em>*</em>) Required Field</p>-->

		
		<div class="layout-content content form-wrapper">
			<?php the_content(); ?>
		</div>


		<?php dynamic_sidebar('common-pages-sidebar-social'); ?>
        <?php dynamic_sidebar('common-pages-sidebar-newsletter'); ?>

	</article>
	<!-- ./template content -->
</div>
<!-- ./ template-Connect with us -->
<?php get_footer(); ?>

