<?php
/************* GLOBAL CONTENT WIDTH ***************/
if ( !isset($content_width)) { $content_width = 600; }

if ( !function_exists( 'cb_adjust_cw' )) {
    function cb_adjust_cw() {
       global $content_width, $post;
       if ($post != NULL) {
           $cb_custom_fields = get_post_custom();
           if (isset($cb_custom_fields['cb_full_width_post'][0])) {$content_width = 940;}           
       }
     
        if ( is_page_template( 'template-full-width.php' ) )
            $content_width = 940; 
    }
}
add_action( 'template_redirect', 'cb_adjust_cw' );

/************* LOAD NEEDED FILES ***************/

require_once('library/core-functions.php');
require_once('library/translation/translation.php');

// Load Framework
add_filter( 'ot_show_pages', '__return_false' ); 
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
include_once get_template_directory().'/option-tree/ot-loader.php';
include_once get_template_directory().'/library/extensions/theme-options.php';

/************* THUMBNAIL SIZE OPTIONS *************/

add_image_size('cb-thumb-90-crop', 90, 90, true); // Used on sidebar widgets 
add_image_size('cb-thumb-220-crop', 220, 180, true ); // Used on Category Style A, Top Reviews Template
add_image_size('cb-thumb-350-crop', 350, 200, true ); // Used on Category Style B, Module B, Grid 6, Grid 7, Related Posts
add_image_size('cb-thumb-380-crop', 380, 380, true ); // Used on Grid 4, Grid 5, Grid 6, Grid 7, Gallery
add_image_size('cb-thumb-600-crop', 640, '515', true ); // Used on Featured Image, Grid 3, Grid 4, Grid 5, Grid 6, Grid 7
add_image_size('cb-thumb-1020-crop', 1020, '500', true ); // Used on Full-width Slider and content-width featured images
add_image_size('cb-thumb-1400', 1400, '', true ); // Used on Full-BG featured images

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
if ( ! function_exists( 'cb_register_sidebars' ) ) {
    function cb_register_sidebars() {
    	// Sidebar Widget Area 1
        register_sidebar(array(
            'name' => 'Sidebar',
            'id' => 'sidebar-1',
            'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-sidebar-widget-title">',
            'after_title' => '</h3>'
        ));
    
        // Footer 1
        register_sidebar(array(
            'name' => 'Footer 1',
            'id' => 'footer-1',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-footer-widget-title">',
            'after_title' => '</h3>'
        ));
        // Footer 2
        register_sidebar(array(
            'name' => 'Footer 2',
            'id' => 'footer-2',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-footer-widget-title">',      
    		'after_title' => '</h3>'
        ));	
        // Footer 3
        register_sidebar(array(
            'name' => 'Footer 3',
            'id' => 'footer-3',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-footer-widget-title">',
    		'after_title' => '</h3>'
        ));	
        // Footer 4
        register_sidebar(array(
            'name' => 'Footer 4',
            'id' => 'footer-4',
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-footer-widget-title">',
            'after_title' => '</h3>'
        ));    
    }
}
/*********************
SCRIPTS & ENQUEUEING
*********************/
add_action('after_setup_theme','cb_script_loaders', 15);

