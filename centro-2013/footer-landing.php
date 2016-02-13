<?php
/**
 * The landing Footer for our theme.
 *
 * Displays all of the <footer> section and all Javascript scripts included in the site
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */

$nlFooterClass = (!dynamic_sidebar('landing-pages-sidebar-left')) ? 'newsletter-disabled' : '';
?>

            </div> <!-- END #content -->

            <footer id="footer">
                <div class="footer-primary">
                    <!-- footer-landing -->
                    <!-- 
                        For hide the newsletter block using CSS, please add the following class to .footer-landing 
                        <div class="layout-container footer-landing newsletter-disabled">
                    -->
                    <div class="layout-container footer-landing <?php echo $nlFooterClass; ?>">
                        	<?php dynamic_sidebar('landing-pages-sidebar-left'); ?>
                            <?php
								if(!dynamic_sidebar('landing-pages-sidebar-left')) :
									dynamic_sidebar('landing-pages-sidebar-right');
								else : dynamic_sidebar('landing-pages-sidebar-right');
								endif;
							?>
                    </div>
                    <!-- ./ footer-landing -->
                </div>
            </footer>
            <div class="shadow-right"></div>
        </div> <!-- END #wrap -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.3.min.js"><\/script>')</script>
        
        <script src="<?php echo get_template_directory_uri(); ?>/js/bin/centro.all.js"></script>
        
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
        /*
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        */
        </script>

        <?php wp_footer(); ?>
    </body>
</html>