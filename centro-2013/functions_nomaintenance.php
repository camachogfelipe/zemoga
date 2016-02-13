<?php
/**
 * Centro functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, centro_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */

/**
 * Tell WordPress to run centro_setup() when the 'after_setup_theme' hook is run.
 */
define( 'CENTRO_LIB', TEMPLATEPATH . '/lib/' );
$themename = 'centro-2013';
$shortname = 'centro';  
$prefix = 'centro_';
// Add Theme Options Panel Functions
require_once ( CENTRO_LIB . 'theme-options.php' );

add_action( 'after_setup_theme', 'centro_setup' );


function centro_setup() {
	/* Make Centro available for translation.
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'centro', get_template_directory() . '/languages' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top_menu' => __( 'Primary Menu', 'centro' ),
		'middle_menu' => __( 'Content Menu', 'centro' ),
		'footer_menu'=> __( 'Footer Menu', 'centro' )
		) );
	
	/* Zemoga AppDev: Felipe Camacho */
	// Add Theme Thumbnails
	require_once ( CENTRO_LIB . 'theme-thumbnails.php' );
	// Load Theme Scripts
	require_once ( CENTRO_LIB . 'theme-scripts.php' );
	// Add Custom Post Types
	add_action( 'init', 'centro_post_types' );
	// Add Meta Boxes Actions
	add_action( 'admin_menu', 'centro_page_add_box' );
	add_action( 'save_post', 'centro_page_save_data' );
	add_action( 'admin_menu', 'centro_slide_add_box' );
	add_action( 'save_post', 'centro_slide_save_data' );
	// Add Custom Widgets Action
	add_action( 'widgets_init', 'centro_load_widgets' );
	/* End Zemoga AppDev: Felipe Camacho */
}

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function centro_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'centro_excerpt_length' );

/**
 * Sets default arguments for all navigation menus
 * @param  Array $args Menu parameters
 * @return Array      Processed menu parameters
 */
function my_wp_nav_menu_args( $args = '' ) {
	//$args['container'] = false;
	return $args;
} // function

add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function centro_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'centro_page_menu_args' );

//	enable widgets
register_sidebar();

function my_scripts_method() {
    wp_enqueue_script('modernizr', get_template_directory_uri() . "/js/libs/modernizr-2.6.2.min.js", array(), '2.6.2', false);            
}    
 
add_action('wp_enqueue_scripts', 'my_scripts_method'); // For use on the Front end (ie. Theme)

/*Andres Garcia: Remove inline styles*/
function centro_remove_recent_comments_style() {  
    global $wp_widget_factory;  
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );  
}  
add_action( 'widgets_init', 'centro_remove_recent_comments_style' );

// Jobvite shortcode
function centro_embed_jobvite($atts) {
	$output = <<<EOT
	<!-- jobvite iframe -->
	<iframe id="jobviteframe" src="http://hire.jobvite.com/CompanyJobs/Careers.aspx?c=qH39Vfwy&amp;cs=9MO9Vfwo&amp;nl=0&amp;jvresize=/wp-content/themes/centro-2013/partials/FrameResize.html" width="100%" height="100%" scrolling="no" frameborder="0" allowtransparency="”true”">Sorry, iframes are not supported.</iframe>
	<!-- ./ jobvite iframe -->
EOT;
	return $output;
}
add_shortcode( 'jobvite', 'centro_embed_jobvite' );

