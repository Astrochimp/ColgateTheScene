<?php
// we're firing all initial functions at the start
add_action('after_setup_theme','cb_start', 15);

function cb_start() {
    // launching operation cleanup
    add_action('init', 'cb_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'cb_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'cb_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'cb_remove_recent_comments_style', 1);
    // launching this stuff after theme setup
    add_action('after_setup_theme','cb_theme_support', 16);
    // adding sidebars to Wordpress 
    add_action( 'widgets_init', 'cb_register_sidebars' );
	// Google Analytics optimised in footer
    add_action('wp_footer', 'add_google_analytics');
    //Disquss
    add_action('wp_footer', 'cb_disqus_comments');
	// user rating loaded in footer
	add_action('wp_footer', 'cb_user_rating');
    // cleaning up random code around images
    add_filter('the_content', 'cb_filter_ptags_on_images');
    // cleaning up excerpt
    add_filter('excerpt_more', 'cb_clean_excerpt'); 
	// Change gallery only if lightbox is on
	$cb_lightbox_onoff = ot_get_option('cb_lightbox_onoff', "on");
	if ($cb_lightbox_onoff != 'off') {
	// get rid of wordpress' default gallery shortcode
	remove_shortcode('gallery', 'gallery_shortcode');
	// custom gallery shortcode
	add_shortcode('gallery', 'cb_gallery_shortcode');
	}
	// custom sidebars for categories
	add_action( 'widgets_init', 'cb_sidebar_categories' );
} /* end cb_start */

function cb_head_cleanup() {
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'cb_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'cb_remove_wp_ver_css_js', 9999 );
} /* end cb_head_cleanup */

// remove WP version from RSS
function cb_rss_version() { return ''; }

// remove WP version from scripts
if ( ! function_exists( 'cb_remove_wp_ver_css_js' ) ) {  
    function cb_remove_wp_ver_css_js( $src ) {
        if ( strpos( $src, 'ver=' ) )
            $src = remove_query_arg( 'ver', $src );
        return $src;
    }
}
// remove injected CSS for recent comments widget
if ( ! function_exists( 'cb_remove_wp_widget_recent_comments_style' ) ) {      
    function cb_remove_wp_widget_recent_comments_style() {
       if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
          remove_filter('wp_head', 'wp_widget_recent_comments_style' );
       }
    }
    }
// remove injected CSS from recent comments widget
    if ( ! function_exists( 'cb_remove_recent_comments_style' ) ) { 
    function cb_remove_recent_comments_style() {
      global $wp_widget_factory;
      if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
      }
    }
    }
/*********************
THEME SUPPORT
*********************/

// Adding Functions & Theme Support
if ( ! function_exists( 'cb_theme_support' ) ) { 
    function cb_theme_support() {
    	
    	// wp thumbnails 
    	add_theme_support('post-thumbnails');
    	// default thumb size
    	set_post_thumbnail_size(125, 125, true);
    	// RSS 
    	add_theme_support('automatic-feed-links');
    	// adding post format support
    	add_theme_support( 'post-formats',
    		array(
    			'video',             // video
    			'audio',             // audio
    		)
    	);
    	// wp menus
    	add_theme_support( 'menus' );
    	// registering menus
    	register_nav_menus(
    		array(
    	'top' => 'Top Navigation Menu', // top nav
        'main' => 'Main Navigation Menu', // main nav in header
        'footer' => 'Footer Navigation Menu',  // secondary nav in footer
    		)
    	);
    } /* end theme support */
}

// Load Optimised Google Analytics in the footer
if ( ! function_exists( 'add_google_analytics' ) ) { 
    function add_google_analytics() { 
        $cb_google_analytics = ot_get_option('cb_google_analytics', false);
        
        if ($cb_google_analytics !== false) {
        $google = "<!-- Optimised Asynchronous Google Analytics -->";
        $google .= "<script>";
        $google .= "var _gaq=[['_setAccount','".$cb_google_analytics."'],['_trackPageview']];
                (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
                g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
                s.parentNode.insertBefore(g,s)}(document,'script'));";
        $google .= "</script>";
        
        echo $google; }
    }
}

