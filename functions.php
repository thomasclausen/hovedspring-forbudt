<?php
/**
 * HOVEDSPRING FORBUDT functions and definitions
 *
 * @package HOVEDSPRING FORBUDT
 * @since HOVEDSPRING FORBUDT 1.0
 * @last_updated HOVEDSPRING FORBUDT 2.9
 */

/**
 * Set the content width based on the theme's design and stylesheet
 *
 * @since HOVEDSPRING FORBUDT 2.0
 */
if ( ! isset( $content_width ) ) :
	$content_width = 524;
endif;

if ( ! function_exists( 'hovedspringforbudt_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features
	 *
	 * @since HOVEDSPRING FORBUDT 2.0
	 */
	function hovedspringforbudt_setup() {
		/**
		 * Add custom stylesheet for the editor
		 *
		 * @since HOVEDSPRING FORBUDT 2.0
		 */
		add_editor_style();
	}
endif;
add_action( 'after_setup_theme', 'hovedspringforbudt_setup' );

/**
 * Register new post type
 *
 * @since HOVEDSPRING FORBUDT 2.0
 */
function hovedspringforbudt_custom_post_type() {
	$labels = array(
		'name' => __( 'Fakta', 'hovedspring-forbudt' ),
		'add_new' => __( 'Tilf&oslash;j ny', 'hovedspring-forbudt' ),
		//'all_items' => __( 'Alle fakta', 'hovedspring-forbudt' ),
		'add_new_item' => __( 'Tilf&oslash;j ny fakta', 'hovedspring-forbudt' ),
		'edit_item' => __( 'Rediger fakta', 'hovedspring-forbudt' ),
		'new_item' => __( 'Tilf&oslash;j ny', 'hovedspring-forbudt' ),
		'view_item' => __( 'Vis fakta', 'hovedspring-forbudt' ),
		'search_items' => __( 'S&oslash;g fakta', 'hovedspring-forbudt' ),
		'not_found' => __( 'Ingen fakta fundet', 'hovedspring-forbudt' ),
		'not_found_in_trash' => __( 'Ingen fakta fundet i papirkurven.', 'hovedspring-forbudt' ),
	);
	$args = array(
		'label' => __( 'Fakta', 'hovedspring-forbudt' ),
		'labels' => $labels,
		'description' => __( 'Fakta omkring sv&oslash;mning.', 'hovedspring-forbudt' ),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 20,
		'has_archive' => true,
	);
	register_post_type( 'fakta', $args );
}
add_action( 'init', 'hovedspringforbudt_custom_post_type' );

/**
 * Flush rewite for the new post type
 *
 * @since HOVEDSPRING FORBUDT 2.0
 */
function hovedspringforbudt_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'hovedspringforbudt_rewrite_flush' );

/**
 * Change default listing option new post type
 *
 * @since HOVEDSPRING FORBUDT 2.1
 */
function hovedspringforbudt_custom_post_type_default_listing() {
	if ( $_GET['post_type'] === 'fakta' ) :
		$_REQUEST['mode'] = 'excerpt';
	endif;
}
add_action( 'load-edit.php', 'hovedspringforbudt_custom_post_type_default_listing' );

/**
 * Disable the autosave function
 *
 * @since HOVEDSPRING FORBUDT 1.0
 */
function hovedspringforbudt_disable_autosave() {
	wp_deregister_script( 'autosave' );
}
add_action( 'wp_print_scripts', 'hovedspringforbudt_disable_autosave' );

/**
 * Customize the admin menu
 *
 * @since HOVEDSPRING FORBUDT 1.0
 * @last_updated HOVEDSPRING FORBUDT 2.0
 */
function hovedspringforbudt_custom_admin_menus() {
	remove_menu_page( 'edit.php' ); // Posts
	remove_menu_page( 'upload.php' ); // Media
	remove_menu_page( 'edit-comments.php' ); // Comments
	
	remove_submenu_page( 'themes.php', 'widgets.php' ); // Widgets

	remove_menu_page( 'tools.php' ); // Tools section
}
add_action( 'admin_menu', 'hovedspringforbudt_custom_admin_menus', 999 );

/**
 * Customize the admin bar
 *
 * @since HOVEDSPRING FORBUDT 2.0
 */
function hovedspringforbudt_custom_admin_bar() {
	global $wp_admin_bar;
	
	$wp_admin_bar->remove_menu( 'comments' ); // Comments
	
	$wp_admin_bar->remove_menu( 'new-post', 'new-content' ); // Posts
	$wp_admin_bar->remove_menu( 'new-media', 'new-content' ); // Media
	$wp_admin_bar->remove_menu( 'new-user', 'new-content' ); // User
}
add_action( 'wp_before_admin_bar_render', 'hovedspringforbudt_custom_admin_bar' );

function hovedspringforbudt_pages_count_columns( $defaults ) {
	unset( $defaults['comments'] );
	return $defaults;
}
add_filter( 'manage_pages_columns', 'hovedspringforbudt_pages_count_columns' );

/**
 * Extend user profiles by adding input fields for facebook, twitter etc. and removing unwanted ones
 *
 * @since HOVEDSPRING FORBUDT 1.0
 */
function hovedspringforbudt_user_profile( $contactmethods ) {
	$contactmethods = array(
		'twitter' => __( 'Twitter', 'hovedspring-forbudt' ),
		'facebook' => __( 'Facebook', 'hovedspring-forbudt' ),
		'googleplus' => __( 'Google+', 'hovedspring-forbudt' ),
		'skype' => __( 'Skype', 'hovedspring-forbudt' )
	);
	
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );
	
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'hovedspringforbudt_user_profile', 10, 1 );

