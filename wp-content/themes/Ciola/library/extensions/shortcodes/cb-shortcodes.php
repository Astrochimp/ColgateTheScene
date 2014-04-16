<?php
/*
Plugin Name: Friendly Short Code Buttons
Plugin URI: http://pippinsplugins.com
Description: Adds user-friendly short code buttons to your  WordPress site. This plugin is more of an example than anything, but does provide a few nice looking buttons
Version: 1.0.1
License: GPL
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
*/
	// Buttons Shortcode
	function button_shortcode( $atts, $content = null )
	{
		extract( shortcode_atts( array(
		  'color' => 'blue',
		  'size' => 'normal',
		  'text' => '',
		  'alignment' => 'none',
          'openin' => 'samewindow',
          'rel' => '1',
		  'url' => '',
		  ), $atts ) );
		  
		$size .= '-square'; $color .= '-square';
        $nofollow = NULL;
        if ($rel == "2") {$nofollow = 'rel="nofollow"';}
		
		if ($openin == 'samewindow') {$window = 'target="_self"'; } else {$window = 'target="_blank"';}
				
		if ($alignment == 'center') {
		
				if($url) {
				 		 return '<div class="cb-button-center"><div class="button-square '. $color . '-button ' . $size .'-button"><a href="' . $url . '" '.$window.' '.$nofollow.'>' . $content . '</a></div></div>';
				} else {
						 return '<div class="cb-button-center"><div class="button-square '. $color . '-button ' . $size .'-button">' . $content . '</div></div>';
				}		
		} else {
				if($url) {
				  return '<div class="button-square '. $color . '-button ' . $size .'-button"><a href="' . $url . '" '.$window.' '.$nofollow.'>' . $content . '</a></div>';
				} else {
					 return '<div class="button-square '. $color . '-button ' . $size .'-button">' . $content . '</div>';
				}
		}
	}
	add_shortcode('button', 'button_shortcode');
	
	// Video Gallery Shortcode
	function videogallery_shortcode( $atts, $content = null )
	{
		extract( shortcode_atts( array(
		  'size' => '2',
		  'video1' => '',
		  'url1' => '',
		  'image1' => '',
		  'caption1' => '',
		  'video2' => '',
		  'url2' => '',
		  'image2' => '',
		  'caption2' => '',
		  'video3' => '',
		  'url3' => '',
		  'image3' => '',
		  'caption3' => '',
		  'video4' => '',
		  'url4' => '',
		  'image4' => '',
		  'caption4' => '',		  		  		  
		  ), $atts ) );
		
		if ($video1 == 'youtube')	$finalurl1 = 'http://www.youtube.com/embed/'.$url1;	
		if ($video1 == 'vimeo')	$finalurl1 = 'http://player.vimeo.com/video/'.$url1;	
		
		if ($video2 == 'youtube')	$finalurl2 = 'http://www.youtube.com/embed/'.$url2;	
		if ($video2 == 'vimeo')	$finalurl2 = 'http://player.vimeo.com/video/'.$url2;	
				
		if($size == 2) {
		  return '<div class="cb-video-gallery">'.do_shortcode('[column size=one_half position=first ]<a class="cb-lightbox" title="'.$caption1.'" href="'.$finalurl1.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image1.'" /></a>[/column][column size=one_half position=last ]<a class="cb-lightbox" title="'.$caption2.'" href="'.$finalurl2.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image2.'" /></a>[/column]').'</div>'; 
		} 
		
		if($size == 3) {
		if ($video3 == 'youtube')	$finalurl3 = 'http://www.youtube.com/embed/'.$url3;	
		if ($video3 == 'vimeo')	$finalurl3 = 'http://player.vimeo.com/video/'.$url3;		
					
		 return '<div class="cb-video-gallery">'.do_shortcode('[column size=one_third position=first ]<a class="cb-lightbox" title="'.$caption1.'" href="'.$finalurl1.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image1.'" /></a>[/column][column size=one_third position=middle ]<a class="cb-lightbox" title="'.$caption2.'" href="'.$finalurl2.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image2.'" /></a>[/column][column size=one_third position=last ]<a class="cb-lightbox" title="'.$caption3.'" href="'.$finalurl3.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image3.'" /></a>[/column]').'</div>'; 
		} 

		if($size == 4) {
			
		if ($video3 == 'youtube')	$finalurl3 = 'http://www.youtube.com/embed/'.$url3;	
		if ($video3 == 'vimeo')	$finalurl3 = 'http://player.vimeo.com/video/'.$url3;	
		if ($video4 == 'youtube')	$finalurl4 = 'http://www.youtube.com/embed/'.$url4;	
		if ($video4 == 'vimeo')	$finalurl4 = 'http://player.vimeo.com/video/'.$url4;
		
		return '<div class="cb-video-gallery">'.do_shortcode('[column size=one_quarter position=first ]<a class="cb-lightbox" title="'.$caption1.'" href="'.$finalurl1.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image1.'" /></a>[/column][column size=one_quarter position=middle ]<a class="cb-lightbox" title="'.$caption2.'" href="'.$finalurl2.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image2.'" /></a>[/column][column size=one_quarter position=middle ]<a class="cb-lightbox" title="'.$caption3.'" href="'.$finalurl3.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image3.'" /></a>[/column][column size=one_quarter position=last ]<a class="cb-lightbox" title="'.$caption4.'" href="'.$finalurl4.'" rel="video_gallery"><img class="alignnone size-medium" src="'.$image4.'" /></a>[/column]').'</div>'; 
		} 
	}
	add_shortcode('videogallery', 'videogallery_shortcode');
	
	// Columns Shortcode
	function column_shortcode( $atts, $content = null )
	{
		extract( shortcode_atts( array(
		  'size' => 'normal',
		  'position' => 'first',
		  ), $atts ) );
		  
		$clearfix = NULL;
		if ($position == 'middle') { $position = '';}
		if ($position == 'first') { $position = ' first';}
		if ($position == 'last') { $position = ' last'; $clearfix = '<div class="clearfix"></div>';}
		if ($size == 'one_half') { $size = 'sixcol';}
		if ($size == 'one_third') { $size = 'fourcol';}
		if ($size == 'two_third') { $size = 'eightcol';}
		if ($size == 'one_quarter') { $size = 'threecol';}
		if ($size == 'three_quarter') { $size = 'ninecol';}
		
		if ($clearfix){
		 		 return '<div class="' . $size . $position.'">'. do_shortcode( $content ) .'</div>'. $clearfix;
		} else {
				 return '<div class="' . $size . $position.'">'. do_shortcode( $content ).'</div>';	
		}
	}
	
	add_shortcode('column', 'column_shortcode');
	
	// Dropcap Shortcode
	function dropcap_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
		  'size' => 'normal',
		  'text' => '',
		  ), $atts ) );
		  
		return '<span class="'.$size.'">' .  $content  . '</span>';
	}
	add_shortcode('dropcap', 'dropcap_shortcode');
	
	// Video Embed Shortcode
	function embedvideo_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
		  'id' => '',
		  'website' => '',
		  ), $atts ) );
		 if ($website == 'youtube'){ 
			return '<div class="cb-video-frame"><iframe width="600" height="330" src="http://www.youtube.com/embed/'.$id.'" frameborder="0" allowfullscreen></iframe></div>';
		 } else{
		 	return '<div class="cb-video-frame"><iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
		 }
	}
	add_shortcode('embedvideo', 'embedvideo_shortcode');
	
	// Alert Shortcode
	function alert_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
		  'type' => '',
		  ), $atts ) );
		

		return '<div class="' . $type . '">' . $content . '</div>';
	}
	add_shortcode('alert', 'alert_shortcode');
	
	
	// Highlight Shortcode
	function highlight_shortcode( $atts, $content = null ) {
		
		  extract( shortcode_atts( array(
		  'color' => '',
		  'text' => '',
		  ), $atts ) );
		  
		if ($color){
			return '<span class="cb-highlight" style="background-color:'.$color.'">' .  $content . '</span>';
		}else{
			return '<span class="cb-highlight user-bg">' . $content  .'</span>';
		}
	}
	add_shortcode('highlight', 'highlight_shortcode');
	
	// Divider Shortcode
	function divider_shortcode( $atts, $content = null ) {
		
		  extract( shortcode_atts( array(
		  'text' => '',
		  ), $atts ) );
		  
			return '<div class="cb-divider clearfix"><span>' .  $content . '</span></div>';
	}
	add_shortcode('divider', 'divider_shortcode');	
	
	
	// Toggler Shortcode
	function toggler_shortcode( $atts, $content = null ) {
	 extract( shortcode_atts( array(
		  'title' => 'Secret Text',
		  'text' => '',
		  ), $atts ) );
		return '<h4 class="cb-toggler"><a href="#" class="toggle">'.$title.'</a></h4><div class="toggle-content">'. do_shortcode( $content ).'</div>';
	 }
	 add_shortcode('toggler', 'toggler_shortcode');
	
	
	// Tabs Shortcode
	function tab_group( $atts, $content ){
		$GLOBALS['tab_count'] = 0;
		
		do_shortcode( $content );
		
		if( is_array( $GLOBALS['tabs'] ) ){
		$int = '1';
		foreach( $GLOBALS['tabs'] as $tab ){
		$tabs[] = '<li><a href="#">'.$tab['title'].'</a></li>';
		$panes[] ='<span>'.$tab['content'].'</span>';
		$int++;
		}
		$return = '<ul class="tabs clearfix">'.implode( $tabs ).'</ul><div class="panes">'.implode( $panes ).'</div>';
		}
		return $return;
	}
	add_shortcode( 'tabgroup', 'tab_group' );
	
	function tab_shortcode( $atts, $content ){
		extract(shortcode_atts(array(
		'title' => 'Tab %d' 
		), $atts));
		
		$x = $GLOBALS['tab_count'];
		$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' => $content );
		
		$GLOBALS['tab_count']++;
	}
	add_shortcode( 'tab', 'tab_shortcode' );
	
	// Modules Shortcode
	function module_shortcode( $atts, $content = null ) {
		 extract( shortcode_atts( array('category' => '' , 'title' => '', 'amount' => '', 'type' => ''), $atts ) );
	   
		  ob_start(); 
		  $cb_located = locate_template('module-'.$type.'.php', false, false);
		  require $cb_located;
          $cb_output = ob_get_contents(); 
          ob_end_clean(); 
          return $cb_output;  
   
           
	}
	add_shortcode('module', 'module_shortcode');
	
	// registers the buttons for use
	function register_shortcodes($buttons) {
		array_push($buttons, "button",  "toggler", "dropcap", "alert", "highlight",  "module", "tab", "column", "embedvideo", "divider", "videogallery");
		return $buttons;
	}
	
	// filters the tinyMCE buttons and adds our custom buttons
	function shortcode_filter() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
		 
		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			// filter the tinyMCE buttons and add our own
			add_filter("mce_external_plugins", "add_shortcodes");
			add_filter('mce_buttons_3', 'register_shortcodes');
		}
	}
	// init process for button control
	add_action('init', 'shortcode_filter');
	
	// add the button to the tinyMCE bar
	function add_shortcodes($plugin_array) {
	
		$plugin_array['alert'] = get_template_directory_uri() .'/library/extensions/shortcodes/alert-shortcode.js';
		$plugin_array['button'] = get_template_directory_uri() .'/library/extensions/shortcodes/buttons-shortcode.js';
		$plugin_array['column'] = get_template_directory_uri() .'/library/extensions/shortcodes/column-shortcode.js';
		$plugin_array['divider'] = get_template_directory_uri() .'/library/extensions/shortcodes/divider-shortcode.js';
		$plugin_array['dropcap'] = get_template_directory_uri() .'/library/extensions/shortcodes/dropcap-shortcode.js';
		$plugin_array['embedvideo'] = get_template_directory_uri() .'/library/extensions/shortcodes/video-shortcode.js';
		$plugin_array['highlight'] = get_template_directory_uri() .'/library/extensions/shortcodes/highlight-shortcode.js';
		$plugin_array['module'] = get_template_directory_uri() .'/library/extensions/shortcodes/module-shortcode.js';
		$plugin_array['tab'] = get_template_directory_uri() .'/library/extensions/shortcodes/tab-shortcode.js';
		$plugin_array['toggler'] = get_template_directory_uri() .'/library/extensions/shortcodes/toggler-shortcode.js';
		$plugin_array['videogallery'] = get_template_directory_uri() .'/library/extensions/shortcodes/videogallery-shortcode.js';
		
		return $plugin_array;
	}
?>