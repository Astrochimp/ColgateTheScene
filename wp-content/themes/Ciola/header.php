<?php 
	// Get theme options
	$cb_logo = ot_get_option('cb_logo_url', false);
	$cb_banner_selection = ot_get_option('cb_banner_selection', 'off');
	$cb_728_banner = ot_get_option('cb_728_90_banner', false);
	$cb_468_banner = ot_get_option('cb_468_60_banner', false);
    $cb_breaking_news = ot_get_option('cb_breaking_news', 'on');
    $cb_breaking_filter = ot_get_option('cb_breaking_news_filter', NULL);
    
    if ($cb_breaking_filter == NULL) {$cb_breaking_cat = implode(",", get_all_category_ids());  } else { $cb_breaking_cat = implode(",", $cb_breaking_filter); }    
	if ($post != NULL) {$cb_custom_fields = get_post_custom();
	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}} else {$cb_review_checkbox = NULL;}
    
    $cb_breaking_args = array( 'post_type' => 'post', 'numberposts' => '6', 'category' => $cb_breaking_cat, 'post_status' => 'publish', 'suppress_filters' => false);
    $cb_news_posts = wp_get_recent_posts( $cb_breaking_args);  
    $cb_news = NULL;
    
    foreach( $cb_news_posts as $news ){
        $cb_news .= '<li><a href="' . get_permalink($news["ID"]) . '" title="Look '.esc_attr($news["post_title"]).'" >' .   $news["post_title"].'</a> </li> ';
    }
?>
<!doctype html>  

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	
	<head>
		<meta charset="UTF-8">
		
		<title><?php wp_title('-', true, 'right'); ?></title>
		
		<!-- Google Chrome Frame for IE -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
		
		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>	

        <!-- load favicon + windows 8 tile icon -->
        <?php cb_load_icons(); ?>
        
  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		<!-- Holding main menu -->
		<?php  if ( has_nav_menu( 'main' ) ) { 
					$cb_main_menu = wp_nav_menu(
						array(
							'echo'           => FALSE, 
					    	'container_class' => 'cb-main-menu',
					    	'theme_location' => 'main',                    
					        'depth' => 0,                                   
							'walker' => new CB_Walker,									
							'items_wrap' => '<ul class="nav main-nav clearfix sf-menu">%3$s</ul>',
							)); 
				}
		?>
        
		<!-- Load head functions -->
		<?php wp_head(); ?>

		
	</head>
	
	<body <?php body_class(); ?>>
		<div id="cb-container" <?php if ($cb_review_checkbox == 'on') { echo 'itemprop="review" itemscope itemtype="http://schema.org/Review"'; }?>>
			
			<header class="cb-header" role="banner">
				
            	<?php if (($cb_breaking_news == 'on') || ( has_nav_menu( 'top' ) )) { ?>
                	<!-- Top Menu -->            
	                <section id="cb-top-menu" class="wrap clearfix">
	                
	                    <?php if ($cb_breaking_news == 'on') { ?>
	                    	 <div class="cb-breaking-news">
	                        		<span><?php echo __('Breaking', 'cubell') ?>: </span> 
	                         		<ul>
	                        			<?php echo $cb_news; ?>
	                        		</ul>
	                   		 </div>
	                    <?php } ?>
	                    <?php if ( has_nav_menu( 'top' ) ) { ?>
	                    
	                    		<div id="cb-mob-dropdown-top"></div>
	                    		
	                            <div id="cb-top-menu-nav"><?php top_nav(); ?></div>
	                            
	                            <div id="cb-top-menu-mob"><?php top_nav(); ?></div>
	                                 
	                    <?php } ?>
	                    
	              </section> 
	              <!-- /Top Menu -->  
              <?php } ?>
                
              <div id="cb-inner-header" class="wrap clearfix">
                    
              
              <?php if ($cb_logo !== false) { ?>
                 <!-- Logo -->
                  <div id="logo">
                      <a href="<?php echo home_url();?>">
                          <img src="<?php echo $cb_logo; ?>" alt="<?php bloginfo('name');?> logo" />
                     </a>
                  </div>
                  <!-- /Logo -->
              <?php } ?>
                    
               <?php  // Show appropriate banner if set
                      if ($cb_banner_selection == 'cb_banner_468') { 
                           if ($cb_468_banner !== NULL) { 
                                  echo  '<div class="cb-banner468">'.$cb_468_banner.'</div>';
                              } 
                      } elseif ($cb_banner_selection == 'cb_banner_728') {
                              if ($cb_728_banner !== NULL)  {
                                   echo  '<div class="cb-banner728">'.$cb_728_banner.'</div>';
                              }
                      } 
                  ?>
                
          <span class="cb-to-top"></span>
          
          </div> <!-- end #cb-inner-header -->
          
         <nav role="navigation">
         			
                     <div id="cb-main-menu" class="wrap clearfix"><?php if ( has_nav_menu( 'main' ) ) { echo $cb_main_menu; } ?> </div>
                     <div id="cb-main-menu-mob" class="wrap clearfix"><div id="cb-mob-dropdown-main"></div><?php if ( has_nav_menu( 'main' ) ) {  main_nav(); } ?></div>

         </nav>
      </header> <!-- end header -->