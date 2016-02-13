<?php
/**
 * The Homepage Featured Content.
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>
<!-- home featured content -->
<section class="carousel">
	<?php 

	$slides = get_slide(); 
	
	if(!empty($slides)): 

	?>
	<ul class="container l-inline">
    	<?php
		//AppDev: Felipe Camacho
		// Function for post-slide		
		
		foreach($slides as $slide) :
			$image = centro_resize(NULL, $slide['image'][0], 1300, 538, true);
			
			$slideLinkClass = (isset($slide['centro_slide_color_button']) and $slide['centro_slide_color_button'] === "dark"
) ? " light-bg" : "";                    
		?>
			<li class="item">
				<a href="<?php echo $slide['centro_slide_link'] ?>">
					<img src="<?php echo $image['url']; ?>" />
				</a>
				<!-- 
				<div class="content">
					<p><?php echo $slide['content']; ?></p>
					<a href="<?php echo $slide['centro_slide_link'] ?>" class="default-btn<?php echo $slideLinkClass; ?>">
						<span>Learn More</span>
						<em class="cta icon">&raquo;</em>
					</a>
				</div>
				-->
			</li>
		<?php 
		endforeach;
		?>
	</ul>
    <?php endif; ?>
	<a href="#" class="arrow left alpha sprite-item">&lt;</a>
	<a href="#" class="arrow right alpha sprite-item">&gt;</a>
</section>
<!-- END home featured content -->