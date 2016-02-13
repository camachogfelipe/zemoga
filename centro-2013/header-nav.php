<?php
/**
 * The Header Main navigation for our theme.
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>

<header class="header-menu">
    <div class="layout-container l-inline">
        <!-- content menu -->
        <?php
        $defaults = array(
            'theme_location'    => 'middle_menu',
            'menu'              => '',
            'container'         => 'nav',
            'container_class'   => 'content-nav',
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
        <!-- ./ content menu -->
        <div class="l-stacked-right">
            <?php get_template_part('social', 'nav'); ?>
        </div>
    </div>
</header>