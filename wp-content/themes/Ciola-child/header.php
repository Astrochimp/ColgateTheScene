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
<!DOCTYPE html>
<!--blogsites.colgate.edu-->
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
		
<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_directory'); ?>/public/img/favicon3.ico">
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<link href='//fonts.googleapis.com/css?family=Open+Sans:300normal,300italic,400normal,400italic,600normal,600italic,700normal,700italic,800normal,800italic|Roboto:400normal|Oswald:400normal|Lato:400normal|Lato:400normal|Droid+Sans:400normal|Source+Sans+Pro:400normal|Open+Sans+Condensed:300normal|Montserrat:400normal|PT+Sans:400normal|Raleway:400normal&subset=all' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:200normal,200italic,300normal,300italic,400normal,400italic,600normal,600italic,700normal,700italic,900normal,900italic|Lato:400normal|Open+Sans:400normal|Roboto:400normal|Gloria+Hallelujah:400normal|Droid+Sans:400normal|PT+Sans:400normal|Raleway:400normal|Ubuntu:400normal|PT+Serif:400normal|Cabin:400normal&subset=all' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/library/header-footer/grid.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/library/header-footer/header-footer-style.css" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


  <script src="//code.jquery.com/jquery-1.10.2.js"></script>

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/library/css/colorbox.css">
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="/wp-content/themes/Ciola/library/js/modal.js"></script>



<?php wp_head(); ?>
</head>
<body>

<!--*****************************************************-->
<!-- Google Tag Manager -->
<!--*****************************************************-->

<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TH7959"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TH7959');</script>

<!--*****************************************************-->
<!-- End of Google Tag Manager -->
<!--*****************************************************-->

<header>
  <div class="container_24">
    <div id="TopNavRedBar">
        <div id="TopNavRedBarSpacer">
            <div id="TopNavRedBarSpacer">
                <span class="audienceTopMenu">
                    <a class="jforTop" href="http://www.colgate.edu" target="_blank">Colgate University Home</a>
                    <a class="jforTop" href="http://www.colgate.edu/alumni">Alumni Home</a>
                </span>
                <span class="audienceTopMenuMobile">
                    <a class="jforTop" href="http://www.colgate.edu" target="_blank">Colgate University Home</a>
                    <a class="jforTop" href="http://www.colgate.edu/alumni">Alumni Home</a>
              </span>
            </div>
        </div>
    </div>
  </div>
  <div class="container_24 topnav" id="TopBarGrey">
    <div class="grid_14 prefix_1 topnav">
      <div class="Open-Sans-pro">
      	<a class="colgate_u" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
      </div>
      <nav>
        <div class="leftmenu">
          <span id="academics"><a href="<?php bloginfo('url'); ?>">Current Issue</a><br /><img id="academics_img" style="visibility: hidden; margin-top:-18px;" src="<?php bloginfo('template_directory'); ?>/public/img/highlight.png" width="78" height="4" /></span>
          <span id="about_colgate"><a href="#">Departments</a><br /><img id="about_colgate_img" style="visibility: hidden; margin-top:-18px;" src="<?php bloginfo('template_directory'); ?>/public/img/highlight.png" width="101" height="4" /></span>
          <span id="campus_life"><a href="#">Past Issues</a><br /><img id="campus_life_img" style="visibility: hidden; margin-top:-18px;" src="<?php bloginfo('template_directory'); ?>/public/img/highlight.png" width="91" height="4" /></span>
          <span id="distinctly_colgate"><a href="#">About</a><br /><img id="distincly_colgate_img" style="visibility: hidden; margin-top:-18px;" src="<?php bloginfo('template_directory'); ?>/public/img/highlight.png" width="129" height="4" /></span>
        </div>
      </nav>
    </div>
    <div class="grid_4 topnav banner_seal_a" style="">
      <img  src="<?php bloginfo('stylesheet_directory'); ?>/library/header-footer/img/sealr.png" alt="Colgate Seal" id="TopNavSeal" />
    </div>
    <div class="grid_4 topnav suffix_1" style="">
      <!--
      <ul id="TopQuickLinks">
        <li><a href="http://www.colgate.edu/admission-and-financial-aid/apply">APPLY</a></li>
        <li><a href="http://www.colgate.edu/directory">DIRECTORY</a></li>
        <li><a href="http://www.colgate.edu/makeagift">MAKE A GIFT</a></li>
        <li><a href="http://gocolgateraiders.com">RAIDERS SPORTS</a></li>
        <li><a href="http://www.colgate.edu/about/offices-and-services">OFFICES &amp; SERVICES</a></li>
      </ul>
      -->
      <div id="search_area" style="background-color: #d5d5cd; width: 200px; margin-top: 80px;">
        <input type="text" id="search_box" style="width: 180px; background-color: #d5d5cd; border:none; color:#862633; font-family: Arial;" onkeydown="if (event.keyCode == 13) { $('#search_link').click()}" size="50" />
        <a href="http://www.colgate.edu/search" onclick="appendSearch(this)"><img id="search_link" src="<?php bloginfo('stylesheet_directory'); ?>/library/header-footer/img/search_icon.png"/></a>
        <script type="text/javascript">
        function appendSearch(element)
        {
            element.href = "http://www.colgate.edu/search" + "/?q=" + $('#search_box').val();
        }
        </script>
      </div>
    </div>
    <div class="grid_24 menu_bottom_line" style="background-color:#a9a9a7; height:2px; position:relative; top:-8px"></div>
</div>   

</header>
<!--Rollover script for maroon secondary links-->
<script>  
	$("div.enterleave").mouseenter(function() { 
		$("#AboutMenu").css('display', 'block') 
	});

	$("#AboutMenu").mouseleave(function() {   
		$("#AboutMenu").css('display', 'none') 
	});
</script>

<script type="text/javascript">
$(document).ready(function () {
if (window.location.href.indexOf('about_colgate') > 0)
{
	$('#about_colgate_img').css('visibility', 'visible');
}
else if (window.location.href.indexOf('campus_life')  > 0)
{
	$('#campus_life_img').css('visibility', 'visible');
}
else if (window.location.href.indexOf('distinctly_colgate')  > 0)
{
	$('#distincly_colgate_img').css('visibility', 'visible');
}
else if (window.location.href.indexOf('admissions')  > 0)
{
	$('#admissions_img').css('visibility', 'visible');
}
else if (window.location.href.indexOf('academics')  > 0)
{
	$('#academics_img').css('visibility', 'visible');
}
});
</script>

