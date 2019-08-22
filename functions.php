<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get the theme version.
 * Return version defined in style.css
 *
 * @return string version.
 * @since 0.1.0
 */
function lunar_get_theme_version() {
	$theme = wp_get_theme( basename( get_bloginfo( 'stylesheet_directory' ) ) );
	return $theme->version;
}

/**
 * Add a new sidebar beneath the post box.
 */
add_action( 'widgets_init', 'houston_register_sidebar' );
function houston_register_sidebar() {
	register_sidebar( array(
		'name'          => __( 'Beneath Post Box', 'Lunar' ),
		'id'            => 'beneath-post-box',
		'description'   => '',
	    'class'         => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>' )
	);
}


/**
 * Tweak p3
 */
add_action( 'init', 'houston_custom' );
function houston_custom() {
	remove_action( 'wp_enqueue_scripts', 'p3_iphone_style', 1000 );
}


/**
 * Add the search widget to the nav
 */
function houston_new_nav_menu_items( $items, $args ) {
	if ( $args->theme_location == 'primary' ) {
		$homelink 	= the_widget( 'WP_Widget_Search' );
		$items 		= $items . $homelink;
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'houston_new_nav_menu_items', 10, 2 );

/**
 * Add Sass stylesheet
 */
function lunar_enqueue_scripts() {

	$version = lunar_get_theme_version();

	// Styles
	wp_enqueue_style( 'lunar-styles', get_stylesheet_directory_uri() . "/assets/css/theme.css", array(), $version );

	// Scripts
	wp_register_script( 'lunar-scripts', get_stylesheet_directory_uri() . "/assets/js/theme.js", array( 'jquery', 'p3' ), $version, true );

	// Localize Script / Data
	$ct_scripts_data_array = array();
	$ct_script_data = apply_filters( 'lunar_scripts_data', $ct_scripts_data_array );
	wp_localize_script( 'lunar-scripts', 'ct_scripts', $ct_script_data );;

	wp_enqueue_script( 'lunar-scripts' );
}

add_action( 'wp_enqueue_scripts', 'lunar_enqueue_scripts' );

/**
 * Add js to the frontend
 */
add_action( 'wp_enqueue_scripts', 'houston_scripts', 999 );
function houston_scripts() {
	wp_enqueue_script( 'woo-p2-script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'fitvids', get_stylesheet_directory_uri() . '/js/fitvids.js', array( 'jquery' ), '', true );
	wp_dequeue_script( 'iphone' );
}


/**
 * Add viewport meta
 */
add_action( 'wp_head', 'houston_viewport_meta' );
function houston_viewport_meta() {
?>
	<!--  Mobile viewport scale | Disable user zooming as the layout is optimised -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php
}


/**
 * Integrations
 * Include logic that integrates lunar with third party plugins
 */

/**
 * p2-likes
 * http://wordpress.org/plugins/p2-likes/
 */
if ( defined( 'P2LIKES_URL' ) ) {
	require_once( get_stylesheet_directory() . '/includes/integrations/p2-likes/p2-likes.php' );
}


/**
 * 	Add the Favicon to the head.
 *
 *	Added to theme, admin and login.
 */
function rpv_lunar_favicon() {

	?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo( 'stylesheet_directory' ); ?>/assets/favicon.png" />
	<?php

}
add_action( 'wp_head', 	  'rpv_lunar_favicon' );
add_action( 'admin_head', 'rpv_lunar_favicon' );
add_action( 'login_head', 'rpv_lunar_favicon' );

/**
 * Add a date to repeat post's title. Date format depends on repeating schedule.
 * Currently adds a date for weekly and monthly scheduled posts.
 *
 * Plugin: hm-post-repeat
 *
 * @param array $next_post          The repeat (scheduled/next) post data array.
 * @param array $repeating_schedule Repeating schedule array info.
 * @param array $original_post      Repeating (original) post data array.
 *
 * @return array The repeat post with modified post title including a date.
 */
function repeat_post_add_date_to_title( $next_post, $repeating_schedule, $original_post ) {

	$format = '';
	switch ( $repeating_schedule['slug'] ) {
		case 'weekly':
			$format = ' \- \W\e\e\k W\, Y';
			break;
		case 'monthly':
			$format = ' \- F Y';
			break;
		default:
			$format = '';
	}

	// Add date format to next post's title.
	if ( $format ) {
		$next_post['post_title'] .= date( $format, strtotime( $next_post['post_date'] ) );
	}

	return $next_post;
}

add_filter( 'rpv_post_repeat_edit_repeat_post', __NAMESPACE__ . '\\repeat_post_add_date_to_title', 10, 3 );