// Load Optimised Google Analytics in the footer
if ( ! function_exists( 'cb_disqus_comments' ) ) { 
    function cb_disqus_comments() {
         
        $cb_disqus_code = ot_get_option('cb_disqus_shortname', NULL);

        $cb_disqus_output = "<script type='text/javascript'>var disqus_shortname = '". $cb_disqus_code ."'; // required: replace example with your forum shortname
                                (function () {
                                    var s = document.createElement('script'); s.async = true;
                                    s.type = 'text/javascript';
                                    s.src = '//' + disqus_shortname + '.disqus.com/count.js';
                                    (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
                                }());
                                </script>";
                                
            
        if ( $cb_disqus_code != NULL ) { echo $cb_disqus_output; }
    }
}
            
/*********************
MENUS & NAVIGATION
*********************/
// Top Nav
if ( ! function_exists( 'top_nav' ) ) { 
    function top_nav(){
       wp_nav_menu(
    	array(
    		'theme_location'  => 'top',
    		'container_class' => 'menu-12312-container',  
    		'menu_class' => 'menu', 
    		'items_wrap' => '<ul class="cb-top-nav sf-menu">%3$s</ul>',
    		'fallback_cb' => 'none' 	
    		  )	); 
        }
}		  
// Main Nav	  
if ( ! function_exists( 'main_nav' ) ) { 
    function main_nav() {	
    wp_nav_menu(
    	array(
        	'container_class' => 'cb-main-menu',  			// class of container 
        	'theme_location' => 'main',                     // where it's located in the theme
            'depth' => 0,                                   // limit the depth of the nav
    		'items_wrap' => '<ul class="nav main-nav clearfix">%3$s</ul>',
    		'fallback_cb' => 'none'							// no fallback
    
    	)	); 
    }
}
// Footer Nav	
if ( ! function_exists( 'footer_nav' ) ) {
    function footer_nav()    {
        wp_nav_menu(
    	array(
        	'container_class' => 'footer-links clearfix',   // class of container 
        	'menu' => 'Footer Links',   					// nav name
        	'menu_class' => 'nav cb-footer-nav clearfix',   // adding custom nav class
        	'theme_location' => 'footer',            		// where it's located in the theme
            'depth' => 0,                                   // limit the depth of the nav
    		'fallback_cb' => 'none'							// no fallback
    		) 	); 
    }
}
	
/*********************
CUSTOM WALKER
*********************/	
class CB_Walker extends Walker_Nav_Menu { 
	protected $cb_menu_css = array();

	function start_el(&$output, $object, $depth, $args = array()) {
        parent::start_el($output, $object, $depth, $args);

		$cb_base_color = ot_get_option('cb_base_color', '#cc3939');
		$cb_color = get_tax_meta($object->object_id,'cb_color_field_id');
		
		$cb_current_type = $object->object;		
		
		if ($cb_current_type == 'category') {

					if (($cb_color) && ($cb_color != '#') && ($cb_color != NULL)) {
									$this->cb_menu_css[] .='.menu-item-'. $object->ID . ':hover, .menu-item-'. $object->ID . ':focus, .menu-item-'. $object->ID . ' ul li {background-color:'.$cb_color.';}'; }
					else {
									$this->cb_menu_css[] .='.menu-item-'. $object->ID . ':hover, .menu-item-'. $object->ID . ':focus, .menu-item-'. $object->ID . ' ul li {background-color:'.$cb_base_color.';}';}
		} else {
		
			$cb_page_color = get_post_meta($object->object_id,'cb_overall_color_post');
			if (($cb_page_color) && ($cb_page_color[0] != '#')) {
						$this->cb_menu_css[] .= '.menu-item-'. $object->ID . ':hover, .menu-item-'. $object->ID . ':focus, .menu-item-'. $object->ID . ' ul li {background-color:'.$cb_page_color[0].';}';
				} else {
						$this->cb_menu_css[] .= '.menu-item-'. $object->ID . ':hover, .menu-item-'. $object->ID . ':focus, .menu-item-'. $object->ID . ' ul li {background-color:'.$cb_base_color.';}';
				}
		}
			
		 add_action( 'wp_head', array( $this, 'cb_menu_css' ) );
	}

	public function cb_menu_css() {
        print '<style>' . join( "\n", $this->cb_menu_css ) . '</style>';
    }

}	
/*********************
ADD SEARCH BOX TO MAIN MENU
*********************/
if ( ! function_exists( 'cb_add_search_main_menu' ) ) {
    function cb_add_search_main_menu($content, $args) {
        $cb_search_in_bar = ot_get_option('cb_search_in_bar', 'on');
        
        if ( $cb_search_in_bar == 'on' ) {
            if( $args->theme_location == 'main' ) {
                ob_start();
                get_search_form();        
                $content .= '<li class="cb-search">' . ob_get_contents() . '</li>';
                ob_end_clean();
            }
        }
        return $content;
    }
}
add_filter('wp_nav_menu_items','cb_add_search_main_menu', 10, 2);


/*********************
REMOVE WORDPRESS' EXTRA <P> TAGS ON HOMEPAGE!
*********************/
if ( ! function_exists( 'cb_clean_up_p' ) ) {
    function cb_clean_up_p($content){
    	if(is_front_page() ) {
    		$content = preg_replace('/(<p>)\s*(<div)/','<div',$content);
    		$content =  preg_replace('/(<\/div>)\s*(<\/p>)/', '</div>', $content);
    	}
    	return $content;
    }
}

add_filter('the_content','cb_clean_up_p', 11);

/*********************
LOAD EDITOR STYLE
*********************/
if ( ! function_exists( 'cb_editor_style' ) ) {
    function cb_editor_style() {
        add_editor_style( 'library/css/editor-style.css' );
    }
}
add_action( 'init', 'cb_editor_style' );

/*********************
CUSTOM SIDEBAR FOR CATEGORIES
*********************/
if ( ! function_exists( 'cb_sidebar_categories' ) ) {
    function cb_sidebar_categories() {
    	
    	register_sidebar(
    		array(
    			'name' => 'Ciola Tabs',
    			'id' => 'cb_tabs',
    			'description' => 'If you want to show up to three widgets with tabs, add the widgets here.',
    			'before_widget' => '<div id="%1$s" class="widget cb-tabs tabbertab %2$s">',
    			'after_widget' => '</div>',
    			'before_title' => '<h3 class="widget-title">',
    			'after_title' => '</h3>'
    		)
    	);
    	
    	$categories = get_categories( array( 'hide_empty'=> 0 ) );
    
    	foreach ( $categories as $category ) {
    			register_sidebar( array(
    				'name' => $category->cat_name,
    				'id' => $category->category_nicename . '-sidebar',
    				'description' => 'This is the ' . $category->cat_name . ' sidebar',
         			'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
         		    'after_widget' => '</div>',
         		    'before_title' => '<h3 class="cb-sidebar-widget-title">',
          		  'after_title' => '</h3>'
    			) );
    	}
    	
    	$pages = get_pages();
    
    	foreach ( $pages as $page ) {
    		
    		$cb_custom_fields = get_post_custom($page->ID);
    		if (isset($cb_custom_fields['cb_page_sidebar'][0])) { $cb_page_sidebar = $cb_custom_fields['cb_page_sidebar'][0]; } else { $cb_page_sidebar = 'off';}
    		
    			if ($cb_page_sidebar == 'On'){ 
    			register_sidebar( array(
    				'name' => $page->post_title .' (Page)',
    				'id' => 'page-'.$page->ID . '-sidebar',
    				'description' => 'This is the ' . $page->post_title . ' sidebar',
         			'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
         		    'after_widget' => '</div>',
         		    'before_title' => '<h3 class="cb-sidebar-widget-title">',
          		  'after_title' => '</h3>'
    			) );
    			}
    	}
    }
}

/*********************
LOAD FAVICON + WINDOWS 8 TILE
*********************/
if ( ! function_exists( 'cb_load_icons' ) ) {
    function cb_load_icons() {	
    
    	$cb_win8_tile_url =	ot_get_option('cb_win8_tile_url', false);
    	$cb_favicon_url = ot_get_option('cb_favicon_url', false);
    	$cb_win8_tile_color = ot_get_option('cb_win8_tile_color', false);
    	if ($cb_favicon_url !== false) {
    		echo '<link rel="shortcut icon" href="'.$cb_favicon_url.'">';
    	} 
    	if ($cb_win8_tile_url !== false) {
    		echo '<meta name="msapplication-TileColor" content="'.$cb_win8_tile_color.'">
    			  <meta name="msapplication-TileImage" content="'.$cb_win8_tile_url.'">';
    	} 
    }
}
/*********************
LOAD USER FONT
*********************/
if ( ! function_exists( 'cb_load_fonts' ) ) {
    function cb_load_fonts() {
    	
    	$cb_header_font = ot_get_option('cb_header_font', "'Droid Serif', serif;");
    	$cb_user_header_font = ot_get_option('cb_user_header_font', "");
    	$cb_body_font = ot_get_option('cb_body_font', "'Arimo', sans-serif;");	
        $cb_user_body_font = ot_get_option('cb_user_body_font', "");
    	
    	if ($cb_user_header_font != NULL) { $cb_header_font = $cb_user_header_font; }
    	if ($cb_user_body_font != NULL) { $cb_body_font = $cb_user_body_font; }

        $cb_header_font_clean =  substr($cb_header_font, 0, strpos($cb_header_font, ',') );
        $cb_header_font_clean = str_replace("'", '', $cb_header_font_clean);
        $cb_header_font_clean = str_replace(" ", '+', $cb_header_font_clean);  
        $cb_body_font_clean =  substr($cb_body_font, 0, strpos($cb_body_font, ',') );
        $cb_body_font_clean = str_replace("'", '', $cb_body_font_clean);
        $cb_body_font_clean = str_replace(" ", '+', $cb_body_font_clean);   
    	
    	echo '<link href="//fonts.googleapis.com/css?family='.$cb_header_font_clean.':400,700,700italic,400italic" rel="stylesheet" type="text/css">';
    	echo '<link href="//fonts.googleapis.com/css?family='.$cb_body_font_clean.':400,700,400italic" rel="stylesheet" type="text/css">';
    	echo '<style type="text/css">	
    				body {font-family: '.$cb_body_font.'}
    				h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, button, .button, .button-square, #menu-main-nav-menu, #cb-main-menu, #cb-main-menu-mob, .comment-reply-link, blockquote, input, select, textarea, .alert, .widget_tag_cloud a, .wp-caption, #cb-top-menu, .header-font, .cb_page_navi a, .page-404, .widget_calendar, ul.tabbernav li a,  .cb-author-box a, .cb-score-box .score-title, .star-bar .title, .normal-bar .title, .cb-user-score, .comment-author .fn, .tabs li a, .button-round, .cb-review-box-top .cb-score-box-star .score, .cb-review-box-top .cb-score-box .score, table tr th, #respond form label, #respond form small  {font-family:'.$cb_header_font.'} :-moz-placeholder {font-family:'.$cb_header_font.'} ::-webkit-input-placeholder {font-family:'.$cb_header_font.'} :-ms-input-placeholder {font-family:'.$cb_header_font.'} ::-moz-placeholder {font-family:'.$cb_header_font.'}
    		  </style>';
    }
}
add_action('wp_head', 'cb_load_fonts');

/*********************
CLEAN BYLINE
*********************/
if ( ! function_exists( 'cb_byline' ) ) {
    function cb_byline( $cb_post_id = NULL, $cb_comments = true, $cb_category = true ) {
        $cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
        $cb_disqus_code = ot_get_option('cb_disqus_shortname', NULL);
        $category_data = NULL;
        $j = 1;

        foreach( ( get_the_category() ) as $category )  {
                $category_name = $category->cat_name;
                $category_url = get_category_link($category);
                if ((count(get_the_category()) > 1) && ($j != 1)) { $category_data .= ',';}
                $category_data .= ' <a href="'.$category_url.'">'.$category_name.'</a>';
                $j++;
                
            }
        $cat_com_url = get_comments_link();
        
        if ( $cb_meta_onoff == 'on' ) { ?>
            <p class="cb-byline vcard"><?php printf(__('By <span class="author" itemprop="author">%1$s</span> on <time class="updated" datetime="%2$s" pubdate>%3$s</time>', 'cubell'), cb_get_the_author_posts_link(), get_the_time('Y-m-j'), get_the_time(get_option('date_format')) ); ?> <?php if ( !is_attachment() && ( $cb_category == true ) ) { echo __( 'in', 'cubell' ); echo $category_data; } ?></p>
        <?php } 
        if ( $cb_comments == true ) {
            echo cb_comment_line();
       }
    }
}

if ( ! function_exists( 'cb_comment_line' ) ) {
    function cb_comment_line( $cb_post_id = NULL ) {
        $cb_output = NULL;

        $cb_disqus_code = ot_get_option('cb_disqus_shortname', NULL);

        if ( $cb_disqus_code == NULL ) {

            if (get_comments_number() > 0) {
                $cat_com_url = get_comments_link(); 
                $cb_output = '<a href="' . $cat_com_url .'" class="cb-comments">'. get_comments_number() .'</a>';
            } 
                
        } else { 
             $cb_output = '<a href="'. get_permalink( $cb_post_id ). '#disqus_thread' . '" class="cb-comments"></a>';
        }

        return $cb_output;
    }

}

/*********************
LOAD CUSTOM CSS
*********************/
if ( ! function_exists( 'cb_custom_css' ) ) {
    function cb_custom_css(){
            $cb_custom_css = ot_get_option('cb_custom_css', false);
            if ($cb_custom_css) {echo '<style>'.$cb_custom_css.'</style>';} 
    }
}
add_action('wp_head', 'cb_custom_css');

/*********************
LOAD USER COLORS/BACKGROUNDS
*********************/
if ( ! function_exists( 'cb_user_colors' ) ) {
    function cb_user_colors() {
        
        if ( is_single() == true ) { 
            global $post;
            $cb_post_type = get_post_type();
        } else {
                $cb_post_type = $post = NULL;
        }
    	$cb_base_color = ot_get_option('cb_base_color', '#cc3939');
    	$cb_background_color = ot_get_option('cb_background_colour', '');
    	$cb_background_image = ot_get_option('cb_background_image', '');
    	$cb_background_image_setting = ot_get_option('cb_bg_image_setting', '1'); 
    	 
    	if ($post != NULL) {$cb_custom_fields = get_post_custom(); }
    	$cb_override_background_color = NULL;
    	$cb_override_background_image = NULL;
    	$featured_image_full_bg = NULL;
    
    if (is_date() || is_author() || is_tag() || is_tax() || is_404() || is_search() || is_attachment() ) {
    	$cb_color = $cb_base_color;
    } elseif (is_category()) {
    	
    	$cat_id = get_query_var('cat');        
        $cb_parents = get_category_parents($cat_id, FALSE, '.' ,true);
        $cb_parent_slug = explode('.',$cb_parents);
        $parent_cat = get_category_by_slug($cb_parent_slug[0]);
    	$cb_color = get_tax_meta($parent_cat,'cb_color_field_id');
    	$cb_override_background_color = get_tax_meta($cat_id,'cb_bg_color_field_id');
    	$cb_cat_background_image = get_tax_meta($cat_id,'cb_bg_image_field_id');
    	$cb_single_bg_image_setting[] = get_tax_meta($cat_id,'cb_bg_image_setting_op');
        
        
    	
    	if ($cb_color == '#') {
    		$cb_color = $cb_base_color;
    	} 
    	
    	if ($cb_cat_background_image == NULL) {	
    		$cb_cat_background_image = get_tax_meta($parent_cat,'cb_bg_image_field_id');
    	}
    	
    	if ($cb_override_background_color == '#') {
    		$cb_override_background_color = NULL;
    		}
    	
    	if ($cb_cat_background_image != NULL) {
    		$cb_override_background_image	= $cb_cat_background_image['src'];
    	} else {
    		$cb_override_background_image = NULL;
    	}	
    }  elseif ( $cb_post_type == 'post' )  {
    		
    		$format = get_post_format($post->ID);
    			
    		$cb_custom_fields = get_post_custom($post->ID);
    		
    		if (isset($cb_custom_fields['cb_featured_image_settings_post'][0])) {$cb_featured_image_settings = $cb_custom_fields['cb_featured_image_settings_post'][0]; } else {$cb_featured_image_settings = 'Normal';}
    		if ((!$format) && ($cb_featured_image_settings == "Full-BG with Void")) $featured_image_full_bg = true; 
    		
            $category = get_the_category($post->ID); 
            $cat_id = $category[0]->cat_ID;
            $cb_parents = get_category_parents($cat_id, FALSE, '.' ,true);
            $cb_parent_slug = explode('.',$cb_parents);
            $parentid = get_category_by_slug($cb_parent_slug[0]);
            $cb_color = get_tax_meta($parentid,'cb_color_field_id');
    		
    		if ($cb_color == '#') {
    			$cb_color = $cb_base_color;
    		} 
    
    		$cb_post_background_color = get_post_meta($post->ID,'cb_bg_color_post');
    		$cb_single_bg_image = get_post_meta($post->ID,'cb_bg_image_post');
    		$cb_single_bg_image_setting = get_post_meta($post->ID,'cb_bg_image_post_setting');
   

    		if ($cb_single_bg_image != NULL ){
    			if (is_array($cb_single_bg_image) && count($cb_single_bg_image) > 1){

    				$i = 0;
    				$cb_bg_slideshow = true;
    				$cb_override_background_image = array();
    				foreach ($cb_single_bg_image as $bg_image) {
    					$cb_override_background_image_url_array = wp_get_attachment_image_src($bg_image, 'full');
    					
    					$cb_override_background_image[] = $cb_override_background_image_url_array[0];
    					$i++;		
    				}
    							
    			} else {
    				$cb_override_background_image_url = wp_get_attachment_image_src($cb_single_bg_image[0]);
    				$cb_override_background_image = $cb_override_background_image_url[0]; 
                    
    			}
    		}
    		
    		if (($cb_post_background_color) && ($cb_post_background_color != '#')) {
    			
    			$cb_override_background_color = $cb_post_background_color[0];
    		}	
    		
    		if ((!$cb_single_bg_image) && (!$cb_post_background_color)) {
    				
    				$cb_override_background_color = get_tax_meta($cat_id,'cb_bg_color_field_id');
    				$cb_cat_background_image = get_tax_meta($cat_id,'cb_bg_image_field_id');
    				$cb_single_bg_image_setting[] = get_tax_meta($cat_id,'cb_bg_image_setting_op');
    				
    				if ($cb_cat_background_image == NULL) {	
    					$cb_cat_background_image = get_tax_meta($parentid,'cb_bg_image_field_id');
    				}
    				
    				if ($cb_override_background_color == '#') {
    					$cb_override_background_color = NULL;
    					}
    				
    				if ($cb_cat_background_image != NULL) {
    					$cb_override_background_image	= $cb_cat_background_image['src'];
    				} else {
    					$cb_override_background_image = NULL;
    				}	
    		}
    } elseif ( $cb_post_type == 'page' ) {
    		
    		$format = get_post_format($post->ID);
    		
    		if (isset($cb_custom_fields['cb_overall_color_post'][0])) { $cb_page_base_color = $cb_custom_fields['cb_overall_color_post'][0]; } else {$cb_page_base_color = NULL;}
    		if (isset($cb_page_base_color) && ($cb_page_base_color == '#')) {$cb_page_base_color = NULL;}
    		
    		$cb_page_bg_color = get_post_meta($post->ID,'cb_bg_color_post');
    		$cb_page_bg_image = get_post_meta($post->ID,'cb_bg_image_post');	
    		$cb_single_bg_image_setting = get_post_meta($post->ID,'cb_bg_image_post_setting');
    
    		if (!$cb_page_base_color) {
    			$cb_color = $cb_base_color;
    		} else {
    			$cb_color = $cb_page_base_color;
    		}
    		
    		if ($cb_page_bg_image){
    	
    				$cb_override_background_image_url = wp_get_attachment_image_src($cb_page_bg_image[0], 'full');
    				$cb_override_background_image = $cb_override_background_image_url[0]; 
    		}
    		
    		if (($cb_page_bg_color) && ($cb_page_bg_color != '#')) {
    			
    			$cb_override_background_color = $cb_page_bg_color[0];
    		}	
    } else {
    			$cb_color = $cb_base_color;
 	}
    	
    	if (!$cb_color) $cb_color = $cb_base_color;
    
    	if (($cb_override_background_image) && (!$featured_image_full_bg) ) { 
    
    				if ($cb_single_bg_image_setting[0] == '1') { 
    ?>
    							<script>
    								jQuery(document).ready(function($){
    									$.backstretch(
    										<?php 
    										if (is_array($cb_override_background_image) && count($cb_override_background_image) > 1){ echo '[';
    											foreach ($cb_override_background_image as $cb_bg_slide) {
    												echo '"'.$cb_bg_slide.'", ';
    											}
    											echo '],  {fade: 750, duration: 6000}';
    									   } else { 
    										   echo  '"'.$cb_override_background_image.'",  {fade: 750}';
    									   } 
    									   ?>
    									 );	
    									 
    								});
    							</script>
    	
    <?php 		} elseif ($cb_single_bg_image_setting[0] == '2') { ?>
    					<style type="text/css">
    						body {background: url(<?php if (is_array($cb_override_background_image) && count($cb_override_background_image) > 1) { echo $cb_override_background_image[0]; } else {echo $cb_override_background_image;}; ?>) repeat; }
    					</style>
    	
    <?php		} elseif ($cb_single_bg_image_setting[0] == '3') { ?>
    					<style type="text/css">
    						body {background: url(<?php if (is_array($cb_override_background_image) && count($cb_override_background_image) > 1) { echo $cb_override_background_image[0]; } else {echo $cb_override_background_image;}; ?>) no-repeat; }
    					</style>			
    <?php		}
    	
    	} elseif ((!$cb_override_background_color) && ($cb_background_image) && (!$featured_image_full_bg)  && ($cb_background_image_setting == '1')) { ?>
    
    	<script>
    		jQuery(document).ready(function($){
    			$.backstretch("<?php echo $cb_background_image; ?>");	
    		});
    	</script>
    
    <?php } elseif ((!$cb_override_background_color) && ($cb_background_image) && (!$featured_image_full_bg)  && ($cb_background_image_setting == '2')) { ?>
    		
    		
    		<style type="text/css">
    			body {background: url(<?php echo $cb_background_image; ?>) repeat; }
    		</style>
    
    
    <?php } elseif ((!$cb_override_background_color) && ($cb_background_image) && (!$featured_image_full_bg)  && ($cb_background_image_setting == '3')) { ?>
    
    		<style type="text/css">
    			body {background: url(<?php echo $cb_background_image; ?>) no-repeat; }
    		</style>
    
    <?php } ?>
    
    <style type="text/css">
    
    <?php if ($cb_override_background_color != NULL) { ?>
    	body {background-color: <?php if ($cb_override_background_image) { echo '#151515;';} else {echo $cb_override_background_color;} ?>;} 
    	
    <?php } elseif ($cb_background_color != NULL) { 
    				if (($cb_override_background_image) || ($cb_background_image)) {echo '#cb-inner-header, #cb-content, #cb-top-menu, .cb-main-menu {border-right:solid 1px #ddd; border-left:solid 1px #ddd;}';}
    ?>
    				body { background-color: <?php if (($cb_override_background_image) || ($cb_background_image)) {echo '#151515;'; } else {echo $cb_background_color;} ?>; }
    	
    <?php } elseif ($cb_background_color == NULL){ 
    				 if (($cb_override_background_image) || ($cb_background_image)) { echo 'body {background-color: #151515;}'; }
    	} ?>
    
    .main-nav, #cb-sidebar .cb-sidebar-widget-title, ul.tabbernav, .tabs li a, .cb-module-title {border-bottom-color: <?php echo $cb_color;?>;}
    
    #cb-sidebar .cb-top-reviews-widget li:hover .cb-countdown, #cb-sidebar .cb-top-reviews-widget li:focus .cb-countdown, .cb-others:hover .cb-countdown, .cb-blog-style-a:hover h2 a, .cb-blog-style-a:hover .cb-read-more,  .cb-blog-style-b:hover .cb-read-more, .cb-blog-style-b:hover h2 a, .cb-blog-style-c:hover .cb-read-more, .cb-article-big h3 a:hover, .cb-article-small h3 a:hover, .cb-article-big h2 a:hover, .cb-article-small h2 a:hover, .commentlist a, .cb-author-page .cb-meta h3 a:hover, .cb-byline .author a, #commentform a, .cb-breaking-news span, .cb_page_navi li a, .widget_calendar td a, #cb-sidebar .cb-top-reviews-widget li:hover a, #cb-sidebar .cb-top-reviews-widget li:focus a, #cb-sidebar .latest-article-widget li:hover a, #cb-sidebar .latest-article-widget li:focus a,  .cb-top-reviews-page .cb-top-reviews:hover .cb-read-more, ul.tabbernav li:hover a, #cb-sidebar .cb-tabs-widget .tabberlive .latest-entry:hover h4 a, #cb-sidebar .cb-tabs-widget .tabberlive .cb-tabs .top-reviews:hover .cb-countdown, #cb-sidebar .cb-tabs-widget .tabberlive .cb-tabs .top-reviews:hover h4 a, .cb-authors li h3 a:hover, .cb-module-d h2 a:hover, .cb-about-page li .cb-website-link:hover, .cb-about-page li .cb-twitter-link:hover, .cb-about-page li .cb-email-link:hover, .cb-footer .cb-top-reviews-widget li:hover .cb-countdown, .cb-search-term,  #cb-sidebar .cb-tabs-widget .tabberlive .cb-tabs .top-reviews:hover h4 {color:  <?php echo $cb_color;?>;}
    
    .cb-score-box, .cb-score-box-star, .tagcloud a:hover, .cb-tabs .tagcloud a:hover, .cb-crit-bar, .cb-blog-style-d .cb-meta, .tags a:hover, .cb-category, .respond-form .button, .comment-reply-link, .comment-reply-link:visited, .cb-review-box-top .bg, .cb-review-box-bottom .bg,  .flexslider .flex-next:hover, .flexslider .flex-prev:hover, .flexslider-g .flex-next:hover, .flexslider-g .flex-prev:hover, .flexslider-full:hover .flex-next:hover, .flexslider-full:hover .flex-prev:hover, .cb_page_navi li.cpn-current, .flexslider-e .flex-next:hover, .flexslider-e .flex-prev:hover, .tabberactive a, #cb-sidebar .cb-tabs-widget .tabberlive .tagcloud a:hover, .cb-user-rating-tip, .tabs li a.current, .wpcf7-submit, .user-bg, .article-header.small-featured .cb-cat a:hover,.article-header.small-featured .author a:hover, #respond  #submit, .cb-wp-link-pages p a .wp-link-pages-number:hover, .cb-wp-link-pages p .wp-link-pages-number, .cb-to-top {background-color: <?php echo $cb_color;?>;}
    
    .cb-review-box-top .stars-bg, .cb-review-box-bottom .stars-bg  {background:<?php echo $cb_color;?> url(<?php echo get_template_directory_uri(); ?>/library/images/review-star-sprite.png) no-repeat;}
    
    .flickr a img:hover {border-color:<?php echo $cb_color;?>;}
    
    @media only screen and (max-width:767px) {
    	
    		.cb-top-reviews-page .cb-top-reviews .cb-meta .cb-read-more, .cb-blog-style-a .cb-read-more,  .cb-blog-style-b .cb-read-more, .cb-blog-style-c .cb-read-more {color:  <?php echo $cb_color;?>;}
    		#cb-main-menu-mob .menu-item {background-color:#f2f2f2!important;}
    }
    
    .main-nav .current-post-ancestor, .main-nav .current-menu-item, .main-nav .current-post-parent, .main-nav .current-menu-parent, .main-nav .current_page_item, .main-nav .current-page-ancestor, .main-nav .current-category-ancestor  {background-color: <?php echo $cb_color;?>;}
    
    </style>
    
    <?php 
    } 
}
add_action('wp_head', 'cb_user_colors');

/*********************
COMMENTS
*********************/	
if ( ! function_exists( 'cb_comments' ) ) {	
    function cb_comments($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
       
    	<li <?php comment_class(); ?>>
        
    		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
                    <div class="cb-gravatar-image">
                        <?php echo get_avatar( $comment, 80 ); ?>
              		</div> 
                      
               <div class="cb-comment-body clearfix">
                 <header class="comment-author vcard">
    				<?php echo "<cite class='fn'>".get_comment_author_link()."</cite>"; ?>
    				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time("F jS, Y"); ?> </a></time>
    				<?php edit_comment_link(__('(Edit)', 'cubell'),'  ','') ?>
    			</header>
    			<?php if ($comment->comment_approved == '0') : ?>
           			<div class="alert info">
              			<p><?php _e('Your comment is awaiting moderation.', 'cubell') ?></p>
              		</div>
    			<?php endif; ?>
    			<section class="comment_content clearfix">
    				<?php comment_text() ?>
    			</section>
    			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
              </div>
    		</article>
        <!-- </li> is added by WordPress automatically -->
    <?php
    } 
}

/*********************
RELATED POSTS FUNCTION
*********************/
if ( ! function_exists( 'cb_related_posts' ) ) { 
    function cb_related_posts() {
    	
    	global $post;
    	$i = 1;
        
    	$cb_meta_onoff_related = ot_get_option('cb_meta_onoff_related', 'on'); 
        if ($cb_meta_onoff_related != 'on') { $cb_no_byline = 'cb-no-byline ';} else {$cb_no_byline = NULL;}
    	$cb_custom_fields = get_post_custom();
    	if (isset($cb_custom_fields['cb_full_width_post'][0])) {$cb_full_width_post = $cb_custom_fields['cb_full_width_post'][0];} else {$cb_full_width_post = NULL;}
    	if ($cb_full_width_post == 1) { $cb_number_related = 3; } else { $cb_number_related = 4;}
    
    		$tags = wp_get_post_tags($post->ID);
    		$tag_check = '';
    		if ($tags) {
    
    			foreach($tags as $tag) { $tag_check .= $tag->slug . ','; }
    			
    			$args = array( 'numberposts' => $cb_number_related, 'tag' => $tag_check, 'exclude' => ($post->ID), 'post_status' => 'publish', 'suppress_filter' => false );
    			
    			$related_posts = get_posts( $args );
    				
    				if($related_posts) {
    				  echo '<div class="cb-related-posts '.$cb_no_byline.'clearfix"><h3 class="cb-module-title">'.__('Related Posts', 'cubell').'</h3><ul>';
    					
    					foreach ($related_posts as $post) {
    						
    					 setup_postdata($post);  
    					
    					$cat_com_url = get_comments_link();
    ?> 
    						<li class="no-<?php echo $i;?>">
                            
    						<?php 
    								$feature_size = "cb-thumb-350-crop" ;
    							
    				   				if  (has_post_thumbnail())  {
                          			   $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $feature_size ); 
                              			  echo '<img src="'.$thumbnail[0].'" >';
                          			} else { 
    									 $thumbnail = get_template_directory_uri().'/library/images/thumbnail-350x200.png'; ?>
    									<img src="<?php echo $thumbnail; ?>" >
                           		 <?php } ?> 
                                
    							 <?php if (get_comments_number() > 0) { ?>
                                    <a href="<?php echo $cat_com_url; ?>"><span class="cb-comments"><?php echo get_comments_number(); ?></span></a>
                                 <?php } ?>   
                               
                                <h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
                                
                                 <?php  if ($cb_meta_onoff_related != 'off') { ?>
                                     <div class="cb-byline"><?php echo __('By', 'cubell'); echo ' '.get_the_author()?></div>
                                 <?php } ?>

                                
                                <div class="cb-excerpt"><?php echo cb_clean_excerpt('45', false);?></div>  
                                
                                <span class="cb-shadow"></span>
                                <a href="<?php the_permalink(); ?>" class="grid-overlay"></a>
    						</li>
    					<?php 
    						  $i++;
    						 
    					}  // endforeach
    				
    				  echo '</ul></div>';
    			wp_reset_postdata();	
    			}  // endif
    
    		} else {
    			
    			 $current_post = $post->ID;
    			 $categories = get_the_category();
    
    			 foreach ($categories as $category) { $tag_check .= $category->term_id  . ','; }
    			
    				$args = array( 'numberposts' => $cb_number_related, 'category' => $tag_check, 'exclude' => ($post->ID), 'post_status' => 'publish', 'suppress_filter' => false  );
    				
    				$posts = get_posts( $args );	
    			 				 
    				
    				if ($posts) { 
    					
    				 echo '<div class="cb-related-posts '.$cb_no_byline.'clearfix"><h3 class="cb-module-title">'.__('Related Posts', 'cubell').'</h3><ul>';				
    
    					foreach($posts as $post) { 
    					setup_postdata($post);  
    					$cat_com_url = get_comments_link();					
    				?> 
    						<li class="no-<?php echo $i;?>">
    
    							<?php 
    								$feature_size = "cb-thumb-350-crop" ;
    
    				   				if  (has_post_thumbnail())  {
                          			   $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $feature_size ); 
                              			  echo '<img src="'.$thumbnail[0].'" >';
                          			} else { 
    									 $thumbnail = get_template_directory_uri().'/library/images/thumbnail-350x200.png'; 
    							?>
    									<img src="<?php echo $thumbnail; ?>" >
    									
                           		 <?php } ?> 
                                 
    							 <?php if (get_comments_number() > 0) { ?>
                                    <a href="<?php echo $cat_com_url; ?>"><span class="cb-comments"><?php echo get_comments_number(); ?></span></a>
                                 <?php } ?>   
                               
                                <h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
                                
                                <?php  if ($cb_meta_onoff_related != 'off') { ?>
                                     <div class="cb-byline"><?php echo __('By', 'cubell'); echo ' '.get_the_author()?></div>
                                 <?php } ?>     
                                                                                      
                                <div class="cb-excerpt"><?php echo cb_clean_excerpt('45', false);?></div>  
                               
                                <span class="cb-shadow"></span>
                                <a href="<?php the_permalink(); ?>" class="grid-overlay"></a>
    						</li>
    						 
    					<?php 
    						  $i++;
    
    					 }// endforeach 
    					 
    				  echo '</ul></div>';
    				  
    				} //endif 	 
    					
    			wp_reset_postdata();
    
    		}//end if($tags)	
    		
    } /* end related posts function */
}
/*********************
NUMERIC PAGE NAVI
*********************/
if ( ! function_exists( 'cb_page_navi' ) ) { 
    function cb_page_navi($before = '', $after = '') {
    	
    	global $wpdb, $wp_query;
    	$request = $wp_query->request;
    	$posts_per_page = intval(get_query_var('posts_per_page'));
    	$paged = intval(get_query_var('paged'));
    	$numposts = $wp_query->found_posts;
    	$max_page = $wp_query->max_num_pages;
    	
    	if ( $numposts <= $posts_per_page ) { return; }
    	if(empty($paged) || $paged == 0) {
    		$paged = 1;
    	}
    	$pages_to_show = 7;
    	$pages_to_show_minus_1 = $pages_to_show-1;
    	$half_page_start = floor($pages_to_show_minus_1/2);
    	$half_page_end = ceil($pages_to_show_minus_1/2);
    	$start_page = $paged - $half_page_start;
    	
    	if($start_page <= 0) {
    		$start_page = 1;
    	}
    	
    	$end_page = $paged + $half_page_end;
    	if(($end_page - $start_page) != $pages_to_show_minus_1) {
    		$end_page = $start_page + $pages_to_show_minus_1;
    	}
    	if($end_page > $max_page) {
    		$start_page = $max_page - $pages_to_show_minus_1;
    		$end_page = $max_page;
    	}
    	if($start_page <= 0) {
    		$start_page = 1;
    	}
    	echo $before.'<nav class="page-navigation"><ol class="cb_page_navi clearfix">'."";
    	if ($start_page >= 2 && $pages_to_show < $max_page) {
    		$first_page_text = __( "First", 'cubell' );
    		echo '<li class="cpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
    	}
    	
    	echo '<li class="cpn-prev-link">';
    	previous_posts_link('&larr;');
    	echo '</li>';
    	for($i = $start_page; $i  <= $end_page; $i++) {
    		if($i == $paged) {
    			echo '<li class="cpn-current">'.$i.'</li>';
    		} else {
    			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
    		}
    	}
    	echo '<li class="cpn-next-link">';
    	next_posts_link('&rarr;');
    	echo '</li>';
    	if ($end_page < $max_page) {
    		$last_page_text = __( "Last", 'cubell' );
    		echo '<li class="cpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
    	}
    	echo '</ol></nav>'.$after."";
    } /* end page navi */
}