/* Zemoga AppDev: Felipe Camacho */
// Add Custom Post Types Function
require_once ( CENTRO_LIB . 'theme-post-types.php' );
// Add Custom Meta Boxes Functions
require_once ( CENTRO_LIB . 'theme-page-meta-boxes.php' );
require_once ( CENTRO_LIB . 'theme-slide-meta-boxes.php' );
// Add Custom Widgets Function
require_once ( CENTRO_LIB . 'theme-widgets.php' );
//Add size for images specific of the template
if ( function_exists( 'add_image_size' ) ) {    
	add_image_size('centro-content-page', 180, 150, true); // foto para content page
	add_image_size('centro-landing-page', 500, 310, true); // foto destacado en portada   
	add_image_size('centro-footer-homepage', 285, 150, true);  // foto pequeña home
	add_image_size('centro-gallery-homepage', 1300, 430, true);  // foto slide
	add_image_size('centro-grid', 230, 170, true);  // foto pequeña grid
	add_image_size('centro-thanks', 430, 320, true);  // foto para thank you pages
	add_image_size('centro-events', 110, 110, true);  // foto pequeña para eventos y press
}
add_filter('image_size_names_choose', 'centro_image_sizes');
function centro_image_sizes($sizes) {
    $addsizes = array(
        "centro-content-page" => __( "Images for content page"),
        "centro-landing-page" => __("Images for landing page."),
		"centro-footer-homepage" => __("Images for callout fotter homepage."),
		"centro-gallery-homepage" => __("Images for gallery homepage."),
		"centro-grid" => __("Images for grid page."),
		"centro-thanks" => __("Images for template thank you pages."),
		"centro-events" => __("Images for template Upcoming events.")
    );
    $newsizes = array_merge($sizes, $addsizes);
    return $newsizes;
}
// Add Images Resize Function
require_once ( CENTRO_LIB . 'theme-thumbnails-resize.php' );
// posts-2-posts connections
function centro_connection_types() {
	// Make sure the Posts 2 Posts plugin is active.
	if ( !function_exists( 'p2p_register_connection_type' ) )
		return;

	p2p_register_connection_type( array(
		'name' => 'callouts_to_pages',
		'from' => 'callout',
		'to' => 'page'
	) );

	p2p_register_connection_type( array(
		'name' => 'contacts_to_pages',
		'from' => 'centro-contact',
		'to' => 'page'
	) );
}
add_action( 'wp_loaded', 'centro_connection_types' );

// Get the callouts for a page
function centro_get_callouts($id = NULL, $type = NULL) {
	if(!is_null($id)) {
		$args = array(
			'connected_type' => 'callouts_to_pages',
			'connected_items' => $id,
			'nopaging' => true,
			'orderby' => 'title',
			'order' => 'ASC',
		);
	}
	else {
		$args = array(
			'post_type' => 'callout',
			'post_status' => 'publish',
			'post_limits' => 1,
			'posts_per_page' => -1,
			'orderby' => 'post_date_gmt',
			'order' => 'DESC',
		);
	}
	$connections = new WP_Query($args);
	if ($connections->have_posts()) {
		$posts = $connections->posts;
	}
	else { $posts = array(); }
	$data = array();
	foreach ($posts as $post) {
		$callout_vars = array();
		$callout_vars['id'] = $post->ID;
		$callout_meta = get_post_custom($post->ID);
		foreach ($callout_meta as $meta_key => $meta_values) {
			if (preg_match('/^wpcf\-callout\-(.*)$/', $meta_key, $matches)) {
				$callout_vars[$matches[1]] = $meta_values[0];
			}
		}
		switch ($callout_meta['wpcf-callout-type'][0]) {
			case 1 : // head, should be one
				$data['head'] = $callout_vars;
				break;

			case 2 : // body, can be multiple
				$data['body'][] = $callout_vars;
				break;

			case 3 : // foot, should be one
				$data['foot'] = $callout_vars;
				break;

			case 4 : // password, should be one
				$data['password'] = $callout_vars;
				break;

			case 5 : // callout for homepage
				/*if(!empty($data['homepage'])) array_push($keys, $callout_vars['order']);
				else $keys = array(0 => $callout_vars['order']);
				echo "<p><pre>";print_r($keys);echo "</pre></p>";
				echo $callout_vars['order']."<br>";
				if(!in_array($callout_vars['order'], $keys)) $data['homepage'][$callout_vars['order']] = $callout_vars;
				elseif(!in_array($callout_vars['order']-1, $keys)) $data['homepage'][$callout_vars['order']-1] = $callout_vars;
				else $data['homepage'][$callout_vars['order']+1] = $callout_vars;
				sort($data['homepage']);*/
				$data['homepage'][] = $callout_vars;
				$data['homepage'] = orderMultiDimensionalArray($data['homepage'], "order", false);
				break;

			default: // ?
				$data['unknown'][] = $callout_vars;
				break;
		}
	}
	if(!is_null($type)) return $data[$type];
	else return $data;
}

