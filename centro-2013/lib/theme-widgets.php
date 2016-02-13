<?php

	function centro_load_widgets() {
		register_sidebar( array(
			'name' => 'Landing Pages Sidebar left',
			'id' => 'landing-pages-sidebar-left',
			'description' => 'The sidebar on landing pages.',
			'before_widget' => '<aside class="newsletter">',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
			'after_widget' => '</aside>',
		) );
		register_sidebar( array(
			'name' => 'Landing Pages Sidebar right',
			'id' => 'landing-pages-sidebar-right',
			'description' => 'The sidebar on landing pages.',
			'before_widget' => '<aside class="newsletter info-box">',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
			'after_widget' => '</aside>',
		) );
		register_sidebar( array(
			'name' => 'Common Pages Sidebar social',
			'id' => 'common-pages-sidebar-social',
			'description' => 'The sidebar on most non-blog pages for social icons.',
			'before_widget' => '<aside class="social">',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
			'after_widget' => '</aside>',
		) );
		register_sidebar( array(
			'name' => 'Common Pages Sidebar newsletter',
			'id' => 'common-pages-sidebar-newsletter',
			'description' => 'The sidebar on most non-blog pages for sing-up newsletter.',
			'before_widget' => '<aside class="newsletter">',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
			'after_widget' => '</aside>',
		) );
		register_sidebar( array(
			'name' => 'Blog Pages Sidebar',
			'id' => 'blog-sidebar',
			'description' => 'The sidebar on blog posts, pages and indexes.',
			'before_widget' => '',
			'before_title' => '',
			'after_title' => '',
			'after_widget' => '',
		) );
		register_sidebar( array(
			'name' => 'footer',
			'id' => 'footer',
			'description' => 'The see it try it bar',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '',
			'after_title' => '',
		) );
	}	
?>