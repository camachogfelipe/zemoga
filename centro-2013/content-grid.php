<?php
/**
 * The default template for displaying content.
 *
 * Template name: Grid list
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
get_header();
?>
<div class="template-content template-grid">
	<!-- left sidebar -->
	<aside>
		<nav class="internal-nav">
        	<ul>
            	<?php
					/*$args = array(
						'sort_column'	=> 'menu_order, post_title',
						'depth'			=> 1,
						'title_li'		=> '',
						'post_status'	=> 'publish',
						'link_before'	=> '<em>&gt;</em> ',
						'echo'			=> 0,
						'depth'        => 0
					);
					if($post->post_parent > 0) $args['child_of'] = $post->post_parent;
					else $args['child_of'] = $post->ID;*/
					$args = array(
						'title_li'     => '',
						'post_status'  => 'publish',
						'link_before'  => '<em>&gt;</em> ',
						'depth'        => 0,
						'echo'		   => 0,
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
					$links = wp_list_pages($args);
					//print_r($links);
					generate_menu($links);
					//wp_list_pages( $args );
				?>                
			</ul>
		</nav>

		<div class="callouts">
			<?php get_callout_post(get_the_ID()); ?>
		</div>
	</aside>

	<article id="post-<?php the_ID(); ?>" <?php post_class('layout-standard'); ?>>
		
		<nav class="breadcrumb-nav">
			<ul>
				<?php the_breadcrumb(get_the_ID()); ?>
			</ul>
		</nav>	

		<header class="entry-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>
		
		

<!-- grid content -->
<section class="thumbnail-grid">
	<!-- ul>(((figure>(a>img)+(a)figcaption))li*12) -->
	<table class="content">
		<tr>
			<?php the_content(); ?>
		</tr>
	</table>
</section>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!-- END home grid content -->	

	</article>
	<!-- ./ left sidebar -->
</div>
<!-- ./ template-Grid list -->

<?php get_footer(); ?>