// function for centro locations
function centro_get_locations() {
	$args=array(
		'post_type' => 'centro-location',
		'orderby' => 'title',
		'order' => 'ASC',
		'nopaging' => true,
	);
	$data = array();
	$posts = get_posts($args);
	foreach ($posts as $post) {
		$location_vars = array();
		$location_vars['id'] = $post->ID;
		$location_meta = get_post_custom($post->ID);
		foreach ($location_meta as $meta_key => $meta_values) {
			if (preg_match('/^wpcf\-location\-(.*)$/', $meta_key, $matches)) {
				$location_vars[$matches[1]] = $meta_values[0];
			}
		}
		$data[] = $location_vars;
	}
	return $data;
}
// End function centro locations

// Functions for centro contacts
// get all contacts for a page - used by inquiry contact shortcode
function centro_team($atts) {
	$atts = shortcode_atts( array( 'type' => '' ), $atts );
	switch($atts['type']) :
		case 'board' : $modal = true; break;
		case 'executive' : $modal = false; break;
		default : $modal = false; break;
	endswitch;
	$data = centro_get_contacts($atts['type']);
	$data_keys = array(//"id" => "id", 
					   "slug" => "link", 
					   "image" => "image", 
					   "name" => "post_name",
					   "title" => "subtitle",
					   "bio" => "post_content",
					   "order" => "order"
					  );
	foreach($data as $key => $dato) :
		foreach($dato as $k=>$v) :
			if(isset($data_keys[$k])) :
				$grid_data[$key][$data_keys[$k]] = $v;
			endif;
		endforeach;
		$grid_data[$key]['post_title'] = $dato['title'];
	endforeach;
	$grid_data = orderMultiDimensionalArray($grid_data, "order", false);
	require_once("grid-item.php");
}
add_shortcode('centro-team', 'centro_team');

function centro_get_contacts($type) {
	$args=array(
		'post_type' => 'centro-contact',
		'orderby' => 'title',
		'order' => 'ASC',
		'nopaging' => true,
	);
	$data = array();
	$posts = get_posts($args);
	foreach ($posts as $post) {
		$datatemp[] = centro_extract_contact_vars($post, $atts);
	}
	
	switch($type) :
		case 'board' : $type .= "-member"; break;
		case 'executive' : $type .= "-team"; break;
		default : $type = "executive-team"; break;
	endswitch;
	foreach($datatemp as $dato) :
		if($dato[$type] == 1) $data[] = $dato;
	endforeach;
	return $data;
}

// Get single contact for a post -- used by bio block
function centro_get_contact($id = NULL) {
    $post = get_post($id);
    if ($post) {
		return centro_extract_contact_vars($post);
    }
    else {
    	return false;
    }
}

function centro_get_contact_by_slug($slug='') {
	$args=array(
		'name' => $slug,
		'post_type' => 'centro-contact',
		'post_status' => 'publish',
		'showposts' => 1
	);
	$posts = get_posts($args);
	if($posts) {
		return centro_extract_contact_vars($posts[0]);
	}
	else {
		return $false;
	}
}

function centro_extract_contact_vars($post=NULL, $type = NULL) {
    if ($post) {
		$contact_vars = array();
		$contact_vars['id'] = $post->ID;
		$contact_vars['slug'] = $post->post_name;
		$contact_meta = get_post_custom($post->ID);
		foreach ($contact_meta as $meta_key => $meta_values) {
			if (preg_match('/^wpcf\-contact\-(.*)$/', $meta_key, $matches)) {
				$contact_vars[$matches[1]] = $meta_values[0];
			}
		}
		return $contact_vars;
    }
    else {
    	return array();
    }
}

