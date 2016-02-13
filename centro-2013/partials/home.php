<!-- home grid content -->
<section class="home-content l-grid">
	<?php
    	$coh = centro_get_callouts(NULL, "homepage");
    	$numCoh = count($coh);
    	if ($numCoh <= 3) :
    		foreach($coh as $co) :
    	?>
	    <article class="grid-item">
			<a href="#"><h3><?php echo $co['headline']; ?></h3></a>
		<?php if ($co['media'] !== ""): ?>
			<?php echo do_shortcode($co['media']); ?>
		<?php else: ?>
			<img src="<?php
            	$image = centro_resize(NULL, $co['image'], 285, 150, true);
                echo $image['url'];
			?>" alt="<?php echo $co['headline']; ?>" >
		<?php endif; ?>
			<p>
				<?php echo $co['text']; ?>
			</p>
		</article>

    <?php
        	endforeach;
    	endif;
        
    ?>

</section>
<!-- END home grid content -->