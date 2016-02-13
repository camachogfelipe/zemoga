<?php
/**
 * The default template for displaying content.
 *
 * Template name: Our Offices
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
get_header();
?>

<div class="template-content template-jobvite">
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
		
		<!-- grid content -->
<section class="offices-location">
	<?php $lo = centro_get_locations(); ?>
	<div class="map-wrapper">
		<iframe id="gmap" name="gmap" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php
			echo str_replace(" ", "+", $lo[0]['office-name']);
			echo "+".str_replace(" ", "+", $lo[0]['address']);
		?>
        &amp;aq=&amp;sll=40.74477,-73.988929&amp;sspn=0.009413,0.022724&amp;ie=UTF8&amp;hq=<?php
			echo str_replace(" ", "+", $lo[0]['office-name']);
			echo "+".str_replace(" ", "+", $lo[0]['address']);
		?>
        &amp;hnear=&amp;radius=15000&amp;t=m&amp;cid=10354101757267349184&amp;z=13&amp;iwloc=&amp;z=16&amp;output=embed"></iframe>
	</div>		
	<section class="l-grid">
		<ul>
        	<?php
				$i = 0;
				foreach($lo as $location) :
					echo '<li class="grid-item">';
					echo "\n\t<dl>";
					echo "\n\t\t<dt>";
					echo "\n\t\t\t<h4>";
					echo "\n\t\t\t\t";
					echo '<a target="gmap"';
					if($i == 0) echo ' class="current"';
					echo ' href="';
					echo 'http://maps.google.en/maps?f=q&hl=en&geocode=&q=';
					echo str_replace(" ", "+", $location['address']);
					echo "+".str_replace(" ", "+", $location['state']);
					//echo '&amp;aq=&amp;ie=UTF8&amp;hq=';
					//echo '&amp;aq=&amp;sll=40.74477,-73.988929&amp;sspn=0.009413,0.022724&amp;ie=UTF8&amp;hq=';
					//echo str_replace(" ", "+", $location['office-name']);
					//echo "+".str_replace(" ", "+", $location['address']);
					echo '&amp;radius=15000&amp;t=m&amp;output=embed';
					//echo '&amp;hnear=&amp;radius=15000&amp;t=m&amp;cid=10354101757267349184&amp;z=13&amp;iwloc=&amp;z=16&amp;output=embed';
					echo '"><em class="active icon">^</em>';
					echo $location['region'];
					echo '</a>';
					echo "\n\t\t\t</h4>";
					echo "\n\t\t</dt>";
					echo "\n\t\t<dd>";
					echo "\n\t\t\t".'<div class="vcard">';
					echo "\n\t\t\t\t".'<div class="org">'.$location['office-name'].'</div>';
					echo "\n\t\t\t\t".'<div class="adr">';
					echo "\n\t\t\t\t\t".'<div class="street-address">';
					echo $location['address'];
					if(!empty($location['address-options'])) echo "<br>".$location['address-options'];
					echo '</div>';
					$location['state'] = explode(" ", $location['state']);
					echo "\n\t\t\t\t\t".'<span class="locality">'.$location['state'][0].'</span>';
					echo "\n\t\t\t\t\t".'<span class="region">'.$location['state'][1].'</span>';
					echo "\n\t\t\t\t\t".'<span class="postal-code">'.$location['state'][2];
					if(isset($location['state'][3])) echo " ".$location['state'][3].'</span>';
					echo "\n\t\t\t\t".'</div>';
					echo "\n\t\t\t\t".'<div class="tel">Phone: '.$location['phone']."</div>";
					echo "\n\t\t\t\t".'<a title="email" href="mailto:'.antispambot($location['email'],1).'">';
					echo antispambot($location['email'],0)."</a>";
					echo "\n\t\t\t</div>";
					echo "\n\t\t</dd>";
					echo "\n\t</dl>";
					echo '</li>';
					$i++;
				endforeach;
			?>
		</ul>
	</section>
</section>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!-- END home grid content -->

	</article>
	<!-- ./template content -->
</div>
<!-- ./ template-xx -->
<?php get_footer(); ?>