// Function for order $data['homepage']
function orderMultiDimensionalArray ($toOrderArray, $field, $inverse = false) {
	$position = array();  
    $newRow = array();  
    foreach ($toOrderArray as $key => $row) {  
            $position[$key]  = $row[$field];  
            $newRow[$key] = $row;  
    }  
    if ($inverse) {  
        arsort($position);  
    }  
    else {  
        asort($position);  
    }  
    $returnArray = array();  
    foreach ($position as $key => $pos) {       
        $returnArray[] = $newRow[$key];  
    }  
    return $returnArray;  
}

// Function for slide images
function get_slide() {
	$args = array(
			'post_type' => 'slide',
			'posts_per_page' => -1,
			'post_status' => 'publish'
	);
	$connections = new WP_Query($args);
	if ($connections->have_posts()) $posts = $connections->posts;
	else $posts = array();
	
	$i = 0;
	foreach($posts as $post) :
		$slide_meta = get_post_custom($post->ID);
		//print_r($slide_meta);
		foreach ($slide_meta as $meta_key => $meta_values) :
			if($meta_key == '_thumbnail_id') $image_id = $meta_values[0];
			if($meta_key == 'centro_slide_link') $slide_data[$i]['centro_slide_link'] = $meta_values[0];
			if($meta_key == 'centro_slide_color_button') $slide_data[$i]['centro_slide_color_button'] = $meta_values[0];
			if($meta_key == 'centro_slide_video') $slide_data[$i]['centro_slide_video'] = $meta_values[0];
		endforeach;
		$slide_data[$i]['image'] = wp_get_attachment_image_src( $image_id, 'full' );
		$slide_data[$i]['title'] = $post->post_title;
		$slide_data[$i]['content'] = $post->post_content;
		$i++;
	endforeach;
	return $slide_data;
	
}
// End function for slide images

// Function for callouts sidebar
function get_callout_post($id) {
	$tmp_custom_sidebar = get_post_custom( $id );
	$custom_sidebar = NULL;
	foreach ($tmp_custom_sidebar as $meta_key => $meta_values) :
		if (preg_match('/^centro_sidebar\-(.*)$/', $meta_key, $matches)) :
			if(preg_match('/^image(.*)$/', $matches[1])) :
				$custom_sidebar[$matches[1]] = wp_get_attachment_image_src($meta_values[0], 'centro-content-page');
			else : $custom_sidebar[$matches[1]] = $meta_values[0];
			endif;
		endif;
	endforeach;
	if(!empty($custom_sidebar)) :
		foreach($custom_sidebar as $image_key => $image_value) :
			if(preg_match('/^image(.*)$/', $image_key) and !empty($image_value)) :
				$cadena = 'cta'.$image_key[count(str_split($image_key))-1];
				if(isset($cadena)) :
					echo '<a href="'.home_url( '/' ).$cadena.'">';
					echo '<img src="'.$image_value[0].'" alt="">';
					echo '</a>';
				else : echo '<img src="'.$image_value.'" alt="">';
				endif;
			endif;
		endforeach;
	endif;
	
	return $custom_sidebar;
}
// End function callouts sidebar