if ( ! function_exists( 'cb_script_loaders' ) ) {
    function cb_script_loaders() {
        // enqueue base scripts and styles
        add_action('wp_enqueue_scripts', 'cb_scripts_and_styles', 999);
    	// enqueue admin scripts and styles
    	add_action('admin_enqueue_scripts', 'cb_post_admin_scripts_and_styles');
    	// ie conditional wrapper
        add_filter( 'style_loader_tag', 'cb_ie_conditional', 10, 2 );
    }
}
if ( ! function_exists( 'cb_scripts_and_styles' ) ) {
    function cb_scripts_and_styles() {
      if (!is_admin()) {
        // modernizr (without media query polyfill)
        wp_register_script( 'cb-modernizr',  get_template_directory_uri(). '/library/js/modernizr.custom.min.js', array(), '2.6.2', false );
    	wp_enqueue_script('cb-modernizr'); // enqueue it
        // register main stylesheet
        wp_register_style( 'cb-main-stylesheet',  get_template_directory_uri() . '/library/css/style.css', array(), '1.0', 'all' );
    	wp_enqueue_style('cb-main-stylesheet'); // enqueue it
    	// register flexslider stylesheet
    	wp_register_style('flexslider', get_template_directory_uri() . '/library/css/flexslider.css', array(), '2.0', 'all');
       	wp_enqueue_style('flexslider'); // enqueue it
        // ie-only stylesheet
        wp_register_style( 'cb-ie-only',  get_template_directory_uri(). '/library/css/ie.css', array(), '1.0' );
        wp_enqueue_style('cb-ie-only'); // enqueue it	
        // comment reply script for threaded comments
        if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) { global $wp_scripts; $wp_scripts->add_data('comment-reply', 'group', 1 ); wp_enqueue_script( 'comment-reply' );}
    	// Load Flexslider (Must be loaded in head)
        wp_register_script( 'cb-flexslider',  get_template_directory_uri() . '/library/js/jquery.flexslider-min.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-flexslider' ); // enqueue it
        // Load Superfish
        wp_register_script( 'cb-superfish',  get_template_directory_uri() . '/library/js/superfish.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-superfish' ); // enqueue it
        // Load Hover Intent
        wp_register_script( 'cb-hoverIntent',  get_template_directory_uri() . '/library/js/hoverIntent.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-hoverIntent' ); // enqueue it
    	// Load lightbox
    	$cb_lightbox_onoff = ot_get_option('cb_lightbox_onoff', "on");
         if ($cb_lightbox_onoff != 'off') {
            wp_register_script( 'cb-lightbox',  get_template_directory_uri() . '/library/js/jquery.fs.boxer.js', array( 'jquery' ),'', true);
            wp_enqueue_script( 'cb-lightbox' ); // enqueue it
         }
        // Load Cookie 
        wp_register_script( 'cb-cookie',  get_template_directory_uri() . '/library/js/cookie.min.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-cookie' ); // enqueue it
    	// Load Fitvids
        wp_register_script( 'cb-fitvid',  get_template_directory_uri() . '/library/js/jquery.fitvids.min.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-fitvid' ); // enqueue it
        // Load Jquery Tools
        wp_register_script( 'cb-jquery-tools',  get_template_directory_uri() . '/library/js/jquery.tools.min.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-jquery-tools' ); // enqueue it
    	// Load Backstretch
        wp_register_script( 'cb-backstretch',  get_template_directory_uri() . '/library/js/jquery.backstretch.min.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-backstretch' ); // enqueue it
    	// Load Tabs
        wp_register_script( 'cb-tabs',  get_template_directory_uri() . '/library/js/jquery.tabber.min.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-tabs' ); // enqueue it
    	// Load scripts
        wp_register_script( 'cb-js',  get_template_directory_uri() . '/library/js/cb-scripts.js', array( 'jquery' ),'', true);
        wp_enqueue_script( 'cb-js' ); // enqueue it
      }
    }
}

if ( ! function_exists( 'cb_post_admin_scripts_and_styles' ) ) {
    function cb_post_admin_scripts_and_styles($hook) {
    	// loading admin styles only on edit + posts + new posts
    	if( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'profile.php' || $hook == 'user-edit.php' || $hook == 'themes.php') {
    			wp_register_style( 'cb-admin-css',  get_template_directory_uri(). '/library/css/admin.css', array(), '' );
    			wp_enqueue_style('cb-admin-css'); // enqueue it	
    			wp_register_script( 'admin-js',  get_template_directory_uri() . '/library/js/cb-admin.js', array(), '', true);
    			wp_enqueue_script( 'admin-js' ); // enqueue it
    		}
    }
}

// adding the conditional wrapper around ie stylesheet
// source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
if ( ! function_exists( 'cb_ie_conditional' ) ) {
    function cb_ie_conditional( $tag, $handle ) {
    	if ( 'cb-ie-only' == $handle ) {
    		$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
        }
    	return $tag;
    }
}

/*********************
Load bundled extensions
********************/
if ( ! function_exists( 'cb_bundled_extras' ) ) {
    function cb_bundled_extras() {
    
    	require_once get_template_directory() . '/library/extensions/cb-125-ads-widget.php';
        require_once get_template_directory() . '/library/extensions/cb-recent-posts-widget.php';
        require_once get_template_directory() . '/library/extensions/cb-random-post-widget.php';
    	require_once get_template_directory() . '/library/extensions/cb-social-media-widget.php';
    	require_once get_template_directory() . '/library/extensions/cb-tabs-widget.php';
    	require_once get_template_directory() . '/library/extensions/cb-top-reviews-widget.php';
    	require_once get_template_directory() . '/library/extensions/cb-facebook-like-widget.php';
    	require_once get_template_directory() . '/library/extensions/shortcodes/cb-shortcodes.php';
    	require_once get_template_directory() . '/library/extensions/Tax-meta-class/cb-class-config.php';
    	require_once get_template_directory() . '/library/extensions/meta-box/cb-meta-boxes.php';
    	require_once get_template_directory() . '/library/extensions/meta-box/meta-box.php';
    	
     	$jetpack_mods = get_option( 'jetpack_active_modules' );
    	
    	if ($jetpack_mods == NULL) {$jetpack_mods = array();}
    	
        if (!in_array( 'shortcodes', $jetpack_mods )) { require_once get_template_directory() . '/library/extensions/soundcloud-shortcode.php'; }
    }
}

// fire up bundled extras
add_action('after_setup_theme', 'cb_bundled_extras', 17);

// Review meta box + Top Reviews template meta box
if (is_admin()){	

	require_once get_template_directory() . '/library/extensions/cb-custom-meta.php';
}