<?php
/**
 * Social nav links
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>

<nav class="social-nav l-inline">
    <h3>Follow us:</h3>
    
    <?php
    $defaults = array(
        'theme_location'    => '',
        'menu'              => 'Social Icons',
        'container'         => '',
        'container_class'   => '',
        'container_id'      => '',
        'menu_class'        => '',
        'menu_id'           => '',
        'echo'              => true,
        'fallback_cb'       => 'wp_page_menu',
        'before'            => '',
        'after'             => '',
        'link_before'       => '',
        'link_after'        => '',
        'items_wrap'        => '<ul class="l-inline">%3$s</ul>',
        'depth'             => 0,
        'walker'            => ''
    );

    wp_nav_menu( $defaults );

    ?>
</nav>