// Breadcum navigation
function the_breadcrumb($id) {
	//if ( function_exists('yoast_breadcrumb') ) : yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	//else :	
		if (!is_home()) :
			echo '<li><a href="';
			echo get_option('home');
			echo '">Home'."</a></li> > ";
			//Validamos los tipos especiales
			if(isset($_REQUEST['press-releases']) || isset($_REQUEST['upcoming-event']) || isset($_REQUEST['in-the-press'])) :
				$breadcrumb = array("press-releases" => "Press Releases", "upcoming-event" => "Events", "in-the-press" => "In the Press");
				$links[] = '<li><a href="'.get_option('home').'/news">News</a></li>';
				if(isset($_REQUEST['press-releases'])) :
					$links[] = '<li><a href="'.get_option('home').'/news/press">Press Releases</a></li>';
				elseif(isset($_REQUEST['upcoming-event'])) :
					$links[] = '<li><a href="'.get_option('home').'/news/upcoming-events">Events</a></li>';
				elseif(isset($_REQUEST['in-the-press'])) :
					$links[] = '<li><a href="'.get_option('home').'/news/in-the-press">In the Press</a></li>';
				endif;
				echo implode(" > ", $links);
				echo " > ";
			elseif(isset($GLOBALS['EXECUTIVE']) and $GLOBALS['EXECUTIVE'] == true) :
				unset($GLOBALS['EXECUTIVE']);
				$links[] = '<li><a href="'.get_option('home').'/about">About</a></li>';	
				$links[] = '<li><a href="'.get_option('home').'/about/executive-team">Executive Team</a></li>';
				echo implode(" > ", $links);
				echo " > ";
			else :
				$parents = get_ancestors( $id, 'page');
				if(empty($parents)) $parents = get_ancestors( $id, 'category');
				if(!empty($parents)) :
					$parents = array_reverse($parents);
					foreach($parents as $key=>$parent) :
						$title = get_the_title($parent);
						$title = strip_tags(html_entity_decode($title));
						$links[] = '<li><a href="'.get_permalink($parent).'">'.$title.'</a>';
					endforeach;
					echo implode(" > ", $links);
					echo " > ";
				endif;
			endif;
			echo '<li class="breadcrumb-current"><a href="';
			echo get_permalink($id);
			echo '">';
			$title = get_the_title($id);
			echo $title = strip_tags(html_entity_decode($title));
			echo "</a></li> ";
		endif;
	//endif;
}
// End breadcum navigation

function get_page_exclude() {
	$page = array();
	$page[] = get_cat_ID("Thank you pages");
	
	global $wpdb, $table_prefix;
 
	$consulta = "SELECT object_id as ID FROM ".$table_prefix."term_relationships WHERE term_taxonomy_id='".implode(",", $page)."'";
	$resultado = $wpdb->get_results( $consulta );
	if(!empty($resultado)) :
		foreach ( $resultado as $fila ):
			$cat[] = $fila->ID;
		endforeach;
		return implode(",", $cat);
	else : return NULL;
	endif;
}

if(!function_exists('get_post_top_ancestor_id')){
/**
 * Gets the id of the topmost ancestor of the current page. Returns the current
 * page's id if there is no parent.
 * 
 * @uses object $post
 * @return int 
 */
	function get_post_top_ancestor_id(){
		global $post;
		
		if($post->post_parent){
			$ancestors = array_reverse(get_post_ancestors($post->ID));
			return $ancestors[0];
		}
		
		return $post->ID;
	}
}

// Function for generate menu in grid
function generate_menu($links, $team_unique = false, $id = NULL) {
	$links = explode("<li ", $links);
	//echo "<pre>";print_r($links);echo "</pre>";
	
	foreach($links as $link) :
		if(!empty($link)) :
			$cadena = strtolower(trim($link));
			if((strpos($cadena, "executive") !== false and strpos($cadena, "current_page_item")) || (strpos($cadena, "executive") !== false and $team_unique == true)) :
				$link = substr($link, 0, -6);
				echo "<li ".$link;
				$team = centro_get_contacts("executive");
				if(!empty($team)) :
					echo "<ul class=\"sub-menu\">";
					foreach($team as $member) :
						if($team_unique == true) :
							$permalink = get_option('home')."/about/";
							//echo $_SERVER['HTTP_REFERER'];
							global $wp;
							$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
							$member_slug = strtolower(trim($member['slug']));
							if(strpos($current_url, $member_slug) !== false) :
								echo '<li class="page_item page-item-'.$member['id'].' current_page_item">';
							else : echo '<li>';
							endif;
							echo "<em>&gt;</em> <a href=\"".$permalink."executive-team/".$member['slug']."\">";
						else :
							echo '<li>';
							echo "<em>&gt;</em> <a href=\"".$permalink.$member['slug']."\">";
						endif;
						echo $member['name']."</a></li>";
					endforeach;
					echo "</ul>";
					unset($team);
				endif;
				echo "</li>";
			else : echo "<li ".$link;
			endif;
		endif;
	endforeach;
}
// End functions for centro contacts

