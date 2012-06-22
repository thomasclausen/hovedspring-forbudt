<?php define( 'HOVEDSPRING_FORBUDT_VERSION', '1.0' );

// Back-End functions

// Disable the autosave function
function disable_autosave() {
	wp_deregister_script( 'autosave' );
}
add_action( 'wp_print_scripts', 'disable_autosave' );

// Remove the menues from the admin
function theme_remove_menus() {
	remove_submenu_page( 'index.php', 'update-core.php' ); // Updates
	
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); // Categories
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // Tags
	remove_menu_page( 'upload.php' ); // Media
	remove_menu_page( 'link-manager.php' ); // Links
	remove_menu_page( 'edit-comments.php' ); // Comments
	
	remove_submenu_page( 'themes.php', 'widgets.php' ); // Widgets

	remove_menu_page( 'tools.php' ); // Tools section
}
add_action( 'admin_menu', 'theme_remove_menus', 999 );

// Add input fields for facebook, twitter etc. and remove unwanted ones for user profiles
function theme_user_profile( $contactmethods ) {
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
add_filter( 'user_contactmethods', 'theme_user_profile', 10, 1 );

// Front-End functions

// Customize the title tag
function theme_custom_title( $title ) {
	// Don't change wp_title() calls in feeds.
	if ( is_feed() ) :
		return $title;
	endif;
	
	$title = get_bloginfo( 'name', 'display' );

	return $title;
}
add_filter( 'wp_title', 'theme_custom_title' );

// Remove extra stuff from header
remove_action( 'wp_head', 'wp_generator' ); // WordPress version number
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Add theme stylesheet, jQuery (maybe from Google), scripts, ajaxurl and nounce
function theme_scripts() {
	wp_register_style( 'hovedspring-forbudt', get_stylesheet_uri(), false, HOVEDSPRING_FORBUDT_VERSION );
	wp_enqueue_style( 'hovedspring-forbudt' );
	if ( ! is_404() ) :
		//wp_deregister_script( 'jquery' );
		//wp_register_script( 'jquery', ( 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js' ), false, '1.6.4' );
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'hovedspring-forbudt-script', get_template_directory_uri() . '/scripts.js', array( 'jquery' ), HOVEDSPRING_FORBUDT_VERSION );
		wp_enqueue_script( 'hovedspring-forbudt-script' );
		wp_localize_script( 'hovedspring-forbudt-script', 'hovedspringforbudtAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'fakta_update' ) ) );
	endif;
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

// Pingback
function theme_pingback() {
	echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
}
add_action( 'wp_head', 'theme_pingback' );

// Favicon
function theme_favicon() {
	echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/images/favicon.gif" sizes="16x16" type="image/gif" />' . "\n";
	echo '<link rel="icon" href="' . get_template_directory_uri() . '/images/favicon.gif" sizes="16x16" type="image/gif" />' . "\n";
	echo '<link rel="apple-touch-icon" href="' . get_template_directory_uri() . '/images/apple-touch-icon-57x57.png" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="72x72" href="' . get_template_directory_uri() . '/images/apple-touch-icon-72x72.png" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="114x114" href="' . get_template_directory_uri() . '/images/apple-touch-icon-114x114.png" />' . "\n";
}
//add_action( 'wp_head', 'theme_favicon' );

function fakta_ajax_update() {
	check_ajax_referer( 'fakta_update', 'security' );
	
	$args = array( 'post_type' => 'post', 'post_status' => 'publish', 'orderby' => 'rand', 'posts_per_page' => 1 );
	$random_facts = new WP_Query( $args );
	while ( $random_facts->have_posts() ) : $random_facts->the_post();
		get_template_part( 'content', $theme_post_format );
	endwhile;

	die();
}
add_action( 'wp_ajax_fakta_update', 'fakta_ajax_update' );
add_action( 'wp_ajax_nopriv_fakta_update', 'fakta_ajax_update' ); ?>