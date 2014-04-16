<?php 
	get_header(); 
	$cb_category_style = ot_get_option('cb_category_style', 'style-a');
	$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
?>

<div id="cb-content" class="wrap clearfix">
     
  <?php 
				$cb_full_feature = ot_get_option('cb_homepage_featured', 'off'); 
				if 	($cb_full_feature == 'full-grid-4' ) { get_template_part('module', $cb_full_feature);} 
				if 	($cb_full_feature == 'full-grid-5' ) { get_template_part('module', $cb_full_feature);} 
				if 	($cb_full_feature == 'full-grid-6' ) { get_template_part('module', $cb_full_feature);} 
				if 	($cb_full_feature == 'full-grid-7' ) { get_template_part('module', $cb_full_feature);} 
				if 	($cb_full_feature == 'full-slider' ) { get_template_part('module', $cb_full_feature); } 
	?>  
       	
    <div id="<?php if ($cb_category_style == 'style-b2') {echo 'main-full-width';} else { echo 'main';}?>" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar ';} ?>entry-content clearfix" role="main">
	  
	  <?php 
	                 if  ($cb_full_feature == 'small-slider' ) { get_template_part('module', 'f'); } 
	       	         get_template_part('cat', $cb_category_style);
	  ?>

    </div> <!-- end #main -->

    <?php if ($cb_category_style != 'style-b2') { get_sidebar();} ?>
    
</div> <!-- end #cb-content -->
    
<?php get_footer(); ?>