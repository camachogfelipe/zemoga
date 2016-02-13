<?php
/**
 * The Footer for our theme.
 *
 * Displays all of the <footer> section and all Javascript scripts included in the site
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>

            </div> <!-- END #content -->

            <footer id="footer">               
               <div class="footer-primary">
                    <!-- footer menu -->
                    <?php
                    
                    $defaults = array(
                        'theme_location'    => 'footer_menu',
                        'menu'              => '',
                        'container'         => 'nav',
                        'container_class'   => 'footer-nav layout-container',
                        'container_id'      => '',
                        'menu_class'        => '',
                        'menu_id'           => '',
                        'echo'              => true,
                        'fallback_cb'       => 'wp_page_menu',
                        'before'            => '',
                        'after'             => '',
                        'link_before'       => '',
                        'link_after'        => '',
                        'items_wrap'        => '<hr><ul class="l-inline">%3$s</ul>',
                        'depth'             => 2,
                        'walker'            => ''
                    );

                   wp_nav_menu( $defaults );
                    

                    ?>

                </div>
                <!-- END footer menu -->

                <div class="footer-secondary">
                    
                    <div class="l-inline layout-container">
                        <a href="/contact/newsletters/" class="sign-news" title="Check out our Newsletters"><i class="icon icon-news"></i> Check out our Newsletters</a>
                        
                        <?php get_template_part('social', 'nav'); ?>
                        
                        <nav class="software-nav l-inline l-stacked-right">
                            <h3>Do you know our software?</h3>
                            <ul class="l-inline">
                            	<?php dynamic_sidebar('footer'); ?>
                                <!--<li><a href="/agencies/software/planner/see-it/" class="default-btn" title="See It">See it</a></li>
                                <li><a href="http://staging.centro.net" onclick="javascript:_gaq.push(['_trackEvent','outbound-article','']);" target="_blank" class="default-btn" title="Try It">Try it</a></li>-->
                            </ul>
                        </nav>

                    </div>
                    
                </div>
            </footer>
            <div class="shadow-right"></div>
        </div> <!-- END #wrap -->

        <!-- modal -->
        <div class="modal"></div>


        <!--    modal content     -->
        <div class="modal-box">
            <header>
                <h4 class="modal-title"></h4>
                <a href="#" class="close-btn" title="Close">X</a>
            </header>
            
            <div class="modal-content">
                <h5 class="modal-subtitle"></h5>
                <p class="modal-text"></p>
            </div>

        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.3.min.js"><\/script>');</script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery.placeholder.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
        <!--[if lte IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/libs/classList.min.js"></script>
        <![endif]-->

        <script src="<?php echo get_template_directory_uri(); ?>/js/bin/centro.all.js"></script>
        
        <?php wp_footer(); ?>
    </body>
</html>