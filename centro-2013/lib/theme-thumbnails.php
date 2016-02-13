<?php
add_theme_support( 'post-thumbnails', array( 'post', 'portfolio_item', 'slide', 'team' ) );
set_post_thumbnail_size( 590, 240, true ); // Standard Size Thumbnails
add_image_size( 'related-thumb', 100, 80 ); // Related Posts Thumbnails
add_image_size( 'widget-thumb', 70, 70 ); // Related Posts Thumbnails
add_image_size( 'related-folio-thumb', 130, 80, false ); // Related Portfolio Thumbnails
?>