// General Functions
function centro_date_format($date) {
	if(!empty($date)) :
		$date = date('Y-m-d', $date);
		$tmp = explode("-", $date);
		unset($date);
		switch($tmp[1]) :
			case '01' : $date['month'] = "Jan"; break;
			case '02' : $date['month'] = "Feb"; break;
			case '03' : $date['month'] = "Mar"; break;
			case '04' : $date['month'] = "Apr"; break;
			case '05' : $date['month'] = "May"; break;
			case '06' : $date['month'] = "Jun"; break;
			case '07' : $date['month'] = "Jul"; break;
			case '08' : $date['month'] = "Aug"; break;
			case '09' : $date['month'] = "Sep"; break;
			case '10' : $date['month'] = "Oct"; break;
			case '11' : $date['month'] = "Nov"; break;
			case '12' : $date['month'] = "Dic"; break;
		endswitch;
		return $finaldate = '<strong>'.$date['month']." ".$tmp[2].'</strong>, '.$tmp[0];
	endif;
}

function centro_content_nav( $url ) {
    global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) :
		echo '<nav>';
		echo '<div class="wp-pagenavi">';
		echo '<a class="first" href="'.$url.'">First</a>';
		previous_posts_link( 'Previous Page: ' );
		echo '<span class="extend">...</span>';
		if(!isset($_REQUEST['page'])) $paged = 1;
		for($x = 1; $x <= $wp_query->max_num_pages; ++$x):
		if($paged == $x) :
				echo '<span class="current">'.$x.'</span>';
			else :
				echo '<a class="smaller page" href="';
				bloginfo( 'wpurl' );
				echo "/?page=".$x;
				echo '">'.$x.'</a>';
			endif;
		endfor;
		echo '<span class="extend">...</span>';
		next_posts_link( 'Next Page: ' );
		echo '<a class="last" href="'.$url.'/?page='.$wp_query->max_num_pages.'">Last</a>';
		echo '</div>';
		echo '</nav>';
	endif;
}
// End general functions

// Functions for Upcoming events, Press releases & In the press
function centro_pressroom($attr) {
	global $wp_query;
	$current_page =  ($wp_query->get('paged') != 0) ? $wp_query->get('paged') : 1;
	$args=array(
		'post_type' => 'press-releases',
		'meta_key' => 'wpcf-event-dates',
		'orderby' => 'wpcf-event-dates',
		'order' => 'DESC',
		'posts_per_page' => 5,
		'post_status'     => 'publish',
		'paged' => $current_page,
	);
	$GLOBALS["ARGS"] = $args;
}
add_shortcode('pressroom', 'centro_pressroom');

function centro_upcomingevents($attr) {
	global $wp_query;
	$current_page =  ($wp_query->get('paged') != 0) ? $wp_query->get('paged') : 1;
	$args=array(
		'post_type' => 'upcoming-event',
		'meta_key' => 'wpcf-event-dates',
		'orderby' => 'wpcf-event-dates',
		'order' => 'DESC',
		'posts_per_page' => 5,
		'post_status'     => 'publish',
		'paged' => $current_page,
	);
	$GLOBALS["ARGS"] = $args;
}
add_shortcode('eventsroom', 'centro_upcomingevents');

function centro_inthepress($attr) {
	global $wp_query;
	$current_page =  ($wp_query->get('paged') != 0) ? $wp_query->get('paged') : 1;
	$args=array(
		'post_type' => 'in-the-press',
		'meta_key' => 'wpcf-event-dates',
		'orderby' => 'wpcf-event-dates',
		'order' => 'DESC',
		'posts_per_page' => 5,
		'post_status'     => 'publish',
		'paged' => $current_page,
	);
	$GLOBALS["ARGS"] = $args;
}
add_shortcode('inthepressroom', 'centro_inthepress');
// End functions for Upcoming events, Press releases & In the press

