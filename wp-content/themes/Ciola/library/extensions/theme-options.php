<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'ot_general',
        'title'       => 'General'
      ),
       array(
        'id'          => 'ot_post',
        'title'       => 'Post'
      ),
      array(
        'id'          => 'ot_styling',
        'title'       => 'Styling'
      ),
      array(
        'id'          => 'ot_typography',
        'title'       => 'Typography'
      ),
      array(
        'id'          => 'ot_footer',
        'title'       => 'Footer'
      ),
      array(
        'id'          => 'ot_advertising',
        'title'       => 'Advertisement'
      ),
      array(
        'id'          => 'ot_custom_code',
        'title'       => 'Custom Code'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'cb_logo_url',
        'label'       => 'Logo',
        'desc'        => 'Upload your logo here. Recommended size: 300px x 80px.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_favicon_url',
        'label'       => 'Favicon',
        'desc'        => 'Upload your favicon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_homepage_featured',
        'label'       => 'Homepage Big Slider/Grid Options',
        'desc'        => 'Option to use a full-width slider or full-width grid to show latest posts on the homepage.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'cb_full_off',
            'label'       => 'Off',
            'src'         => ''
          ),
          array(
            'value'       => 'small-slider',
            'label'       => 'Small slider',
            'src'         => ''
          ),
          array(
            'value'       => 'full-slider',
            'label'       => 'Big slider',
            'src'         => ''
          ),
          array(
            'value'       => 'full-grid-3',
            'label'       => 'Grid Style - 3 Articles',
            'src'         => ''
          ),
          array(
            'value'       => 'full-grid-4',
            'label'       => 'Grid Style - 4 Articles',
            'src'         => ''
          ),
          array(
            'value'       => 'full-grid-5',
            'label'       => 'Grid Style - 5 Articles',
            'src'         => ''
          ),
          array(
            'value'       => 'full-grid-6',
            'label'       => 'Grid Style - 6 Articles',
            'src'         => ''
          ),
          array(
            'value'       => 'full-grid-7',
            'label'       => 'Grid Style - 7 Articles',
            'src'         => ''
          )
        ),
      ),
      array(
            'label'       => 'Category Filter for "Homepage Big Slider/Grid" (optional)',
            'id'          => 'cb_grid_filter',
            'type'        => 'category-checkbox',
            'desc'        => '',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'section'     => 'ot_general',
            'class'       => '',
          ),
      array(
        'id'          => 'cb_category_style',
        'label'       => 'Blog Style',
        'desc'        => 'Style to show posts on the front page. (Only applies if you use "your latest posts" in Settings -&gt; reading)',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'style-a',
            'label'       => 'Style A',
            'src'         => ''
          ),
          array(
            'value'       => 'style-b',
            'label'       => 'Style B',
            'src'         => ''
          ),
          array(
            'value'       => 'style-b2',
            'label'       => 'Style B (No sidebar)',
            'src'         => ''
          ),
          array(
            'value'       => 'style-c',
            'label'       => 'Style C',
            'src'         => ''
          ),
          array(
            'value'       => 'style-d',
            'label'       => 'Style D',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_sidebar_position',
        'label'       => 'Sidebar Position',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'cb_sidebar_right',
            'label'       => 'Right Sidebar',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_sidebar_left',
            'label'       => 'Left Sidebar',
            'src'         => ''
          )
        ),
      ),
      
      array(
        'id'          => 'cb_search_in_bar',
        'label'       => 'Search Icon In Navigation Menu',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
	  array(
        'id'          => 'cb_breaking_news',
        'label'       => 'Breaking News',
        'desc'        => 'Display Breaking News in Top Menu.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
            'label'       => 'Category Filter for Breaking News (optional)',
            'id'          => 'cb_breaking_news_filter',
            'type'        => 'category-checkbox',
            'desc'        => '',
            'std'         => '',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'section'     => 'ot_general',
            'class'       => '',
      ),
      array(
        'id'          => 'cb_social_sharing',
        'label'       => 'Social Sharing Bottom Of Post',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_social_sharing_top',
        'label'       => 'Social Sharing Top Of Post',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_author_box_onoff',
        'label'       => 'Show about the author box',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'cb_author_box_on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_author_box_off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_previous_next_onoff',
        'label'       => 'Show Next/Previous in articles',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'cb_previous_next_on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_previous_next_off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_related_onoff',
        'label'       => 'Show related posts',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'cb_related_on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_related_off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
            array(
        'id'          => 'cb_comments_onoff',
        'label'       => 'Comments',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'cb_comments_on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_comments_off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_meta_onoff',
        'label'       => 'Global "By line" (By x on 01/01/01 in category) control',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_meta_onoff_grid',
        'label'       => 'Grids "By line" (Overrides Global "By line" setting)',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_meta_onoff_related',
        'label'       => 'Related Post Block "By line" (Overrides Global "By line" setting)',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_lightbox_onoff',
        'label'       => 'Lightbox',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      
      array(
        'id'          => 'cb_base_color',
        'label'       => 'Base Color',
        'desc'        => 'Color to show on menu, hovers, borders, etc if a page, post, category, etc doesn\'t have their own specific color set.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_background_image',
        'label'       => 'Background Image',
        'desc'        => 'Upload a background image.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_bg_image_setting',
        'label'       => 'Background Image Setting',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => 'Full-width stretch',
            'src'         => ''
          ),
          array(
            'value'       => '2',
            'label'       => 'Repeat',
            'src'         => ''
          ),
          array(
            'value'       => '3',
            'label'       => 'No-repeat',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_background_colour',
        'label'       => 'Background Colour',
        'desc'        => 'Overall background color. (Is overridden by custom background images and colors set for category + posts + etc..)',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_win8_tile_url',
        'label'       => 'Windows 8 Tile Icon',
        'desc'        => 'Upload the .png that you want to be shown when someone pins your website on Windows 8. (Recommended size: 144px x 144px)',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_win8_tile_color',
        'label'       => 'Windows 8 Tile Background Color',
        'desc'        => 'Select the color that will surround your png in the Windows 8 tile.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_header_font',
        'label'       => 'Header Font',
        'desc'        => 'Select the font of the Headers and important titles.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => "'Alegreya SC', serif;",
            'label'       => 'Alegreya SC',
            'src'         => ''
          ),
          array(
            'value'       => "'Arvo', serif;",
            'label'       => 'Arvo',
            'src'         => ''
          ),
          array(
            'value'       => "'Bitter', serif;",
            'label'       => 'Bitter',
            'src'         => ''
          ),
          array(
            'value'       => "'Droid Serif', serif;",
            'label'       => 'Droid Serif',
            'src'         => ''
          ),
          array(
            'value'       => "'Libre Baskerville', serif;",
            'label'       => 'Libre Baskerville',
            'src'         => ''
          ),
          array(
            'value'       => "'Lora', serif;",
            'label'       => 'Lora',
            'src'         => ''
          ),
          array(
            'value'       => "'Noticia Text', serif;",
            'label'       => 'Noticia Text',
            'src'         => ''
          ),
          array(
            'value'       => "'Noto Serif', serif;",
            'label'       => 'Noto Serif',
            'src'         => ''
          ),
          array(
            'value'       => "'Open Sans', sans-serif;",
            'label'       => 'Open Sans',
            'src'         => ''
          ),
          array(
            'value'       => "'PT Sans', sans-serif;",
            'label'       => 'PT Sans',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_user_header_font',
        'label'       => 'Other Header Font ',
        'desc'        => 'Overrides Header Font. Enter any Google Font from http://www.google.com/fonts. Example: \'Playfair Display SC\', serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_body_font',
        'label'       => 'Body Font',
        'desc'        => 'Select the font of the body text.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => "'Arimo', sans-serif;",
            'label'       => 'Arimo',
            'src'         => ''
          ),
          array(
            'value'       => "'Cabin', sans-serif;",
            'label'       => 'Cabin',
            'src'         => ''
          ),
          array(
            'value'       => "'Interstate';",
            'label'       => 'Interstate',
            'src'         => ''
          ),
          array(
            'value'       => "'Istok Web', sans-serif;",
            'label'       => 'Istok Web',
            'src'         => ''
          ),
          array(
            'value'       => "'Open Sans', sans-serif;",
            'label'       => 'Open Sans',
            'src'         => ''
          ),
          array(
            'value'       => "'PT Sans', sans-serif;",
            'label'       => 'PT Sans',
            'src'         => ''
          ),
          array(
            'value'       => "'Raleway', sans-serif;",
            'label'       => 'Raleway',
            'src'         => ''
          ),
          array(
            'value'       => "'Roboto', sans-serif;",
            'label'       => 'Roboto',
            'src'         => ''
          ),
          array(
            'value'       => "'Source Sans Pro', sans-serif;",
            'label'       => 'Source Sans',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_user_body_font',
        'label'       => 'Other Body Font ',
        'desc'        => 'Overrides Body Font. Enter any Google Font from http://www.google.com/fonts. Example: \'Noto Sans\', sans-serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_enable_footer_logo',
        'label'       => 'Footer Logo',
        'desc'        => 'Enable/Disable Footer Logo.',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'false',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_footer_logo',
        'label'       => 'Footer Logo',
        'desc'        => 'Upload your footer logo here. Recommended size: 200px x 80px (png with transparency).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_footer_copyright',
        'label'       => 'Footer Copyright',
        'desc'        => '',
        'std'         => 'Copyright 2013',
        'type'        => 'textarea-simple',
        'section'     => 'ot_footer',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_facebook_url',
        'label'       => 'Facebook URL',
        'desc'        => 'Enter the entire Facebook page URL (example: http://www.facebook.com/pagename)',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_twitter_url',
        'label'       => 'Twitter URL',
        'desc'        => 'Enter your twitter username (example: http://www.twitter.com/username)',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_youtube_url',
        'label'       => 'YouTube URL',
        'desc'        => 'Enter your entire YouTube URL (example: http://www.youtube.com/username)',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_pinterest_url',
        'label'       => 'Pinterest URL',
        'desc'        => 'Enter your entire Pinterest URL (example: http://www.pinterest.com/boardname)',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_rss_url',
        'label'       => 'RSS URL',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_banner_selection',
        'label'       => 'Banner Selection',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'cb_banner_off',
            'label'       => 'Off',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_banner_468',
            'label'       => 'Banner 468x60',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_banner_728',
            'label'       => 'Banner 728x90',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_728_90_banner',
        'label'       => '728x90 Banner',
        'desc'        => 'Enter the code of your 728x90 ad.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_advertising',
        'rows'        => '4',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_468_60_banner',
        'label'       => '468x60 Banner',
        'desc'        => 'Enter the code of your 468x60 ad.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_advertising',
        'rows'        => '4',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_search_box_default',
        'label'       => 'Search Box Placeholder',
        'desc'        => 'Enter the text you wish to appear inside the search box when it isn\'t being used.',
        'std'         => 'Search...',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_google_analytics',
        'label'       => 'Google Analytics',
        'desc'        => 'Load Optimised Google Analytics - Enter your Account ID only, Example: UA-XXXXXXXX-X',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
       array(
        'id'          => 'cb_disqus_shortname',
        'label'       => 'Disqus Forum Shortname',
        'desc'        => 'If you are using Disqus commenting system, you must enter the forum shortname here to be able to show the comment number everywhere.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_contact_google_maps',
        'label'       => 'Google Map Address',
        'desc'        => 'Enter your Google Maps code (For pages that use the "contact page template")',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '5',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_custom_css',
        'label'       => 'Custom CSS',
        'desc'        => '',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'ot_custom_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}