/*********************
RANDOM CLEANUP ITEMS
*********************/
if ( ! function_exists( 'cb_filter_ptags_on_images' ) ) { 
    function cb_filter_ptags_on_images($content){
       return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    }
}
//  This is a modified the_author_posts_link() to return the link and be able to use it in printf
if ( ! function_exists( 'cb_get_the_author_posts_link' ) ) { 
    function cb_get_the_author_posts_link() {
    	global $authordata;
    	if ( !is_object( $authordata ) )
    		return false;
    	$link = sprintf(
    		'<a href="%1$s" title="%2$s" rel="author"><span class="fn">%3$s</span></a>',
    		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
    		esc_attr( sprintf( 'By %s' , get_the_author() ) ), // No further l10n needed, core will take care of this one
    		get_the_author()
    	);
    	return $link;
    }
}

// Clean excerpt with/without read more
if ( ! function_exists( 'cb_clean_excerpt' ) ) { 
    function cb_clean_excerpt ($data, $readmore = NULL) {
    	$clean_excerpt = get_the_content();
    	$clean_excerpt = preg_replace(" (\[.*?\])",'',$clean_excerpt);
    	$clean_excerpt = strip_shortcodes($clean_excerpt);
    	$clean_excerpt = strip_tags($clean_excerpt);
    	$data = intval($data);
    	$clean_excerpt = substr($clean_excerpt, 0, $data);
    	$clean_excerpt = substr($clean_excerpt, 0, strripos($clean_excerpt, " "));
    	$clean_excerpt = trim(preg_replace( '/\s+/', ' ', $clean_excerpt));
    	
    	if ($readmore !== false) {
    		$clean_excerpt = $clean_excerpt.'... <a href="'. get_permalink() .'"><span class="cb-read-more"> '.__( "Read more  &rarr;", "cubell").'</span></a>';
    	} else {
    		$clean_excerpt = $clean_excerpt.'...';
    	}
    	return $clean_excerpt;
    }
}
// Only show posts during searches
if ( ! function_exists( 'cb_clean_search' ) ) { 
    function cb_clean_search($cb_query) {
        
        if (!is_admin()) {
         if ($cb_query->is_search == true) {
              $cb_query->set('post_type', 'post');
         }
        }
    	 
         return $cb_query;
    }
}
add_filter('pre_get_posts','cb_clean_search');

/*********************
FEATURED IMAGE THUMBNAILS
*********************/
if ( ! function_exists( 'cb_thumbnail' ) ) {   
    function cb_thumbnail($width, $height) {
    
      echo '<a href="'.get_permalink() .'">';
            
            if  (has_post_thumbnail()) {
                          $cb_featured_image = the_post_thumbnail('cb-'.$width.'-'.$height); 
                              echo $cb_featured_image[0];
                  } else { 
                           $cb_thumbnail = get_template_directory_uri().'/library/images/thumbnail-'.$width.'x'.$height.'.png'; 
                           echo '<img src="'. $cb_thumbnail .'" alt="article placeholder">'; 
                  } 
      echo '</a>';
    }
}