// Function for create a link in the sidebar of the blog with class specific
function centro_cta_sidebar_blog($attr) {
	extract(shortcode_atts(array('link' => '', 'label' => '', 'target' => '', 'class' => ''), $attr));
	$output = <<<EOT
		<li class="$class l-inline">
			<a href="$link" target="$target">$label
				<span class="icon">&nbsp;</span>
			</a>
		</li>
EOT;
	return $output;
}
add_shortcode('cta_blog', 'centro_cta_sidebar_blog');
// End Function for create a link in the sidebar of the blog with class specific

// Function for shortcode for grid content
// Function for create a link in the sidebar of the blog with class specific
function centro_content_grid($attr) {
	extract(shortcode_atts(array('category' => '', 'modal' => false), $attr));
	global $wp_query;
	$current_page =  ($wp_query->get('paged') != 0) ? $wp_query->get('paged') : 1;
	$args = array(
			'post_type' => 'content-grid',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'category_name' => $category,
			'posts_per_page' => 12,
			'paged' => $current_page
	);
	$connections = new WP_Query($args);
	if ($connections->have_posts()) $posts = $connections->posts;
	else $posts = array();
	
	$i = 0;
	foreach($posts as $post) :
		$grid_meta = get_post_custom($post->ID);
		//$grid_data[$i] = $post;
		foreach ($grid_meta as $meta_key => $meta_values) :
			if (preg_match('/^wpcf\-grid\-(.*)$/', $meta_key, $matches)) :
				$grid_data[$i][$matches[1]] = $meta_values[0];
			endif;
		endforeach;
		$grid_data[$i]['ID'] = $post->ID;
		$grid_data[$i]['post_content'] = $post->post_content;
		$grid_data[$i]['post_title'] = $post->post_title;
		$grid_data[$i]['post_name'] = $post->post_title;
		$grid_data[$i]['menu_order'] = $post->menu_order;
		$i++;
	endforeach;
	
	$i = 0;
	if(!empty($grid_data)) :
		require_once("grid-item.php");
	endif;
	$GLOBALS["ARGS"] = $args;
}
add_shortcode('grid', 'centro_content_grid');
// End Function for shortcode for grid content

// Agregar categorías en páginas
function mostrar_cats_y_tags_en_paginas() {
    register_taxonomy_for_object_type( 'category', 'page');

    //register_taxonomy_for_object_type( 'post_tag', 'page');
}
add_action( 'admin_menu', 'mostrar_cats_y_tags_en_paginas');

/*function add_category_box_on_page(){
	add_meta_box('tagsdiv', __('Category'), 'post_categories_meta_box', 'page', 'side', 'low');
}

add_action('admin_menu', 'add_category_box_on_page');*/

// Remove filter for title protected
function remove_protected_text($title) {
  $match = '/Protected: /';
  $replacement = '';

  $title = preg_replace($match, $replacement, $title);
  return $title;
}

add_filter( 'the_title', 'remove_protected_text', 10);
/* End Functions for Zemoga AppDev: Felipe Camacho */

// Functions of the theme centro-2012
function centro_download_list($attr, $content=null) {
	extract(shortcode_atts(array('title' => 'View Downloads',), $attr));
	$output = <<<EOT
	<ul class="dl_list">
		<li class="dl_li">
			<a href="#" class="dl_link">$title</a>
			<ul class="dl_drawer">
EOT;
	$output .= do_shortcode($content);
	$output .= <<<EOT
			</ul>
		</li>
	</ul>
EOT;
return $output;
}
add_shortcode('dllist', 'centro_download_list');

