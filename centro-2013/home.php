<?php
/**
 * The default template for home
 *
 * Template name: Homepage
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
get_header();

if(is_home() && !is_front_page()) :
	get_template_part('content', 'blog');
endif;

if (isset($_GET['partial'])) :
    include('partials/' . $_GET['partial'] . '.html');
	exit();
endif;

if(is_front_page()) :
?>
<!-- home grid content -->
<section class="home-content l-grid">
    <?php
        $counter = 1;
        $coh = centro_get_callouts(NULL, "homepage");
        $numCoh = count($coh);

        if ($numCoh <= 3) :
            foreach($coh as $co) :
                 $tracking = array();
                $itemClass = ($counter === 3) ? ' last-child' : '';

                if ($co['media'] !== ""):
                    $itemClass .= ' video-item';
                endif;
				//echo "<pre>";print_r($co);echo "</pre>";
				if(isset($co['cta-event-category'])) $tracking[] = 'data-event-category="'.$co['cta-event-category'].'"';
				if(isset($co['cta-event-action'])) $tracking[] = 'data-event-action="'.$co['cta-event-action'].'"';
				if(isset($co['cta-event-label'])) $tracking[] = 'data-event-label="'.$co['cta-event-label'].'"';
        ?>
        <article class="grid-item<?php echo $itemClass; ?>">
            <?php if (isset($co['cta-link']) && $co['cta-link'] != "") : ?>
            <a href="<?php echo $co['cta-link']; ?>"<?php
					if(!empty($tracking)) :
						echo "onClick=\"_gaq.push(['_trackEvent', '";
						if(isset($co['cta-event-category'])) echo $co['cta-event-category'];
						echo "', '";
						if(isset($co['cta-event-action'])) echo $co['cta-event-action'];
						echo "', '";
						if(isset($co['cta-event-label'])) echo $co['cta-event-label'];
						echo "']);\"";
					endif;
                ?>>
            <?php else: ?>
            <a href="javascript:;">
            <?php endif; ?>
                <h3><?php echo $co['headline']; ?></h3>
            </a>
           
        <?php if ($co['media'] !== ""): 


            $ytMatches = preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $co['media'], $matches);

            $video_url = str_replace("[/youtube]", "", $matches[0]);
       ?>
      
            <div class="yt-video-player" data-yt-id="<?php echo $co['id']; ?>" data-yt-key="<?php echo $video_url; ?>">
                <?php //echo do_shortcode($co['media']); ?>
                <div id="video-player-<?php echo $co['id']; ?>"></div>
                <a class="video-player-button" href="#"<?php
					if(!empty($tracking)) echo " ".implode(" ", $tracking);
                ?>>
                    <img src="<?php
                        $image = centro_resize(NULL, $co['image'], 260, 200, true);
                        echo $image['url'];
                    ?>" alt="<?php echo $co['headline']; ?>" >
                </a>
            </div>
            <p>
                <?php echo $co['text']; ?>
            </p>
        <?php else: ?>
        	<div>
            <a href="<?php echo $co['cta-link']; ?>"<?php
					if(!empty($tracking)) echo " ".implode(" ", $tracking);
                ?>>
                <img src="<?php
                    $image = centro_resize(NULL, $co['image'], 285, 150, true);
                    echo $image['url'];
                ?>" alt="<?php echo $co['headline']; ?>" >
                <p>
                    <?php echo $co['text']; ?>
                </p>
			</a>
            </div>
        <?php endif; ?>
            
        </article>

    <?php
                $counter++;
            endforeach;
        endif;
        
    ?>

</section>
<!-- END home grid content -->

<?php
endif;

get_footer();
?>