/*********************
FEATURED IMAGES
*********************/
// Full background featured image
if ( ! function_exists( 'cb_featured_full_bg' ) ) { 
    function cb_featured_full_bg($post) {
    
    	$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
    	$cat_com_url = get_comments_link();
    	$cb_custom_fields = get_post_custom();
    	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
    	
    	$cb_single_bg_image = get_post_meta($post->ID,'cb_bg_image_post');
    
        if ( has_post_thumbnail() ) {
                        $cb_featured_image_id = get_post_thumbnail_id( $post->ID ); 
                        $cb_featured_image_url = wp_get_attachment_image_src( $cb_featured_image_id, 'cb-thumb' ); 
        } else {
                           $cb_featured_image_url = array();
                           $cb_featured_image_url[] = get_template_directory_uri().'/library/images/thumbnail-1020x500.png'; 
        }
    	
    	$category_data = NULL;
    	$j = 1;
    	
    	foreach( ( get_the_category() ) as $category ) 	{
    			$category_name = $category->cat_name;
    			$category_url = get_category_link($category);
    			if ((count(get_the_category()) > 1) && ($j != 1)) { $category_data .= ',';}
    			$category_data .= ' <a href="'.$category_url.'">'.$category_name.'</a>';
    			$j++;
    			
    		}
    	$cat_com_url = get_comments_link();
     ?>                
       <header class="article-header full-bg cover-image clearfix">
          <div class="wrap"> 
              <h1 class="cb-entry-title cb-single-title<?php if ($cb_review_checkbox == 'on') { echo ' entry-title';}?>" <?php if ($cb_review_checkbox == 'on') { echo 'itemprop="itemReviewed"';} else {echo 'itemprop="headline"';}?>><?php the_title(); ?></h1>  						
              <?php cb_byline(); ?>    
         </div> 
    	<style type="text/css">
    			 #cb-content {margin:350px auto 0 auto;}  .backstretch span {display:none!important;} .cb-header {background:white;} #cb-inner-header, #cb-top-menu, .cb-main-menu {border-right: none; border-left:none;}
    			@media only screen and (min-width: 768px) { #cb-content {margin-top:600px;} } 
    </style> 	
           <script type="text/javascript">	
           	jQuery(document).ready(function($){			  
    				  <?php 
    				  if (is_array($cb_single_bg_image) && count($cb_single_bg_image) > 1){ echo '$.backstretch([';
    						  foreach ($cb_single_bg_image as $cb_bg_slide) {
    							  $single_bg_url = wp_get_attachment_image_src( $cb_bg_slide, 'cb-thumb-1400' ); 
    							  echo '"'.$single_bg_url[0].'", ';
    						  }
    						  echo '],  {fade: 750, duration: 6000});	';
    				 } elseif (count($cb_single_bg_image) == 1) { 
    						
    						$single_bg_url = wp_get_attachment_image_src( $cb_single_bg_image[0], 'cb-thumb-1400' ); 

    				 		echo '$.backstretch("'.$single_bg_url[0].'")';

    						
    				 } else {
    				 
    				 
    					 ?> $.backstretch("<?php echo $cb_featured_image_url[0]; ?>", {speed: 250});
    					 
    			 <?php } ?>  
    	 	});                
           </script>
        </header> <!-- /article header -->
    <?php
    }
}
// Cover Featured Image
if ( ! function_exists( 'cb_featured_cover_image' ) ) { 
    function cb_featured_cover_image($post) {
    	
    	$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on'); 	
    	$cat_com_url = get_comments_link();
    	$cb_custom_fields = get_post_custom();
    	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
    
        if ( has_post_thumbnail() ) {
                        $cb_featured_image_id = get_post_thumbnail_id( $post->ID ); 
                        $cb_featured_image_url = wp_get_attachment_image_src( $cb_featured_image_id, 'cb-thumb-1400' ); 
                } else {
                           $cb_featured_image_url = array();
                           $cb_featured_image_url[] = get_template_directory_uri().'/library/images/thumbnail-1020x500.png'; 
        }
    	$category_data = NULL;
    	$j = 1;
    	
    	foreach( ( get_the_category() ) as $category ) 	{
    			$category_name = $category->cat_name;
    			$category_url = get_category_link($category);
    			if ((count(get_the_category()) > 1) && ($j != 1)) { $category_data .= ',';}
    			$category_data .= ' <a href="'.$category_url.'">'.$category_name.'</a>';
    			$j++;
    			
    		}
    	$cat_com_url = get_comments_link();
         
         ?>
        <header class="article-header cover-image clearfix">
            <div class="wrap">
    			<h1 class="cb-entry-title cb-single-title<?php if ($cb_review_checkbox == 'on') { echo ' entry-title';}?>" <?php if ($cb_review_checkbox == 'on') { echo 'itemprop="itemReviewed"';} else {echo 'itemprop="headline"';}?>><?php the_title(); ?></h1>  						
                <?php cb_byline(); ?>
                 
            </div> 
            <div class="cb-cover"></div>
            <style type="text/css">.backstretch span {display:none;}</style> 
    		<script type="text/javascript">
    			jQuery(document).ready(function($){	
              		$('.cb-cover').backstretch("<?php echo $cb_featured_image_url[0]; ?>", {speed: 150});
              	});  
            </script>
        </header> <!-- /article header -->
    <?php
    }
}
// Full Width featured image
if ( ! function_exists( 'cb_featured_full_width' ) ) {
    function cb_featured_full_width ($post) {
    	
    	$category_data = NULL;
    	$j = 1;
    	
    	foreach( ( get_the_category() ) as $category ) 	{
    			$category_name = $category->cat_name;
    			$category_url = get_category_link($category);
    			if ((count(get_the_category()) > 1) && ($j != 1)) { $category_data .= ',';}
    			$category_data .= ' <a href="'.$category_url.'">'.$category_name.'</a>';
    			$j++;
    			
    		}
    	$cat_com_url = get_comments_link();
    	$cb_custom_fields = get_post_custom();
    	$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on'); 
    	
    	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
    		
                if ( has_post_thumbnail() ) {
                        $cb_featured_image_id = get_post_thumbnail_id( $post->ID ); 
                        $cb_featured_image_url = wp_get_attachment_image_src( $cb_featured_image_id, 'cb-thumb-1020-crop' ); 
                } else {
                           $cb_featured_image_url = array();
                           $cb_featured_image_url[] = get_template_directory_uri().'/library/images/thumbnail-1020x500.png'; 
                }          
?>
    			 <header class="article-header full-width clearfix">
    				  <h1 class="cb-entry-title h2 cb-single-title<?php if ($cb_review_checkbox == 'on') { echo ' entry-title';}?>" <?php if ($cb_review_checkbox == 'on') { echo 'itemprop="itemReviewed"';} else {echo 'itemprop="headline"';}?>><?php the_title(); ?></h1>  	
                      					
    				  <?php cb_byline() ;?>
    				   
                      <div class="cb-cover"></div>
                      <script type="text/javascript">
                     	 jQuery(document).ready(function($){	
                      		$('.cb-cover').backstretch("<?php echo $cb_featured_image_url[0]; ?>", {speed: 150});
                      	});
                      </script>
    			 </header> <!-- /article header -->	
    <?php
    }
}

// Normal (small) featured image
if ( ! function_exists( 'cb_featured_normal' ) ) { 
    function cb_featured_normal($post) {
    	
    	$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on'); 
    	$category_data = NULL;
    	
    	foreach( ( get_the_category() ) as $category ) 	{
    			$category_name = $category->cat_name;
    			$category_url = get_category_link($category);
    			$category_data .= '<span class="cb-cat"><a href="'.$category_url.'">'.$category_name.'</a></span>';
    		}
    		if (is_attachment()) {
    				$category_name = '';
    				$category_url = '';
    				$cat_com_url ='';
    		}
    	$cb_custom_fields = get_post_custom();
    	$cat_com_url = get_comments_link();
    	
    	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
    ?>
               <header class="article-header small-featured">
                   <h1 class="cb-entry-title cb-single-title<?php if ($cb_review_checkbox == 'on') { echo ' entry-title';}?>" <?php if ($cb_review_checkbox == 'on') { echo 'itemprop="itemReviewed"';} else {echo 'itemprop="headline"';}?>><?php the_title(); ?></h1>  						
                   <?php cb_byline(); ?>
    			   
    			   
              </header> <!-- /article header -->
    <?php	
    }
}
/*********************
SOCIAL MEDIA IN FOOTER
*********************/
if ( ! function_exists( 'cb_social_media_footer' ) ) { 
    function cb_social_media_footer() {
    	
    	$cb_facebook_url = ot_get_option('cb_facebook_url', false);
    	$cb_twitter_url  = ot_get_option('cb_twitter_url', false);
    	$cb_youtube_url  = ot_get_option('cb_youtube_url', false);
    	$cb_pinterest_url = ot_get_option('cb_pinterest_url', false);
    	$cb_rss_url = ot_get_option('cb_rss_url', false);
    	
    	$top_social_output =  '<div class="cb-social-media clearfix">';
    	
    	if ($cb_facebook_url != NULL) { $top_social_output .= '<a href="'.$cb_facebook_url.'" class="cb-facebook" target="_blank"></a>'; };
    	if ($cb_youtube_url != NULL) { $top_social_output .= '<a href="'.$cb_youtube_url.'" class="cb-youtube" target="_blank"></a>'; };
    	if ($cb_twitter_url != NULL) { $top_social_output .= '<a href="'.$cb_twitter_url.'" class="cb-twitter" target="_blank"></a>'; };
    	if ($cb_pinterest_url != NULL) { $top_social_output .= '<a href="'.$cb_pinterest_url.'" class="cb-pinterest" target="_blank"></a>'; };
    	if ($cb_rss_url != NULL) { $top_social_output .= '<a href="'.$cb_rss_url.'" class="cb-rss" target="_blank"></a>'; };
    	
    	$top_social_output .= '</div>';
    	
    	if (($cb_facebook_url != NULL) || ($cb_youtube_url != NULL) || ($cb_twitter_url != NULL) || ($cb_pinterest_url != NULL) ||  ($cb_rss_url != NULL)) echo $top_social_output;
    
    }
}
/*********************
ADD META TO USER PROFILES
*********************/
if ( ! function_exists( 'cb_extra_profile_about_us' ) ) { 
    function cb_extra_profile_about_us( $user ) { 
    	
    	$saved_value = get_the_author_meta( 'cb_order', $user->ID );
    	$currentuser = get_current_user_id();
    	$user_info = get_userdata($currentuser);
    
    	if (($user_info->user_level) > 8) {
    ?>
    <h3 class="cb-about-options-title">About Us Page Options</h3>
    <table class="form-table cb-about-options">	
        <tr>
            <th><label>Show On About Us Page Template</label></th>
            <td>
                <input type="checkbox" name="cb_show_author" id="cb_show_author" value="true" <?php if (esc_attr( get_the_author_meta( "cb_show_author", $user->ID )) == "true") echo "checked"; ?> />
            </td>
        </tr>
         <tr>
            <th><label for="dropdown">About Us Page Order Override</label></th>
            <td>
                <select name="cb_order" id="cb_order">
                	<option value="0" <?php if ($saved_value == "0") { echo  'selected="selected"'; } ?>>Off</option>
                    <option value="1" <?php if ($saved_value == "1") { echo  'selected="selected"'; } ?>>1</option>
                    <option value="2" <?php if ($saved_value == "2") { echo  'selected="selected"'; } ?>>2</option>
                    <option value="3" <?php if ($saved_value == "3") { echo  'selected="selected"'; } ?>>3</option>
        
                </select>
            </td
    </table>
    <?php } 
    }
}

add_action( 'show_user_profile', 'cb_extra_profile_about_us' );
add_action( 'edit_user_profile', 'cb_extra_profile_about_us' );

if ( ! function_exists( 'cb_extra_profile_about_us_save' ) ) { 
    function cb_extra_profile_about_us_save( $user_id ) {
    	$currentuser = get_current_user_id();
    	$user_info = get_userdata($currentuser);
    
    	if (($user_info->user_level) > 8) {
    
    	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
    	
    	update_user_meta( $user_id, 'cb_show_author', $_POST['cb_show_author'] );
    	update_user_meta( $user_id, 'cb_order', $_POST['cb_order'] );
    	
    	}
    }
}

add_action( 'personal_options_update', 'cb_extra_profile_about_us_save' );
add_action( 'edit_user_profile_update', 'cb_extra_profile_about_us_save' );

if ( ! function_exists( 'extra_contact_info' ) ) { 
    function extra_contact_info($contactmethods) {
    
    	unset($contactmethods['aim']);
    	unset($contactmethods['yim']);
    	unset($contactmethods['jabber']);
    	
    	$contactmethods['position'] = 'Job Title';
    	$contactmethods['publicemail'] = 'Public Email';
        $contactmethods['twitter'] = 'Twitter Username';
        $contactmethods['googleplus'] = 'Google Plus URL';
    	 
    	return $contactmethods;
    }
}
add_filter('user_contactmethods', 'extra_contact_info');

/*********************
AUTHOR FUNCTIONS
*********************/

//  Array with published authors
if ( ! function_exists( 'filtered_authors' ) ) { 
    function filtered_authors() {
    	
        $all_authors = get_users('orderby=post_count');
    	
        $filtered_authors = array();
    	$filtered_authors_over_1 = array();
    	$filtered_authors_over_2 = array();
    	$filtered_authors_over_3 = array();
    	
        foreach($all_authors as $author)  {
        	$author_checked = get_the_author_meta('cb_show_author', $author->ID);
        	$author_order = get_the_author_meta('cb_order', $author->ID);
    
            if(($author_checked == 'true') && ($author_order == '0')) {
                array_push($filtered_authors, $author);
            }
    		if(($author_checked == 'true') && ($author_order == '1')) {
                array_push($filtered_authors_over_1, $author);
            }
    		if(($author_checked == 'true') && ($author_order == '2')) {
                array_push($filtered_authors_over_2, $author);
            }
    		if(($author_checked == 'true') && ($author_order == '3')) {
                array_push($filtered_authors_over_3, $author);
            }
    	}
    	
    	$final_filtered_authors = array_merge($filtered_authors_over_1, $filtered_authors_over_2, $filtered_authors_over_3, $filtered_authors);
    	return $final_filtered_authors;
    }
}

//  Show filtered authors
if ( ! function_exists( 'cb_contributors' ) ) {
    function cb_contributors() {
     
     $authors = filtered_authors();
     
    	if (count($authors) > 0) { 
    		echo "<ul class=cb-authors>";
    			
    		foreach ($authors as $author) {  
    		
    		$author_name = get_the_author_meta('display_name', $author->ID);
    		$author_nice_name = get_the_author_meta('user_nicename', $author->ID);
    		$author_position = get_the_author_meta('position', $author->ID);
    		$author_pic = get_avatar($author->ID, $size = '140'); 
    		$author_email = get_the_author_meta('publicemail', $author->ID);
    		$author_website = get_the_author_meta('user_url', $author->ID);
            $author_tw = get_the_author_meta('twitter', $author->ID);
            $author_gp = get_the_author_meta('googleplus', $author->ID);
    		$author_desc = get_the_author_meta('description', $author->ID);
    		
    		echo "<li class='clearfix'>";
    ?> 					
    			<div class="cb-mask"><a href="<?php echo get_author_posts_url($author->ID); ?>"><?php echo $author_pic; ?></a></div>
    			
    			   <div class="cb-meta">
    			   
    						  <h3><a href="<?php echo get_author_posts_url($author->ID); ?>"><?php echo $author_name; ?></a></h3>  
    											  			  
    						  <?php if ($author_position) { ?>  
    							  <div class="cb-position h5"><?php echo $author_position; ?></div>
    						  <?php } ?>
    							              
                             <?php if ($author_tw) { ?>
                                <span class="cb-twitter"></span>
                                <a href="http://www.twitter.com/<?php echo $author_tw; ?>" target="_blank" class="cb-twitter-link">Twitter</a> 
                             <?php } ?> 
                             
                             <?php if ($author_gp) { ?>
                                <div class="cb-googleplus">
                                <a href="<?php echo $author_gp;?>" rel="publisher"  target="_blank" style="text-decoration:none;">
                                    <img src="//ssl.gstatic.com/images/icons/gplus-16.png" alt="Google+" style="border:0;width:16px;height:16px;"/>
                                </a>
                                 <a href="<?php echo $author_gp;?>" rel="publisher"  target="_blank" style="text-decoration:none;" class="cb-googleplus-link">Google+</a>
                                </div>
                             <?php } ?> 
    				                 
    						 <?php if ($author_email) { ?>
    						   <span class="cb-email"></span>
    							<a href="mailto:<?php echo $author_email; ?>" class="cb-email-link"><?php echo __( 'Email', 'cubell' ); ?></a> 
    						 <?php } ?>	
    								 
    						<?php if ($author_website) { ?>
    							<span class="cb-website"></span>
    							<a href="<?php echo $author_website; ?>" target="_blank" class="cb-website-link"><?php echo __( 'Website', 'cubell' ); ?></a> 
    						<?php } ?>	
    						
    						 <?php if ($author_desc) { ?>
    								<p class="cb-author-bio"><?php echo $author_desc; ?></p>
    						 <?php } ?>      
    			 </div>                                   
    							
    			<?php } ?>
                
    			</li>
    		</ul>
            
    	<?php } 
    }
}

// About The Author Box
if ( ! function_exists( 'cb_about_author' ) ) {
    function cb_about_author($post) {
    	
    	$author = $post->post_author;
    	
    	$author_nice_name = get_the_author_meta('user_nicename', $author);
    	$author_email = get_the_author_meta('publicemail', $author);
    	$author_website = get_the_author_meta('user_url', $author);
    	$author_tw = get_the_author_meta('twitter', $author);
        $author_gp = get_the_author_meta('googleplus', $author);
    	$author_desc = get_the_author_meta('description', $author);
    ?>
    			
                <h3 class="cb-module-title"><?php echo __('About the author', 'cubell'); ?></h3>
                <div class="cb-author-page clearfix">
    		
                  <div class="cb-mask"><?php echo get_avatar($author, $size = '100');  ?></div>
               
            	  <div class="cb-meta">
              	
    		          	 <h3 class="h5"><a href="<?php echo get_author_posts_url($author); ?>"><?php echo get_the_author_meta('display_name', $author); ?></a></h3>
    		            
    		             <?php if ($author_tw) { ?>
    		             <span class="cb-twitter"></span>
    		                <a href="http://www.twitter.com/<?php echo $author_tw; ?>" target="_blank" class="cb-twitter-link">Twitter</a> 
    		             <?php } ?>	
    		             
    		             <?php if ($author_gp) { ?>
                                <div class="cb-googleplus">
                                <a href="<?php echo $author_gp;?>" rel="publisher" target="_blank" style="text-decoration:none;">
                                    <img src="//ssl.gstatic.com/images/icons/gplus-16.png" alt="Google+" style="border:0;width:16px;height:16px;"/>
                                </a>
                                 <a href="<?php echo $author_gp;?>" rel="publisher" target="_blank" style="text-decoration:none;" class="cb-googleplus-link">Google+</a>
                                </div>
                        <?php } ?> 
                        
    		             <?php if ($author_email) { ?>
                         <span class="cb-email"></span>
                            <a href="mailto:<?php echo $author_email; ?>" class="cb-email-link"><?php echo __( 'Email', 'cubell' ); ?></a> 
                         <?php } ?> 
                         
                         <?php if ($author_website) { ?>
                         <span class="cb-website"></span>
                            <a href="<?php echo $author_website; ?>" target="_blank" class="cb-website-link"><?php echo __( 'Website', 'cubell' ); ?></a> 
                         <?php } ?> 
                         
    		             <?php if ($author_desc) { ?>
    		                    <p class="cb-author-bio clearfix"><?php echo $author_desc; ?></p> 
    		             <?php } ?>  
                 </div>                                       
    			
           </div>
    <?php
    }
}

// Author Page
if ( ! function_exists( 'cb_author_page' ) ) {
    function cb_author_page() {
    		
    		$author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
    		
    		$author_name = get_the_author_meta('display_name', $author->ID);
    		$author_nice_name = get_the_author_meta('user_nicename', $author->ID);
    		$author_position = get_the_author_meta('position', $author->ID);
    		$author_pic = get_avatar($author->ID, $size = '100'); 
    		$author_email = get_the_author_meta('publicemail', $author->ID);
    		$author_website = get_the_author_meta('user_url', $author->ID);
    		$author_tw = get_the_author_meta('twitter', $author->ID);
            $author_gp = get_the_author_meta('googleplus', $author->ID);
    		$author_desc = get_the_author_meta('description', $author->ID);
    		
    ?> 					
    		<div class="cb-author-page clearfix">
    		
                  <div class="cb-mask"><?php echo $author_pic; ?></div>
               
            	  <div class="cb-meta">
              	
    		          	 <h3><?php echo $author_name; ?></h3>
    		          
    			          <?php if ($author_position) { ?>  
    			              <div class="cb-position h5"><?php echo $author_position; ?></div>
    			          <?php } ?>
    			                
    		   		            
    		             <?php if ($author_tw) { ?>
    		             <span class="cb-twitter"></span>
    		                <a href="http://www.twitter.com/<?php echo $author_tw; ?>" target="_blank" class="cb-twitter-link">Twitter</a> 
    		             <?php } ?>	
    		             
    		             <?php if ($author_gp) { ?>
                                <div class="cb-googleplus">
                                <a href="<?php echo $author_gp;?>" rel="publisher" target="_blank" style="text-decoration:none;">
                                    <img src="//ssl.gstatic.com/images/icons/gplus-16.png" alt="Google+" style="border:0;width:16px;height:16px;"/>
                                </a>
                                 <a href="<?php echo $author_gp;?>" rel="publisher" target="_blank" style="text-decoration:none;" class="cb-googleplus-link">Google+</a>
                                </div>
                        <?php } ?> 
                        
                         <?php if ($author_email) { ?>
                         <span class="cb-email"></span>
                            <a href="mailto:<?php echo $author_email; ?>" class="cb-email-link"><?php echo __( 'Email', 'cubell' ); ?></a> 
                         <?php } ?> 
                         
                         <?php if ($author_website) { ?>
                         <span class="cb-website"></span>
                            <a href="<?php echo $author_website; ?>" target="_blank" class="cb-website-link"><?php echo __( 'Website', 'cubell' ); ?></a> 
                         <?php } ?> 
    		            
    		             <?php if ($author_desc) { ?>
    		                    <p class="cb-author-bio clearfix"><?php echo $author_desc; ?></p> 
    		             <?php } ?>  
                 </div>                                       
    			
           </div>
    <?php
    }
}

/*********************
 REVIEW SCORE BOXES
*********************/

// Review Score Box - If Top enabled
if ( ! function_exists( 'cb_review_top' ) ) {
    function cb_review_top($post){
    
    	$cb_custom_fields = get_post_custom();
    		
    		// Pull all review meta data
            if ((isset($cb_custom_fields['cb_review_checkbox'][0])) && ($cb_custom_fields['cb_review_checkbox'][0] = '1')) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
    		if ($cb_review_checkbox == 'on') { 
    			if (isset($cb_custom_fields['cb_user_score'][0])) { $cb_user_score = 'on'; } else { $cb_user_score = 'off';}
    			if (isset($cb_custom_fields['cb_score_display_type'][0])) {$cb_score_display_type = $cb_custom_fields['cb_score_display_type'][0]; }
    			if (isset($cb_custom_fields['cb_rating_1_title'][0])) {$cb_rating_1_title = $cb_custom_fields['cb_rating_1_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_1_score'][0])) {$cb_rating_1_score = $cb_custom_fields['cb_rating_1_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_2_title'][0])) {$cb_rating_2_title = $cb_custom_fields['cb_rating_2_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_2_score'][0])) {$cb_rating_2_score = $cb_custom_fields['cb_rating_2_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_3_title'][0])) {$cb_rating_3_title = $cb_custom_fields['cb_rating_3_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_3_score'][0])) {$cb_rating_3_score = $cb_custom_fields['cb_rating_3_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_4_title'][0])) {$cb_rating_4_title = $cb_custom_fields['cb_rating_4_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_4_score'][0])) {$cb_rating_4_score = $cb_custom_fields['cb_rating_4_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_5_title'][0])) {$cb_rating_5_title = $cb_custom_fields['cb_rating_5_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_5_score'][0])) {$cb_rating_5_score = $cb_custom_fields['cb_rating_5_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_6_title'][0])) {$cb_rating_6_title = $cb_custom_fields['cb_rating_6_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_6_score'][0])) {$cb_rating_6_score = $cb_custom_fields['cb_rating_6_score'][0]; }
                if (isset($cb_custom_fields['cb_final_score'][0])) {$cb_final_score = $cb_custom_fields['cb_final_score'][0]; } else { $cb_final_score = NULL; }
                if (isset($cb_custom_fields['cb_final_score_override'][0])) {$cb_final_score_override = $cb_custom_fields['cb_final_score_override'][0]; } else { $cb_final_score_override = NULL; }
    			if (isset($cb_custom_fields['cb_rating_short_summary'][0])) {$cb_rating_short_summary = $cb_custom_fields['cb_rating_short_summary'][0]; }
    			if (isset($cb_custom_fields['cb_pros_title'][0])) { $cb_pros_title = $cb_custom_fields['cb_pros_title'][0]; }
    			if (isset($cb_custom_fields['cb_pros_one'][0])) { $cb_pros_one = $cb_custom_fields['cb_pros_one'][0]; }
    			if (isset($cb_custom_fields['cb_pros_two'][0])) { $cb_pros_two = $cb_custom_fields['cb_pros_two'][0]; }
    			if (isset($cb_custom_fields['cb_pros_three'][0])) { $cb_pros_three = $cb_custom_fields['cb_pros_three'][0]; }
    			if (isset($cb_custom_fields['cb_cons_title'][0])) { $cb_cons_title = $cb_custom_fields['cb_cons_title'][0]; }
    			if (isset($cb_custom_fields['cb_cons_one'][0])) { $cb_cons_one = $cb_custom_fields['cb_cons_one'][0]; }
    			if (isset($cb_custom_fields['cb_cons_two'][0])) { $cb_cons_two = $cb_custom_fields['cb_cons_two'][0]; }
    			if (isset($cb_custom_fields['cb_cons_three'][0])) { $cb_cons_three = $cb_custom_fields['cb_cons_three'][0]; }
    			if (isset($cb_custom_fields['cb_placement'][0])) { $cb_review_placement = $cb_custom_fields['cb_placement'][0]; }
    			
    			// Set final scores
                if ( $cb_final_score_override == NULL ) {
                    $cb_review_final_score = intval($cb_final_score); 
                } else {
                    $cb_review_final_score = intval($cb_final_score_override);
                }

    			$cb_review_final_score_stars = $cb_review_final_score / 20; 
    		} 
    	
    	if (($cb_review_checkbox == 'on') && ($cb_review_placement == 'Top')) { 	
    	 		
    			// Get user score data if enabled
    			if ($cb_user_score == 'on') { 
    							 
    						$number_votes = get_post_meta($post->ID, "votes", true);
    						$user_score = get_post_meta($post->ID, "user_score", true);	
    						$number_votes = !empty($number_votes) ? $number_votes : "0";
    						$user_score = !empty($user_score) ? $user_score : "0";
    						$hasvoted = NULL;
    						
    						if(isset($_COOKIE['user_rating'])){ $hasvoted = $_COOKIE['user_rating']; }
    						$hasvoted = explode(",", $hasvoted);
    						if(in_array($post->ID, $hasvoted)) {
    							$class = "disabled";
    						} else {
    							$class = "";
    						}
    			}
    	?>
    		<div class="cb-review-box-top sixcol first">
            	<div class="cb-scores clearfix">
    				<?php 
    					// Show Percetange Review Meta if enabled
    					if ($cb_score_display_type == 'Percentage') { 
    				?>
    					<div class="cb-score-box" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
    						<meta itemprop="worstRating" content="1">
    						<meta itemprop="bestRating" content="100">
    						<span class="score" itemprop="ratingValue"><?php echo $cb_review_final_score; ?><span class="h4">%</span></span>
                            <span class="score-title" itemprop="description"><?php if (isset($cb_rating_short_summary)) {echo $cb_rating_short_summary;}?></span>
                        </div>    
    					
    					<?php if ($cb_user_score == 'on') {  ?>
                                 <div class="cb-user-score">
                                 		<div id="cb-rating-title"><?php _e('User Score:', 'cubell'); ?> <span id="cb-average-score"><?php echo $user_score; ?>%</span> <span class="cb-total-votes">(<span class="cb-number-votes"><?php echo $number_votes; ?></span> votes)</span></div>
                                	 	<span id="cb-vote" class="bg percentage <?php echo $class; ?>"><span class="overlay" style="width:<?php echo (100 - $user_score); ?>%"></span></span>
                               	  </div>
               					  <?php if(function_exists('wp_nonce_field')) {wp_nonce_field('voting_nonce', 'voting_nonce');} ?>
              				<?php } ?>
    				<?php } ?>
                    
    				<?php 
    					// Show Star Review Meta if enabled
    					if ($cb_score_display_type == 'Stars')  { 
    				?>
    					<div class="cb-score-box-star" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
    					 	<meta itemprop="worstRating" content="1">
    						<meta itemprop="bestRating" content="5">
    						<span class="filling-bg"><span class="filling-star" style="width:<?php echo $cb_review_final_score; ?>%"></span></span>
    						<span class="score" itemprop="ratingValue"><?php echo  number_format($cb_review_final_score_stars, 1); ?></span>
                        </div>
                           
    					<?php if ($cb_user_score == 'on') {  ?>
                                <div class="cb-user-score">
                                    <div id="cb-rating-title"><?php _e('User Score:', 'cubell'); ?> <span class="cb-total-votes">(<span class="cb-number-votes"><?php echo $number_votes; ?></span> votes)</span></div>
                                   <span id="cb-vote" class="bg stars <?php echo $class; ?>"><span class="overlay" style="width:<?php echo (100 - $user_score); ?>%"></span></span>
                                </div>
                                <?php if(function_exists('wp_nonce_field')) {wp_nonce_field('voting_nonce', 'voting_nonce');} ?>
                        <?php } ?>
    				<?php } ?>
                    
    				<?php 
    					// Show Out of 10 Review Meta if enabled
    					if ($cb_score_display_type == 'Out of 10')  { 
    				?>
    					<div class="cb-score-box" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                            <meta itemprop="worstRating" content="1">
    						<meta itemprop="bestRating" content="10">
    						<span class="score" itemprop="ratingValue"><?php if (number_format($cb_review_final_score / 10, 1) == '10.0') { echo number_format($cb_review_final_score / 10, 0);} else {echo number_format($cb_review_final_score / 10, 1);} ?></span>
                            <span class="score-title" itemprop="description"><?php if (isset($cb_rating_short_summary)) {echo $cb_rating_short_summary;}?></span>
                        </div> 
                           
    					<?php if ($cb_user_score == 'on') {  ?>
                                <div class="cb-user-score">
                                    <div id="cb-rating-title"><?php _e('User Score:', 'cubell'); ?> <span id="cb-average-score"><?php echo ($user_score / 10 ); ?></span> <span class="cb-total-votes">(<span class="cb-number-votes"><?php echo $number_votes; ?></span> votes)</span></div>
                                   <span id="cb-vote" class="bg out-of-10 <?php echo $class; ?>"><span class="overlay" style="width:<?php echo (100 - $user_score); ?>%"></span></span>
                                </div>
                                <?php if(function_exists('wp_nonce_field')) {wp_nonce_field('voting_nonce', 'voting_nonce');} ?>
                        <?php } ?>
                        
    				<?php } ?>					
         </div>
      			    
    			<div class="pros-cons">
    				
    					<div class="pros">
    						<h3><?php if (isset($cb_pros_title)) {echo $cb_pros_title;} ?></h3>
    						<ul>
    							<?php if (isset($cb_pros_one)) {echo '<li>'.$cb_pros_one.'</li>';} ?>
    							<?php if (isset($cb_pros_two)) {echo '<li>'.$cb_pros_two.'</li>';}  ?>
    							<?php if (isset($cb_pros_three)) {echo '<li>'.$cb_pros_three.'</li>';} ?>
    						</ul>
    					 </div>
    					 
    					 <div class="cons">
    						   <h3><?php if (isset($cb_cons_title)) {echo $cb_cons_title;} ?></h3>
    						   <ul>
    								<?php if (isset($cb_cons_one)) {echo '<li>'.$cb_cons_one.'</li>';} ?>
    								<?php if (isset($cb_cons_two)) {echo '<li>'.$cb_cons_two.'</li>';}  ?>
    								<?php if (isset($cb_cons_three)) {echo '<li>'.$cb_cons_three.'</li>';} ?>
    						   </ul>
    					</div>
    			 </div>
    			   <?php if ($cb_score_display_type == 'Percentage') { ?>
    			   <div class="crit-bars">
    					 <?php if ((isset($cb_rating_1_title)) && (isset($cb_rating_1_score))) {?> 
    							<div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_1_title;?>: <?php echo ($cb_rating_1_score);?>%</span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_1_score); ?>%"></span></span>
    							</div>
    					 <?php } ?>
    					  <?php  if ((isset($cb_rating_2_title)) && (isset($cb_rating_2_score))) {?> 
    						 <div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_2_title;?>: <?php echo ($cb_rating_2_score);?>%</span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_2_score); ?>%"></span></span>
    							</div>
    					  <?php } ?>
    					 <?php  if ((isset($cb_rating_3_title)) && (isset($cb_rating_3_score))) {?> 
    						   <div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_3_title;?>: <?php echo ($cb_rating_3_score);?>%</span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_3_score); ?>%"></span></span>
    							</div>                                                  
    					 <?php } ?>
    					 <?php if ((isset($cb_rating_4_title)) && (isset($cb_rating_4_score))) {?> 
    						  <div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_4_title;?>: <?php echo ($cb_rating_4_score );?>%</span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_4_score); ?>%"></span></span>
    						   </div>
    					  <?php } ?>
    					 <?php if ((isset($cb_rating_5_title)) && (isset($cb_rating_5_score))) {?> 
    							<div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_5_title;?>: <?php echo ($cb_rating_5_score);?>%</span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_5_score); ?>%"></span></span>
    							</div>
    					  <?php } ?>
    					  <?php if ((isset($cb_rating_6_title)) && (isset($cb_rating_6_score))) {?> 
    							<div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_6_title;?>: <?php echo ($cb_rating_6_score);?>%</span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_6_score); ?>%"></span></span>
    							</div>
    					  <?php } ?> 
    				  <?php } ?>
                      
    				  <?php if ($cb_score_display_type == 'Stars') { ?>
    				  <div class="crit-bars-star">
    					  <?php if ((isset($cb_rating_1_title)) && (isset($cb_rating_1_score))) {?> 
    							<div class="star-bar">
    								<span class="title"><?php echo $cb_rating_1_title;?></span>
    								<span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_1_score); ?>%"></span></span>
    							</div>
    					 <?php } ?>
    					  <?php  if ((isset($cb_rating_2_title)) && (isset($cb_rating_2_score))) {?> 
    						 <div class="star-bar">
    								<span class="title"><?php echo $cb_rating_2_title;?></span>
    								<span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_2_score); ?>%"></span></span>
    							</div>
    					  <?php } ?>
    					 <?php  if ((isset($cb_rating_3_title)) && (isset($cb_rating_3_score))) {?> 
    						   <div class="star-bar">
    								<span class="title"><?php echo $cb_rating_3_title;?></span>
    								<span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_3_score); ?>%"></span></span>
    							</div>                                                  
    					 <?php } ?>
    					 <?php if ((isset($cb_rating_4_title)) && (isset($cb_rating_4_score))) {?> 
    						  <div class="star-bar">
    								<span class="title"><?php echo $cb_rating_4_title;?></span>
    								<span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_4_score); ?>%"></span></span>
    						   </div>
    					  <?php } ?>
    					 <?php if ((isset($cb_rating_5_title)) && (isset($cb_rating_5_score))) {?> 
    							<div class="star-bar">
    								<span class="title"><?php echo $cb_rating_5_title;?></span>
    								<span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_5_score); ?>%"></span></span>
    							</div>
    					  <?php } ?>
    					  <?php if ((isset($cb_rating_6_title)) && (isset($cb_rating_6_score))) {?> 
    							<div class="star-bar">
    								<span class="title"><?php echo $cb_rating_6_title;?></span>
    								<span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_6_score); ?>%"></span></span>
    							</div>
    					  <?php } ?> 
    				  <?php } ?>
                      
    				  <?php if ($cb_score_display_type == 'Out of 10') { ?>
    				  <div class="crit-bars">
    					  <?php if ((isset($cb_rating_1_title)) && (isset($cb_rating_1_score))) {?> 
    							<div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_1_title;?>: <?php echo ($cb_rating_1_score / 10);?></span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_1_score); ?>%"></span></span>
    							</div>
    					 <?php } ?>
    					  <?php  if ((isset($cb_rating_2_title)) && (isset($cb_rating_2_score))) {?> 
    						 <div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_2_title;?>: <?php echo ($cb_rating_2_score / 10);?></span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_2_score); ?>%"></span></span>
    							</div>
    					  <?php } ?>
    					 <?php  if ((isset($cb_rating_3_title)) && (isset($cb_rating_3_score))) {?> 
    						   <div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_3_title;?>: <?php echo ($cb_rating_3_score / 10);?></span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_3_score); ?>%"></span></span>
    							</div>                                                  
    					 <?php } ?>
    					 <?php if ((isset($cb_rating_4_title)) && (isset($cb_rating_4_score))) {?> 
    						  <div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_4_title;?>: <?php echo ($cb_rating_4_score / 10);?></span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_4_score); ?>%"></span></span>
    						   </div>
    					  <?php } ?>
    					 <?php if ((isset($cb_rating_5_title)) && (isset($cb_rating_5_score))) {?> 
    							<div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_5_title;?>: <?php echo ($cb_rating_5_score / 10);?></span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_5_score); ?>%"></span></span>
    							</div>
    					  <?php } ?>
    					  <?php if ((isset($cb_rating_6_title)) && (isset($cb_rating_6_score))) {?> 
    							<div class="normal-bar">
    								<span class="title"><?php echo $cb_rating_6_title;?>: <?php echo ($cb_rating_6_score / 10);?></span>
    								<span class="bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_6_score); ?>%"></span></span>
    							</div>
    					  <?php } ?> 
    				  <?php } ?>
    			  </div>
    		</div><!-- /cb-review-box-top -->
    <?php 
    	 }
    }
}