function centro_download_item($attr) {
	extract(shortcode_atts(array('url' => '', 'title' => '', 'target' => ''), $attr));
	if (!isset($target)) {
		$target = '';
	} else {
		$target = 'target="'. $target .'"';
	}
	$icon = 'icon_' . pathinfo($url, PATHINFO_EXTENSION);
	$output = <<<EOT
	<li class="$icon"><a $target href="$url"><span>&nbsp;</span> $title</a></li>
EOT;
return $output;
}
add_shortcode('dlitem', 'centro_download_item');

// this is not a good way to handle this kind of thing, but I can't think of a better solution at this time
function centro_add_social_icon_classes($classes, $item) {
    switch(strtolower($item->title)) {
    	case "facebook":
	        $classes[] = "social-facebook";
	        break;
    	case "twitter":
	        $classes[] = "social-twitter";
	        break;
    	case "google+":
	        $classes[] = "social-google";
	        break;
    	case "linkedin":
	        $classes[] = "social-linkedin";
	        break;
    	case "youtube":
	        $classes[] = "social-youtube";
	        break;
    	case "vimeo":
	        $classes[] = "social-vimeo";
	        break;
    	case "rss":
	        $classes[] = "social-rss";
	        break;
	    default:
	        break;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'centro_add_social_icon_classes', 10, 2 );

function centro_show_social_icons_menu() {
	ob_start();
	wp_nav_menu(array('menu' => 'Social Icons'));
	return '<nav class="social-nav dark l-inline">'.ob_get_clean()."</nav>";
}
add_shortcode('social_icons', 'centro_show_social_icons_menu');

// affiliate resource center
function centro_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$action = get_option('siteurl') . '/wp-login.php?action=postpass';
	$ref = get_permalink($post->ID);
	$callouts = centro_get_callouts($post->ID);
	if (isset($callouts['password']['text']) && !empty($callouts['password']['text'])) {
		$callout = $callouts['password']['text'];
		$callout .= edit_post_link('Edit This Callout', '<br/><span class="wpedit">[', ']</span>', $callouts['password']['id']);
	}
	else
		$callout = "Password Required";
	$output = <<<EOT
	$callout
	<form class="protected-post-form" action="$action" method="post" method="post">
		<label for="$label">Password</label>
		<input type="password"name="post_password" id="$label"> <br />
		<input type="hidden" name="_wp_http_referer" value ="$ref">
		<input type="submit" name="Submit" value="Log In" />
	</form>
EOT;
	return $output;
}
add_filter( 'the_password_form', 'centro_password_form' );

//Call-to-action buttons available anywhere
function centro_cta($attr) {
	extract(shortcode_atts(array('link' => '', 'label' => '', 'target' => ''), $attr));
	$output = <<<EOT
		<p>
			<a href="$link" class="default-btn small" target="$target" title="$label">
				<span>$label</span>
				<em class="cta-arrow right icon">&raquo;</em>
			</a>
		</p>
EOT;
	return $output;
}
add_shortcode('cta', 'centro_cta');

//remove_filter( 'the_content', 'wpautop' );

// Add styles to the WYSIWYG editor 
add_editor_style('css/wysiwyg.css');
// End functions of the theme centro-2012

/*function myplugin_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_myplugin_tinymce_plugin");
     add_filter('mce_buttons', 'register_myplugin_button');
   }
}
 
function register_myplugin_button($buttons) {
   array_push($buttons, "separator", "CTAButton");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_myplugin_tinymce_plugin($plugin_array) {
	$theme = get_bloginfo('template_url');
   $plugin_array['myplugin'] = $theme.'/js/tinymce/editor_plugin.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'myplugin_addbuttons');*/

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');

// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => '.slide-white',  
			'selector' => 'h2, h3, h4, h5',  
			'classes' => 'slide-light',
			'exact' => false,
			'wrapper' => true,
			
		),
		// Each array child is a format with it's own settings
		array(  
			'title' => '.title-featured',  
			'selector' => 'h2, h3, h4, h5',  
			'classes' => 'title-featured',
			'exact' => false,
			'wrapper' => true,
			
		)
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );  
?>