<?php
/**
 * The default template for displaying content.
 *
 * Template name: Upcoming events & Press releases
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
get_header();

$isEvents = (get_the_title() == 'Events') ? true : false;

if (!$isEvents) {
	$fullSizeClass = ' template-press';
	$readMoreLabel = 'Read the entire story';
} else {
	$fullSizeClass = '';
	$readMoreLabel = 'Read More';
}

?>
<div class="template-content template-events<?php echo $fullSizeClass; ?>">
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
		<!--
		<nav id="conect-nav">
			<ul>
				<li class="blog"><a href="#">Sign Up<br />for the Blog<span></span></a></li>
			</ul>
		</nav>
		-->
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
		
		<section class="primary-content">
			<?php the_content(); ?>
		</section>

		<section class="list-content">
        	<ul>
			<?php
				global $wp_query;
				$current_page_base = get_permalink();
				$q = new WP_Query( $GLOBALS["ARGS"] );
				
				$meta = get_post_custom($post->ID);
				unset($GLOBALS["ARGS"]);
				if ( have_posts() ) :
					while ( $q ->have_posts() ) : $q->the_post();
						$meta = get_post_custom($post->ID);
						//print_r($post);
						?>
						<li class="list-item">
						<?php
						if(isset($meta['wpcf-event-image']) and !empty($meta['wpcf-event-image'][0])) :
						?>
							<div class="list-item-image">
								<img alt="" src="<?php echo $meta['wpcf-event-image'][0]; ?>">
							</div>
						<?php
						endif;

						//	in the press
						if (isset($meta['wpcf-press-url']) and !empty($meta['wpcf-press-url'][0])) :
							$itemURL = $meta['wpcf-press-url'][0];
							$targetURL = 'target="_blank"';
						//	default read more hyperlink (events, press releases)
						else:
							$itemURL = get_permalink($post->ID);
							$targetURL = '';
						endif;

						$title = get_the_title();
						?>
							<a href="<?php echo $itemURL; ?>"<?php echo $targetURL; ?>><h3><?php echo $title; ?></h3></a>
						<?php
						if(isset($meta['wpcf-event-location']) and !empty($meta['wpcf-event-location'][0])) :
						?>
							<p><strong><?php echo $meta['wpcf-event-location'][0]; ?></strong></p>
						<?php
						endif;
						if(isset($post->post_excerpt) and !empty($post->post_excerpt)) :
						?>
							<p><?php echo $post->post_excerpt; ?></p>
						<?php
						else :
						?>
							<p><?php echo $post->post_content; ?><p>
						<?php
						endif;
						?>
							<ul class="footer l-inline">
						<?php
						if(isset($meta['wpcf-event-dates'][0]) and !empty($meta['wpcf-event-dates'][0])) :
						?>
							<li>
								<time datetime="<?php echo $meta['wpcf-event-date1'][0]; ?>">
									<em class="icon">Date:</em>
									<?php
                                        echo $date = centro_date_format($meta['wpcf-event-dates'][0]);
                                    ?>
								</time>
							</li>
						<?php
						endif;
						?>
						<li><summary><em class="icon">more</em><a href="<?php echo $itemURL; ?>" <?php echo $targetURL; ?> ><?php echo $readMoreLabel; ?></a></summary></li>
						<?php
						if ($isEvents) :
						?>
							<li>
								<div class="share">
									<summary><em class="icon">share</em><a href="#">share</a></summary>
									<div class="share-content">
										<span class='st_facebook_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_twitter_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_plusone_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_linkedin_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_email_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='Email'></span>
									</div>
								</div>
							</li>
						<?php
						endif;
						?>
						</ul>
						</li>
					<?php
					endwhile;
				endif;
            ?>
            </ul>
		</section>

       	<?php
			if ($q->max_num_pages > 1):
				if(function_exists('wp_pagenavi') ) :
					echo "<nav>";
					wp_pagenavi(array('query' => $q));
					wp_reset_postdata();	// avoid errors further down the page
					echo "</nav>";
				else :
					centro_content_nav($current_page_base);
				endif;
			endif;
        ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!-- END home grid content -->	

	</article>
	<!-- ./ left sidebar -->
</div>
<!-- ./ template-Upcoming events & Press releases -->
<?php get_footer(); ?>