// Review Score Box - If bottom enabled
if ( ! function_exists( 'cb_review_bottom' ) ) {
    function cb_review_bottom($post){
    
    	$cb_custom_fields = get_post_custom();
    		if (isset($cb_custom_fields['cb_post_options_featured'][0])) {$cb_post_options_featured = 'on'; } else {$cb_post_options_featured = 'off';}
    		if (isset($cb_custom_fields['cb_featured_image_settings'][0])) {$cb_featured_image_settings = $cb_custom_fields['cb_featured_image_settings'][0]; }
    	
    		// Pull review meta data
    		if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
    		if ($cb_review_checkbox == 'on') { 
    			if (isset($cb_custom_fields['cb_user_score'][0])) { $cb_user_score = 'on'; } else { $cb_user_score = 'off';}
    			if (isset($cb_custom_fields['cb_score_display_type'][0])) {$cb_score_display_type = $cb_custom_fields['cb_score_display_type'][0]; }
    			if (isset($cb_custom_fields['cb_rating_1_title'][0])) {$cb_rating_1_title = $cb_custom_fields['cb_rating_1_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_1_score'][0])) {$cb_rating_1_score = $cb_custom_fields['cb_rating_1_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_2_title'][0])) {$cb_rating_2_title = $cb_custom_fields['cb_rating_2_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_2_score'][0])) {$cb_rating_2_score = $cb_custom_fields['cb_rating_2_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_3_title'][0])) {$cb_rating_3_title = $cb_custom_fields['cb_rating_3_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_3_score'][0])) {$cb_rating_3_score = $cb_custom_fields['cb_rating_3_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_4_title'][0])) {$cb_rating_4_title = $cb_custom_fields['cb_rating_4_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_4_score'][0])) {$cb_rating_4_score = $cb_custom_fields['cb_rating_4_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_5_title'][0])) {$cb_rating_5_title = $cb_custom_fields['cb_rating_5_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_5_score'][0])) {$cb_rating_5_score = $cb_custom_fields['cb_rating_5_score'][0]; }
    			if (isset($cb_custom_fields['cb_rating_6_title'][0])) {$cb_rating_6_title = $cb_custom_fields['cb_rating_6_title'][0]; }
    			if (isset($cb_custom_fields['cb_rating_6_score'][0])) {$cb_rating_6_score = $cb_custom_fields['cb_rating_6_score'][0]; }
                if (isset($cb_custom_fields['cb_final_score'][0])) {$cb_final_score = $cb_custom_fields['cb_final_score'][0]; } else { $cb_final_score = NULL; }
                if (isset($cb_custom_fields['cb_final_score_override'][0])) {$cb_final_score_override = $cb_custom_fields['cb_final_score_override'][0]; } else { $cb_final_score_override = NULL; }
    			if (isset($cb_custom_fields['cb_rating_short_summary'][0])) {$cb_rating_short_summary = $cb_custom_fields['cb_rating_short_summary'][0]; }
    			if (isset($cb_custom_fields['cb_pros_title'][0])) { $cb_pros_title = $cb_custom_fields['cb_pros_title'][0]; }
    			if (isset($cb_custom_fields['cb_pros_one'][0])) { $cb_pros_one = $cb_custom_fields['cb_pros_one'][0]; }
    			if (isset($cb_custom_fields['cb_pros_two'][0])) { $cb_pros_two = $cb_custom_fields['cb_pros_two'][0]; }
    			if (isset($cb_custom_fields['cb_pros_three'][0])) { $cb_pros_three = $cb_custom_fields['cb_pros_three'][0]; }
    			if (isset($cb_custom_fields['cb_cons_title'][0])) { $cb_cons_title = $cb_custom_fields['cb_cons_title'][0]; }
    			if (isset($cb_custom_fields['cb_cons_one'][0])) { $cb_cons_one = $cb_custom_fields['cb_cons_one'][0]; }
    			if (isset($cb_custom_fields['cb_cons_two'][0])) { $cb_cons_two = $cb_custom_fields['cb_cons_two'][0]; }
    			if (isset($cb_custom_fields['cb_cons_three'][0])) { $cb_cons_three = $cb_custom_fields['cb_cons_three'][0]; }
    			if (isset($cb_custom_fields['cb_placement'][0])) { $cb_review_placement = $cb_custom_fields['cb_placement'][0]; }

                if ( $cb_final_score_override == NULL ) {
                    $cb_review_final_score = intval($cb_final_score); 
                } else {
                    $cb_review_final_score = intval($cb_final_score_override);
                }

    			$cb_review_final_score_stars = $cb_review_final_score / 20; 
    		} 
    		
    	if (($cb_review_checkbox == 'on') && ($cb_review_placement == 'Bottom')) { 
     
     			// Get user score data if enabled
    			if ($cb_user_score == 'on') { 
    							 
    						$number_votes = get_post_meta($post->ID, "votes", true);
    						$user_score = get_post_meta($post->ID, "user_score", true);	
    						$number_votes = !empty($number_votes) ? $number_votes : "0";
    						$user_score = !empty($user_score) ? $user_score : "0";
    						
    						if( isset($_COOKIE["user_rating"]) ) {  $hasvoted = $_COOKIE['user_rating']; } else { $hasvoted = NULL; }
    						$hasvoted = explode(",", $hasvoted);
    						if(in_array($post->ID, $hasvoted)) {
    							$class = "disabled";
    						} else {
    							$class = "";
    						}
    			}
    ?>
          <div class="cb-review-box-bottom clearfix">
               <div class="cb-scores clearfix">
          				<?php 
    					// Show Percetange Review Meta if enabled
    					if ($cb_score_display_type == 'Percentage') { 
    					?>                      
                        <div class="cb-score-box" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                              <meta itemprop="worstRating" content="1">
                              <meta itemprop="bestRating" content="100">
                              <span class="score h2" itemprop="ratingValue"><?php echo $cb_review_final_score; ?><span class="h4">%</span></span>
                              <span class="score-title" itemprop="description"><?php if (isset($cb_rating_short_summary)) {echo $cb_rating_short_summary;}?></span>
                          </div>
                  		  <?php if ($cb_user_score == 'on') {  ?>
                              <div class="cb-user-score">
                                 	<div id="cb-rating-title"><?php _e('User Score:', 'cubell'); ?> <span id="cb-average-score"><?php echo $user_score; ?>%</span> <span class="cb-total-votes">(<span class="cb-number-votes"><?php echo $number_votes; ?></span> votes)</span></div>
                                	 <span id="cb-vote" class="bg percentage <?php echo $class; ?>"><span class="overlay" style="width:<?php echo (100 - $user_score); ?>%"></span></span>
                               </div>
               				   <?php if(function_exists('wp_nonce_field')) {wp_nonce_field('voting_nonce', 'voting_nonce');}
    						  } 
    					 } 
    					 
    					// Show Star Review Meta if enabled
    					if ($cb_score_display_type == 'Stars')  { ?>
                          
                         	<div class="cb-score-box-star" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                              	  <meta itemprop="worstRating" content="1">
                                  <meta itemprop="bestRating" content="5">
                                  <span class="filling-bg"><span class="filling-star" style="width:<?php echo $cb_review_final_score; ?>%"></span></span>
                                  <span class="score h2" itemprop="ratingValue"><?php echo  number_format($cb_review_final_score_stars, 1); ?></span>
                            </div>
                            <?php if ($cb_user_score == 'on') {  ?>
                                    <div class="cb-user-score">
                                        <div id="cb-rating-title"><?php _e('User Score:', 'cubell'); ?> <span class="cb-total-votes">(<span class="cb-number-votes"><?php echo $number_votes; ?></span> votes)</span></div>
                                       <span id="cb-vote" class="bg stars <?php echo $class; ?>"><span class="overlay" style="width:<?php echo (100 - $user_score); ?>%"></span></span>
                                    </div>
                                    <?php if(function_exists('wp_nonce_field')) {wp_nonce_field('voting_nonce', 'voting_nonce'); } 
    							 } 
    				  } 
    				  
    				  // Show Out of 10 Review Meta if enabled
    				  if ($cb_score_display_type == 'Out of 10')  { 
    				?>
    					<div class="cb-score-box" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                               <meta itemprop="worstRating" content="1">
                               <meta itemprop="bestRating" content="10">
                               <span class="score h2" itemprop="ratingValue"><?php if (number_format($cb_review_final_score / 10, 1) == '10.0') { echo number_format($cb_review_final_score / 10, 0);} else {echo number_format($cb_review_final_score / 10, 1);} ?></span>
                                <span class="score-title" itemprop="description"><?php if (isset($cb_rating_short_summary)) {echo $cb_rating_short_summary;}?></span>
                        </div> 
                           
    					<?php if ($cb_user_score == 'on') {  ?>
                                <div class="cb-user-score">
                                    <div id="cb-rating-title"><?php _e('User Score:', 'cubell'); ?> <span id="cb-average-score"><?php echo ($user_score / 10 ); ?></span> <span class="cb-total-votes">(<span class="cb-number-votes"><?php echo $number_votes; ?></span> votes)</span></div>
                                   <span id="cb-vote" class="bg out-of-10 <?php echo $class; ?>"><span class="overlay" style="width:<?php echo (100 - $user_score); ?>%"></span></span>
                                </div>
                                <?php if(function_exists('wp_nonce_field')) {wp_nonce_field('voting_nonce', 'voting_nonce');} ?>
                        <?php } ?>
                        
    				<?php } ?>	
    
             </div>
    
    
                  <div class="cb-good-summary">
                      <h3 class="h4"><?php if (isset($cb_pros_title)) {echo $cb_pros_title;} ?></h3>
                          <ul>
                              <?php if (isset($cb_pros_one)) {echo '<li>'.$cb_pros_one.'</li>';} ?>
                              <?php if (isset($cb_pros_two)) {echo '<li>'.$cb_pros_two.'</li>';}  ?>
                              <?php if (isset($cb_pros_three)) {echo '<li>'.$cb_pros_three.'</li>';} ?>
                          </ul>
                  </div>
                  <div class="cb-bad-summary">
                      <h3 class="h4"><?php if (isset($cb_cons_title)) {echo $cb_cons_title;} ?></h3>
                         <ul>
                              <?php if (isset($cb_cons_one)) {echo '<li>'.$cb_cons_one.'</li>';} ?>
                              <?php if (isset($cb_cons_two)) {echo '<li>'.$cb_cons_two.'</li>';}  ?>
                              <?php if (isset($cb_cons_three)) {echo '<li>'.$cb_cons_three.'</li>';} ?>
                         </ul>
                  </div>
                  
                 <?php if ($cb_score_display_type == 'Percentage') { ?>
                 <div class="crit-bars twelvecol first">
                     <?php if ((isset($cb_rating_1_title)) && (isset($cb_rating_1_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_1_title; ?></span>
                              <span class="crit-score"><?php echo $cb_rating_1_score; ?>%</span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_1_score);?>%"></div></div>
                        <?php } ?>
                        <?php if ((isset($cb_rating_2_title)) && (isset($cb_rating_2_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_2_title; ?></span>
                              <span class="crit-score"><?php echo $cb_rating_2_score; ?>%</span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_2_score);?>%"></div></div>
                        <?php } ?>
                       <?php if ((isset($cb_rating_3_title)) && (isset($cb_rating_3_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_3_title; ?></span>
                              <span class="crit-score"><?php echo $cb_rating_3_score; ?>%</span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_3_score);?>%"></div></div>
                        <?php } ?>
                        <?php if ((isset($cb_rating_4_title)) && (isset($cb_rating_4_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_4_title; ?></span>
                              <span class="crit-score"><?php echo $cb_rating_4_score; ?>%</span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_4_score);?>%"></div></div>
                        <?php } ?>
                       <?php if ((isset($cb_rating_5_title)) && (isset($cb_rating_5_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_5_title; ?></span>
                              <span class="crit-score"><?php echo $cb_rating_5_score; ?>%</span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_5_score);?>%"></div></div>
                        <?php } ?>
                        <?php if ((isset($cb_rating_6_title)) && (isset($cb_rating_6_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_6_title; ?></span>
                              <span class="crit-score"><?php echo $cb_rating_6_score; ?>%</span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_6_score);?>%"></div></div>
                        <?php } ?>  
                    <?php } ?>
                    <?php if ($cb_score_display_type == 'Stars') { ?>
                    <div class="crit-bars-star">
                        <?php if ((isset($cb_rating_1_title)) && (isset($cb_rating_1_score))) {?> 
                              <div class="star-bar">
                                  <span class="title"><?php echo $cb_rating_1_title;?></span>
                                  <span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_1_score); ?>%"></span></span>
                              </div>
                       <?php } ?>
                        <?php  if ((isset($cb_rating_2_title)) && (isset($cb_rating_2_score))) {?> 
                           <div class="star-bar">
                                  <span class="title"><?php echo $cb_rating_2_title;?></span>
                                  <span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_2_score); ?>%"></span></span>
                              </div>
                        <?php } ?>
                       <?php  if ((isset($cb_rating_3_title)) && (isset($cb_rating_3_score))) {?> 
                             <div class="star-bar">
                                  <span class="title"><?php echo $cb_rating_3_title;?></span>
                                  <span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_3_score); ?>%"></span></span>
                              </div>                                                  
                       <?php } ?>
                       <?php if ((isset($cb_rating_4_title)) && (isset($cb_rating_4_score))) {?> 
                            <div class="star-bar">
                                  <span class="title"><?php echo $cb_rating_4_title;?></span>
                                  <span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_4_score); ?>%"></span></span>
                             </div>
                        <?php } ?>
                       <?php if ((isset($cb_rating_5_title)) && (isset($cb_rating_5_score))) {?> 
                              <div class="star-bar">
                                  <span class="title"><?php echo $cb_rating_5_title;?></span>
                                  <span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_5_score); ?>%"></span></span>
                              </div>
                        <?php } ?>
                        <?php if ((isset($cb_rating_6_title)) && (isset($cb_rating_6_score))) {?> 
                              <div class="star-bar">
                                  <span class="title"><?php echo $cb_rating_6_title;?></span>
                                  <span class="stars-bg"><span class="overlay" style="width:<?php echo (100 - $cb_rating_6_score); ?>%"></span></span>
                              </div>
                        <?php } ?> 
                    <?php } ?>
                    <?php if ($cb_score_display_type == 'Out of 10') { ?>
                    <div class="crit-bars twelvecol first">
                        <?php if ((isset($cb_rating_1_title)) && (isset($cb_rating_1_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_1_title;?></span>
                              <span class="crit-score"><?php echo ($cb_rating_1_score / 10); ?></span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_1_score);?>%"></div></div>
                        <?php } ?>
                        <?php if ((isset($cb_rating_2_title)) && (isset($cb_rating_2_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_2_title;?></span>
                              <span class="crit-score"><?php echo ($cb_rating_2_score / 10); ?></span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_2_score);?>%"></div></div>
                        <?php } ?>
                       <?php if ((isset($cb_rating_3_title)) && (isset($cb_rating_3_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_3_title;?></span>
                              <span class="crit-score"><?php echo ($cb_rating_3_score / 10); ?></span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_3_score);?>%"></div></div>
                        <?php } ?>
                        <?php if ((isset($cb_rating_4_title)) && (isset($cb_rating_4_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_4_title;?></span>
                              <span class="crit-score"><?php echo ($cb_rating_4_score / 10); ?></span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_4_score);?>%"></div></div>
                        <?php } ?>
                       <?php if ((isset($cb_rating_5_title)) && (isset($cb_rating_5_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_5_title;?></span>
                              <span class="crit-score"><?php echo ($cb_rating_5_score / 10); ?></span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_5_score);?>%"></div></div>
                        <?php } ?>
                        <?php if ((isset($cb_rating_6_title)) && (isset($cb_rating_6_score))) {?> 
                              <span class="crit-title"><?php echo $cb_rating_6_title;?></span>
                              <span class="crit-score"><?php echo ($cb_rating_6_score / 10); ?></span>
                              <div class="cb-crit-bar"><div class="crit-filling" style="width:<?php echo (100 - $cb_rating_6_score);?>%"></div></div>
                        <?php } ?> 
                    <?php } ?>
                </div>
          </div><!-- /cb-review-box-bottom -->
          
      <?php }
    							
    }
}

// Review Score Box Thumbnail
if ( ! function_exists( 'cb_review_thumbnail' ) ) {
    function cb_review_thumbnail() {
      
        $cb_rating_short_summary = NULL;
        $cb_custom_fields = get_post_custom();
        if (isset($cb_custom_fields['cb_post_options_featured'][0])) {$cb_post_options_featured = 'on'; } else {$cb_post_options_featured = 'off';}
        if (isset($cb_custom_fields['cb_featured_image_settings'][0])) {$cb_featured_image_settings = $cb_custom_fields['cb_featured_image_settings'][0]; }

        // Pull review meta data
        if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
        if ($cb_review_checkbox == 'on') { 
            if (isset($cb_custom_fields['cb_score_display_type'][0])) {$cb_score_display_type = $cb_custom_fields['cb_score_display_type'][0]; }
            if (isset($cb_custom_fields['cb_rating_1_title'][0])) {$cb_rating_1_title = $cb_custom_fields['cb_rating_1_title'][0]; }
            if (isset($cb_custom_fields['cb_rating_1_score'][0])) {$cb_rating_1_score = $cb_custom_fields['cb_rating_1_score'][0]; }
            if (isset($cb_custom_fields['cb_rating_2_title'][0])) {$cb_rating_2_title = $cb_custom_fields['cb_rating_2_title'][0]; }
            if (isset($cb_custom_fields['cb_rating_2_score'][0])) {$cb_rating_2_score = $cb_custom_fields['cb_rating_2_score'][0]; }
            if (isset($cb_custom_fields['cb_rating_3_title'][0])) {$cb_rating_3_title = $cb_custom_fields['cb_rating_3_title'][0]; }
            if (isset($cb_custom_fields['cb_rating_3_score'][0])) {$cb_rating_3_score = $cb_custom_fields['cb_rating_3_score'][0]; }
            if (isset($cb_custom_fields['cb_rating_4_title'][0])) {$cb_rating_4_title = $cb_custom_fields['cb_rating_4_title'][0]; }
            if (isset($cb_custom_fields['cb_rating_4_score'][0])) {$cb_rating_4_score = $cb_custom_fields['cb_rating_4_score'][0]; }
            if (isset($cb_custom_fields['cb_rating_5_title'][0])) {$cb_rating_5_title = $cb_custom_fields['cb_rating_5_title'][0]; }
            if (isset($cb_custom_fields['cb_rating_5_score'][0])) {$cb_rating_5_score = $cb_custom_fields['cb_rating_5_score'][0]; }
            if (isset($cb_custom_fields['cb_rating_6_title'][0])) {$cb_rating_6_title = $cb_custom_fields['cb_rating_6_title'][0]; }
            if (isset($cb_custom_fields['cb_rating_6_score'][0])) {$cb_rating_6_score = $cb_custom_fields['cb_rating_6_score'][0]; }
            if (isset($cb_custom_fields['cb_final_score'][0])) {$cb_final_score = $cb_custom_fields['cb_final_score'][0]; }
            if (isset($cb_custom_fields['cb_final_score_override'][0])) {$cb_final_score_override = $cb_custom_fields['cb_final_score_override'][0]; } else { $cb_final_score_override = NULL; }
            if (isset($cb_custom_fields['cb_rating_short_summary'][0])) {$cb_rating_short_summary = $cb_custom_fields['cb_rating_short_summary'][0]; }

            if ( $cb_final_score_override == NULL ) {
                $cb_review_final_score = intval($cb_final_score); 
            } else {
                $cb_review_final_score = intval($cb_final_score_override);
            }

            $cb_review_final_score_stars = $cb_review_final_score / 20; 
        }

    if ($cb_review_checkbox == 'on') { 
                         if ($cb_score_display_type == 'Percentage') { ?>
                            <a href="<?php the_permalink(); ?>">
                            <span class="cb-score-box">
                                <span class="score h2"><?php echo trim($cb_review_final_score); ?><span class="h4">%</span></span>
                                <?php if (isset($cb_rating_short_summary)) { echo '<span class="score-title" itemprop="description">'. $cb_rating_short_summary. '</span>'; } ?>
                        <?php } ?>
                        
                        <?php if ($cb_score_display_type == 'Stars')  { ?>
                           <a href="<?php the_permalink(); ?>"> 
                            <span class="cb-score-box-star">
                                
                                <span class="score h2"><?php echo  number_format($cb_review_final_score_stars, 1, '.', ''); ?></span>
                                
                                <span class="filling-bg"><span class="filling-star" style="width:<?php echo $cb_review_final_score; ?>%"></span></span>
                               
                        <?php } ?>
                        
                        <?php if ($cb_score_display_type == 'Out of 10')  { ?>
                        <a href="<?php the_permalink(); ?>">
                            <span class="cb-score-box"><span class="score h2"><?php if (number_format($cb_review_final_score / 10, 1) == '10.0') { echo number_format($cb_review_final_score / 10, 0);} else {echo number_format($cb_review_final_score / 10, 1);} ?></span>
                                  
                            <?php if (isset($cb_rating_short_summary)) { echo '<span class="score-title" itemprop="description">'. $cb_rating_short_summary. '</span>'; } ?>
                        <?php } ?>
                        
                        </span>   
                        </a>  
                <?php } 
    }
}
// Review Widget Thumbnail
if ( ! function_exists( 'cb_review_widget_thumbnail' ) ) {
    function cb_review_widget_thumbnail() {
      
      $cb_rating_short_summary = NULL;
      $cb_custom_fields = get_post_custom();
      if (isset($cb_custom_fields['cb_post_options_featured'][0])) {$cb_post_options_featured = 'on'; } else {$cb_post_options_featured = 'off';}

        // Pull review meta data
        if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
        if ($cb_review_checkbox == 'on') { 
            if (isset($cb_custom_fields['cb_score_display_type'][0])) {$cb_score_display_type = $cb_custom_fields['cb_score_display_type'][0]; }	
            if (isset($cb_custom_fields['cb_final_score'][0])) { $cb_final_score = $cb_custom_fields['cb_final_score'][0]; } else { $cb_final_score = NULL; }
            if (isset($cb_custom_fields['cb_final_score_override'][0])) { $cb_final_score_override = $cb_custom_fields['cb_final_score_override'][0]; } else { $cb_final_score_override = NULL; }

            if ( $cb_final_score_override == NULL ) {
                $cb_review_final_score = intval($cb_final_score); 
            } else {
                $cb_review_final_score = intval($cb_final_score_override);
            }

            $cb_review_final_score = intval($cb_final_score);
            $cb_review_final_score_stars = $cb_review_final_score / 20; 
        }

        if ($cb_review_checkbox == 'on') {
                         if ($cb_score_display_type == 'Percentage') { ?>
                            <span class="cb-score-box">
                                <span class="score h2"><?php echo trim($cb_review_final_score); ?><span class="h6">%</span></span>
                        <?php } ?>
                        
                        <?php if ($cb_score_display_type == 'Stars')  { ?>
                            <span class="cb-score-box-star">
                                
                                <span class="score h2"><?php echo  number_format($cb_review_final_score_stars, 1, '.', ''); ?></span>
                                                           
                        <?php } ?>
                        
                        <?php if ($cb_score_display_type == 'Out of 10')  { ?>
                            <span class="cb-score-box"><span class="score h2"><?php if (number_format($cb_review_final_score / 10, 1) == '10.0') { echo number_format($cb_review_final_score / 10, 0);} else {echo number_format($cb_review_final_score / 10, 1);} ?></span>
                                  
                        <?php } ?>
                        
                        </span>   
        <?php } 
    }
}

if ( ! function_exists( 'cb_user_rating' ) ) {
    function cb_user_rating() {
    	if (is_single()) {
    		global $post;
    		echo " <script type='text/javascript'>
                		(function($) {'use strict';
                			
                			var old_overlay = $('#cb-vote .overlay').css( 'width' );
                            var cbVote = $('#cb-vote');
                            var cbVoteOverlay = $('#cb-vote').find('.overlay');
                                            			
                			 $(cbVote).not('.disabled').on('mousemove click mouseleave mouseenter', function(e) {
                					
                				if(e.type == 'mouseenter'){	 $('<p class=\"cb-user-rating-tip\"></p>').appendTo('body'); }	
                		
                				var parentOffset = $(this).parent().offset(); 
                				  
                				  if($(this).hasClass('stars')) { 
                						var base_amountX = Math.ceil((e.pageX - (parentOffset.left + 15)) / 1.2);
                						var amountX = (Math.floor(base_amountX * 10 / 20) / 10).toFixed(1);
                						
                				  } else if($(this).hasClass('percentage')) {  
                						var base_amountX = Math.ceil((e.pageX - parentOffset.left) / 1.5);
                						var amountX = base_amountX;
                						
                				  } else if($(this).hasClass('out-of-10')) {
                						var base_amountX = Math.ceil((e.pageX - parentOffset.left) / 1.5);
                						var amountX = (base_amountX / 10).toFixed(1);
                					 }	   
                				
                				$(cbVoteOverlay).css( 'width', (100 - base_amountX) +'%' );
                						
                				 var mousex = e.pageX + 20;
                				 var mousey = e.pageY + 10; 
                				 $('.cb-user-rating-tip').text(amountX).fadeIn('fast');
                				 $('.cb-user-rating-tip').css({ top: mousey, left: mousex });
                			
                				if(e.type == 'mouseleave'){
                				    	 $('.cb-user-rating-tip').remove(); 
                				    	 $(cbVoteOverlay).css( 'width', old_overlay); 
                                }
                                
                				if(e.type == 'click'){	
                							
                					var parentOffset = $(this).parent().offset(); 
                			   
                					if($(this).hasClass('stars')) { 
                							var amountX = Math.ceil((e.pageX - (parentOffset.left + 15)) / 1.2);			
                					   } else { 
                							var amountX = Math.ceil((e.pageX - parentOffset.left) / 1.5);
                					}
                                       
                			        var cbVoteAmount =  $('#cb-rating-title').find('.cb-number-votes').text();
                					var nonce = $('input#voting_nonce').val();
                                    var data_votes = {action: 'cb_vote_counter', nonce: nonce, postid: '".$post->ID."'};
                                    var data_score = {action: 'cb_add_user_score', nonce: nonce, cbCurrentVotes: parseInt(cbVoteAmount), cbNewScore: amountX, postid: '". $post->ID ."'};
                					
                					$('.cb-user-rating-tip').remove(); 
                					$(cbVote).off('mousemove click mouseleave mouseenter'); 
                						
                					$.post('". admin_url('admin-ajax.php'). "', data_votes, function(response) {
                						if(response!='-1') {
                							
                							if(response=='null') {
                							} else {
                								$('.cb-number-votes').html(response);
                							}
                								
                							var cb_checker = cookie.get('user_rating'); 
                							if(!cb_checker) {
                								var cb_rating_c = '" . $post->ID . "';
                							} else {
                								var cb_rating_c = cb_checker + '," . $post->ID . "';
                							}
                							cookie.set('user_rating', cb_rating_c, { expires: 365, }); 
                						} 
                					});
                							
                					$.post('". admin_url('admin-ajax.php'). "', data_score, function(response){

                							if(response!='-1') {
                							
                								if(response=='null') {
                								} else {
                									var overlay = (100 - response);
                									
                									if( $(cbVote).hasClass('out-of-10') ) { 
                										$('#cb-average-score').html(response / 10);
                									} else { 
                										$('#cb-average-score').html(response);
                									}
                									
                									$(cbVoteOverlay).css( 'width', overlay +'%' );
                									$(cbVote).addClass('disabled');
                									$(cbVote).off('click');
                								}
                							} 
                				 });
                				 return false;
                							
                				}
                			});
                			  
                		})(jQuery);
    		      </script>";
    	}
    }
}

if ( ! function_exists( 'cb_vote_counter' ) ) {
    function cb_vote_counter() {
    	
    	if ( ! wp_verify_nonce($_POST['nonce'], 'voting_nonce') ) { return; }
    
        $cb_post_id = $_POST['postid'];
        $cb_current_votes = get_post_meta($cb_post_id, "votes", true); 
        
        if ($cb_current_votes == NULL) {
            $cb_current_votes = 0;
        }
        
        $cb_new_votes = $cb_current_votes + 1;
        
        update_post_meta($cb_post_id, "votes", $cb_new_votes);
        
        echo $cb_new_votes;
        die(0);
    }
}
add_action("wp_ajax_cb_vote_counter", "cb_vote_counter");
add_action("wp_ajax_nopriv_cb_vote_counter", "cb_vote_counter");

if ( ! function_exists( 'cb_add_user_score' ) ) {
    function cb_add_user_score() {
    	
    	$cb_post_id = $_POST['postid'];
        $latest_score = $_POST['cbNewScore'];
        $cb_current_votes = $_POST['cbCurrentVotes'];   
        
        if ( $cb_current_votes == NULL ) {
             $cb_current_votes = 0; 
        }

        $cb_current_score = get_post_meta($cb_post_id, "user_score", true);    
        $cb_current_votes = intval($cb_current_votes);
        $cb_current_score = intval($cb_current_score);

        if ($cb_current_votes > 1) {
            $cb_current_score_total = ($cb_current_score * ($cb_current_votes-1) );
            $new_score = intval(($cb_current_score_total + $latest_score) / $cb_current_votes );
        }
        
        if ( ($cb_current_votes == 0)) {
            $new_score = intval($cb_current_score + $latest_score );
        }
        
        if (($cb_current_votes == 1)) {
            $new_score = (intval($cb_current_score + $latest_score ))/2;
        }
   
        update_post_meta($cb_post_id, "user_score", $new_score);
        
        echo $new_score;
        die(0);
    }
}
add_action("wp_ajax_cb_add_user_score", "cb_add_user_score");
add_action("wp_ajax_nopriv_cb_add_user_score", "cb_add_user_score");

/*********************
 CLEAN NEXT/PREVIOUS LINKS
*********************/
if ( ! function_exists( 'cb_previous_next_links' ) ) {
    function cb_previous_next_links() {
      $previous = get_adjacent_post( false, '', true );
      $next = get_adjacent_post( false, '', false );
    	?>
          <div class="cb-previous-next-links clearfix">
                          <div class="previous">
                          	<span class="arrows"></span>
                              <?php if ($previous){  previous_post_link( "%link", __("<span>Previous Story</span>", "cubell") .  _x("<h3 class='h5'>%title</h3>", "Previous article link", "cubell") );} else { echo _e("<span class='empty'>No older stories</span>", "cubell");} ?>
                          </div>
                          <div class="next">
                          		<span class="arrows"></span>
                              <?php if ($next){  next_post_link( "%link", __("<span>Next Story</span>", "cubell") .  _x("<h3 class='h5'>%title</h3>", "Next article link", "cubell" ) );} else { echo _e("<span class='empty'>No newer stories</span>", "cubell");} ?>
                              
                          </div>
          </div><!-- /Previous-Next Links -->
          <?php
    }
}

/*********************
CLEAN TAGCLOUD WIDGET
*********************/
if ( ! function_exists( 'cb_tag_cloud' ) ) {
    function cb_tag_cloud($args) {
    	$args['number'] = 10; 
    	return $args;
    }
}
add_filter( 'widget_tag_cloud_args', 'cb_tag_cloud' );

/*********************
CUSTOM GALLERY
*********************/
if ( ! function_exists( 'cb_gallery_shortcode' ) ) {
    function cb_gallery_shortcode($attr) {
        $post = get_post();
    
        static $instance = 0;
        $instance++;
    
        if ( ! empty( $attr['ids'] ) ) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if ( empty( $attr['orderby'] ) )
                $attr['orderby'] = 'post__in';
            $attr['include'] = $attr['ids'];
        }
    
        // Allow plugins/themes to override the default gallery template.
        $output = apply_filters('post_gallery', '', $attr);
        if ( $output != '' )
            return $output;
    
        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        }
    
    	extract(shortcode_atts(array(
    		'order'      => 'ASC',
    		'orderby'    => 'menu_order ID',
    		'id'         => $post->ID,
    		'itemtag'    => 'dl',
    		'icontag'    => 'dt',
    		'captiontag' => 'dd',
    		'columns'    => 4,
    		'size'       => 'thumbnail',
    		'include'    => '',
    		'link'       => 'file',
    		'exclude'    => ''
    	), $attr));
    
    	$id = intval($id);
    	if ( 'RAND' == $order )
    		$orderby = 'none';
    
    	if ( !empty($include) ) {
    		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    
    		$attachments = array();
    		foreach ( $_attachments as $key => $val ) {
    			$attachments[$val->ID] = $_attachments[$key];
    		}
    	} elseif ( !empty($exclude) ) {
    		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    	} else {
    		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    	}
    
    	if ( empty($attachments) )
    		return '';
    
    	if ( is_feed() ) {
    		$output = "\n";
    		foreach ( $attachments as $att_id => $attachment )
    			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    		return $output;
    	}
    
    	$itemtag = tag_escape($itemtag);
    	$captiontag = tag_escape($captiontag);
    	$icontag = tag_escape($icontag);
    	$valid_tags = wp_kses_allowed_html( 'post' );
    	if ( ! isset( $valid_tags[ $itemtag ] ) )
    		$itemtag = 'dl';
    	if ( ! isset( $valid_tags[ $captiontag ] ) )
    		$captiontag = 'dd';
    	if ( ! isset( $valid_tags[ $icontag ] ) )
    		$icontag = 'dt';
    
    	$columns = 4;
    	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    	$float = is_rtl() ? 'right' : 'left';
    
    	$selector = "gallery-{$instance}";
    
    	$gallery_style = $gallery_div = '';
        
    	$size_class = sanitize_html_class( $size );
    	$gallery_div = "<div class='clearfix'></div><div id='$selector' class='gallery galleryid-{$id}  gallery-size-{$size_class} clearfix'>";
    	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
    
    	$i = 0;
    	foreach ( $attachments as $id => $attachment ) {
    		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, (array(380,380)), false, false) : wp_get_attachment_link($id,  (array(380,380)), false, false);
    
    		$output .= "<{$itemtag} class='gallery-item cb-gallery-item'>";
    		$output .= "
    			<{$icontag} class='gallery-icon'>
    				$link
    			</{$icontag}>";
    		if ( $captiontag && trim($attachment->post_excerpt) ) {
    			$output .= "
    				<{$captiontag} class='wp-caption-text gallery-caption'>
    				" . wptexturize($attachment->post_excerpt) . "
    				</{$captiontag}>";
    		}
    		$output .= "</{$itemtag}>";
    		if ( $columns > 0 && ++$i % $columns == 0 )
    			$output .= '<div class="clearfix"></div>';
    	}
    
    	$output .= "</div><div class='clearfix'></div>";
    	return $output;
    }
}
/*********************
SOCIAL SHARING
*********************/
if ( ! function_exists( 'cb_social_sharing' ) ) {  
    function cb_social_sharing($post) {
            $cb_output = NULL;

            $cb_o_twitter = 'horizontal';
            $cb_o_google = 'medium';
            $cb_o_pinterest = 'beside';
            $cb_o_facebook = 'button_count';
            
            $cb_featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); 
            $cb_encoded_img = urlencode($cb_featured_image_url[0]);
            $cb_encoded_url = urlencode(get_permalink($post->ID));
            $cb_encoded_desc = urlencode(get_the_title($post->ID));
            $cb_twitter_code = 'https://twitter.com/share';
            
            $cb_output .= '<div class="cb-social-sharing" clearfix">';
            
            $cb_output .= '<div class="cb-facebook">
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, "script", "facebook-jssdk"));</script>
                       <div class="fb-like" data-href="'.get_permalink($post->ID).'" data-width="450" data-layout="'.$cb_o_facebook.'" data-show-faces="false" data-send="false"></div></div>';
                        
            $cb_output .= '<div class="cb-pinterest"><script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script> 
            <a href="//pinterest.com/pin/create/button/?url=' .$cb_encoded_url. '&media='.$cb_encoded_img.'&description=' .$cb_encoded_desc.'" data-pin-do="buttonPin" data-pin-config="'.$cb_o_pinterest.'" target="_blank"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a></div>';
                       
            $cb_output .= '<div class="cb-google">
                            <div class="g-plusone" data-size="'.$cb_o_google.'"></div>
                            
                            <script type="text/javascript">
                              (function() {
                                var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
                                po.src = "https://apis.google.com/js/plusone.js";
                                var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
                              })();
                            </script></div>';
                            
            $cb_output .= '<div class="cb-twitter"><a href="'. $cb_twitter_code .'" class="twitter-share-button" data-dnt="true"  data-count="'.$cb_o_twitter.'">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script></div>';

            $cb_output .= '</div>';
            
            return $cb_output;
    }
}
?>