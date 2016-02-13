<?php
/**
 * The default template for displaying content.
 *
 * Template name: Landing page
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
get_header();
?>
<div class="template-content template-landing template-form">
	
	<!-- template content -->
    <?php
		$co = centro_get_callouts(get_the_id(), "body");
		$content = get_the_content();
		if(!empty($co)) :
    ?>
        <article id="post-<?php the_ID(); ?>" <?php
			
			if(empty($content)) : post_class('layout-standard full-column');
			else : post_class('layout-standard');
			endif;
        ?>>
            <?php
				if(isset($co[0]['image']) and !empty($co[0]['image'])) :
					echo '<img src="'.$co[0]['image'].'" />';
				endif;
				echo '<header class="entry-header">';
				echo '<h1 class="page-title">'.get_the_title().'</h1>';
				echo '</header>';
				echo '<div class="layout-content content">'."\n\t";
				echo '<h3>'.$co[0]['headline'].'</h3>';
				echo $co[0]['text'];
				echo '</div>';
            ?>
    
        </article>
	<!-- ./template content -->
	<?php
	endif;

    if(!empty($content)) :?>
	<!-- right sidebar (form) -->
	<aside <?php
		if(empty($co)) post_class('full-column');
    ?>>
    	<?php if(empty($co)) : ?>
    	<header class="entry-header">
        	<h3><?php the_title(); ?></h3>
		</header>
		<?php endif; ?>
		<?php the_content(); ?>
    
    <?php endif; ?>

	</aside>
	<!-- ./ left sidebar -->
</div>
<!-- ./ template-Landing page -->

<?php get_footer('landing'); ?>