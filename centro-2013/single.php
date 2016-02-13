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
					//echo "<pre>";print_r($GLOBALS);echo "</pre>";
					if(preg_match('/in-the-press/', $_SERVER['REQUEST_URI']) == true) :
						echo '<li class="page_item page-item-8544 current_page_item">';
						echo '<a href="'.get_option('home').'/news/recent-in-the-press"><em>&gt;</em> In the Press</a></li>';
						echo '<li class="page_item page-item-8176">';
						echo '<a href="'.get_option('home').'/news/press"><em>&gt;</em> Press Releases</a></li>';
						echo '<li class="page_item page-item-1023">';
						echo '<a href="'.get_option('home').'/news/upcoming-events"><em>&gt;</em> Events</a></li>';
					elseif(	(preg_match('/press-releases/', $_SERVER['REQUEST_URI']) == true) || 
							(preg_match('/press/', $_SERVER['REQUEST_URI']) == true)) :
						echo '<li class="page_item page-item-8544">';
						echo '<a href="'.get_option('home').'/news/recent-in-the-press"><em>&gt;</em> In the Press</a></li>';
						echo '<li class="page_item page-item-8176 current_page_item">';
						echo '<a href="'.get_option('home').'/news/press"><em>&gt;</em> Press Releases</a></li>';
						echo '<li class="page_item page-item-1023">';
						echo '<a href="'.get_option('home').'/news/upcoming-events"><em>&gt;</em> Events</a></li>';
					elseif(preg_match('/event/', $_SERVER['REQUEST_URI']) == true) :
						echo '<li class="page_item page-item-8544">';
						echo '<a href="'.get_option('home').'/news/recent-in-the-press"><em>&gt;</em> In the Press</a></li>';
						echo '<li class="page_item page-item-8176">';
						echo '<a href="'.get_option('home').'/news/press"><em>&gt;</em> Press Releases</a></li>';
						echo '<li class="page_item page-item-1023 current_page_item">';
						echo '<a href="'.get_option('home').'/news/upcoming-events"><em>&gt;</em> Events</a></li>';
					elseif(preg_match('/executive-team/', $_SERVER['REQUEST_URI']) == true) :
						//$post = get_the_ID();
						global $wpdb;
						$table_name = $wpdb->prefix."posts";
						$post_parent = $wpdb->get_var("SELECT post_parent FROM $table_name WHERE post_name='executive-team' AND post_status='publish'");
						$args = array(
							'sort_column'	=> 'menu_order, post_title',
							'depth'			=> 1,
							'title_li'		=> '',
							'post_status'	=> 'publish',
							'link_before'	=> '<em>&gt;</em> ',
							'echo'			=> 0,
							'child_of'		=> $post_parent,
							'exclude'	   => get_page_exclude()
						);
						$links = wp_list_pages($args);
						$GLOBALS["EXECUTIVE"] = true;
						generate_menu($links, true, $post_parent);
						//echo "<pre>";print_r($links);echo "</pre>";
					else :					
						$args = array(
							'sort_column'  => 'menu_order, post_title',
							'title_li'     => '',
							'post_status'  => 'publish',
							'link_before'  => '<em>&gt;</em> ',
							'depth'        => 1,
							'echo'		   => 0,
							'exclude'	   => get_page_exclude()
						);
						if($post->post_parent > 0) $args['child_of'] = $post->ID;
						else $args['child_of'] = $post->post_parent;
						$menu = wp_list_pages($args);
						$args['echo'] = 1;
						if(!empty($menu)) :						
							$args['child_of'] = $post->ID;
							wp_list_pages($args);
						else :
							$parent = get_post($post->post_parent);
							$args['child_of'] = $parent->post_parent;
							wp_list_pages($args);
						endif;
					endif;
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
		
		<div class="layout-content content"><?php the_content(); ?></div>
        
        <?php if ( comments_open( $post->ID ) and is_home() ) : ?>
        	<?php comments_template( '', true ); ?>
		<?php endif;?>

	</article>
	<!-- ./template content -->
</div>
<!-- ./ template-single -->

<?php endwhile;?>

<?php endif;?>

<?php get_footer(); ?>