/**
 * Customize the title tag
 *
 * @since HOVEDSPRING FORBUDT 1.0
 * @last_updated HOVEDSPRING FORBUDT 2.6
 */
function hovedspringforbudt_custom_title( $title ) {
	if ( is_feed() ) :
		return $title;
	endif;
	
	$title = get_bloginfo( 'name', 'display' );

	return $title;
}
add_filter( 'wp_title', 'hovedspringforbudt_custom_title' );

/**
 * Remove unwanted meta tags and scripts from header
 *
 * @since HOVEDSPRING FORBUDT 1.0
 */
remove_action( 'wp_head', 'wp_generator' ); // WordPress version number
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/**
 * Enqueue scripts and styles
 *
 * @since HOVEDSPRING FORBUDT 1.0
 * @last_updated HOVEDSPRING FORBUDT 2.9
 */
function hovedspringforbudt_scripts_styles() {
	wp_register_style( 'hovedspring-forbudt-html5-reset', get_template_directory_uri() . '/reset-html5.css', false, '1.0' );
	wp_enqueue_style( 'hovedspring-forbudt-html5-reset' );
	wp_register_style( 'hovedspring-forbudt', get_template_directory_uri() . '/style.css', array( 'hovedspring-forbudt-html5-reset' ), '2.9' );
	wp_enqueue_style( 'hovedspring-forbudt' );
	if ( ! is_404() ) :
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'hovedspring-forbudt-script', get_template_directory_uri() . '/script.js', array( 'jquery' ), '2.9', true );
		wp_enqueue_script( 'hovedspring-forbudt-script' );
		wp_localize_script( 'hovedspring-forbudt-script', 'hovedspringforbudtAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'hovedspringforbudt_update' ) ) );
	endif;
}
add_action( 'wp_enqueue_scripts', 'hovedspringforbudt_scripts_styles' );

/**
 * Insert HTML5 extras
 *
 * @since HOVEDSPRING FORBUDT 2.3
 * @last_updated HOVEDSPRING FORBUDT 2.5
 */
function hovedspringforbudt_html5extras() {
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />' . "\n";
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />' . "\n";
}
add_action( 'wp_head', 'hovedspringforbudt_html5extras', 1 );

/**
 * Insert HTML5 shiv
 *
 * @since HOVEDSPRING FORBUDT 2.2
 */
function hovedspringforbudt_html5shiv() {
	echo '<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' . "\n";
}
add_action( 'wp_head', 'hovedspringforbudt_html5shiv' );

/**
 * Insert custom pingback
 *
 * @since HOVEDSPRING FORBUDT 1.0
 */
 // Pingback
function hovedspringforbudt_pingback() {
	echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
}
add_action( 'wp_head', 'hovedspringforbudt_pingback' );

/**
 * Insert favicon and iPhone homescreen icons
 *
 * @since HOVEDSPRING FORBUDT 1.0
 */
function hovedspringforbudt_icons() {
	echo '<link rel="apple-touch-icon" href="' . get_template_directory_uri() . '/images/apple-touch-icon-57x57.png" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="72x72" href="' . get_template_directory_uri() . '/images/apple-touch-icon-72x72.png" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="114x114" href="' . get_template_directory_uri() . '/images/apple-touch-icon-114x114.png" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="144x144" href="' . get_template_directory_uri() . '/images/apple-touch-icon-144x144.png" />' . "\n";
}
add_action( 'wp_head', 'hovedspringforbudt_icons', 15 );

/**
 * Insert Open Graph tags
 *
 * @since HOVEDSPRING FORBUDT 2.4
 */
function hovedspringforbudt_opengraph() {
	if ( !class_exists( WPSEO_OpenGraph ) ) :
		echo '<meta property="og:image" content="' . get_template_directory_uri() . '/images/logo-facebook-200x200.jpg" />' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />' . "\n";
		echo '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
		echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
	endif;
	echo '<link rel="image_src" href="' . get_template_directory_uri() . '/images/logo-facebook-200x200.jpg" />' . "\n";
}
add_action( 'wp_head', 'hovedspringforbudt_opengraph', 2 );

/**
 * Ajax update new post type
 *
 * @since HOVEDSPRING FORBUDT 1.0
 * @last_updated HOVEDSPRING FORBUDT 2.5
 */
function hovedspringforbudt_ajax_update() {
	check_ajax_referer( 'hovedspringforbudt_update', 'security' );
	
	$args = array( 'post_type' => 'fakta', 'post_status' => 'publish', 'orderby' => 'rand', 'posts_per_page' => 1 );
	$random_fact = new WP_Query( $args );
	while ( $random_fact->have_posts() ) : $random_fact->the_post();
		get_template_part( 'content', $theme_post_format );
	endwhile;

	die();
}
add_action( 'wp_ajax_hovedspringforbudt_update', 'hovedspringforbudt_ajax_update' );
add_action( 'wp_ajax_nopriv_hovedspringforbudt_update', 'hovedspringforbudt_ajax_update' );

/**
 * Insert Google Analytics code
 *
 * @since HOVEDSPRING FORBUDT 2.7
 */
function hovedspringforbudt_googleanalytics() {
	echo '<script type="text/javascript">' . "\n";
	echo 'var _gaq = _gaq || [];' . "\n";
	echo '_gaq.push([\'_setAccount\', \'UA-XXXXXXX-X\']);' . "\n";
	echo '_gaq.push([\'_trackPageview\']);' . "\n" . "\n";

	echo '(function() {' . "\n";
		echo  "\t" . 'var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;' . "\n";
		echo "\t" . 'ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';' . "\n";
		echo "\t" . 'var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);' . "\n";
	echo '})();' . "\n";
	echo '</script>' . "\n";
}
add_action( 'wp_footer', 'hovedspringforbudt_googleanalytics' );
