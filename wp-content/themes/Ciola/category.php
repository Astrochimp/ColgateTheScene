<?php 
		
		get_header(); 
		
		$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
		$cat_id = get_query_var('cat');
		$cb_category_style = get_tax_meta($cat_id, 'cb_cat_style_field_id');
		$cb_featured_option = get_tax_meta($cat_id, 'cb_cat_featured_op');
		$cb_desc_option = get_tax_meta($cat_id, 'cb_cat_description');
		if ($cb_category_style == '') {$cb_category_style = 'style-a';}
		
		$cb_cat_desc = category_description( $cat_id ); 
		
		

?>
			
<div id="cb-content" class="wrap clearfix">
     
    <?php 
				if 	($cb_featured_option == 'full-grid-3' ) { get_template_part('module', $cb_featured_option);} 
				if 	($cb_featured_option == 'full-grid-4' ) { get_template_part('module', $cb_featured_option);} 
				if 	($cb_featured_option == 'full-grid-5' ) { get_template_part('module', $cb_featured_option);} 
				if 	($cb_featured_option == 'full-grid-6' ) { get_template_part('module', $cb_featured_option);} 
				if 	($cb_featured_option == 'full-grid-7' ) { get_template_part('module', $cb_featured_option);} 
				if 	($cb_featured_option == 'full-slider' ) { get_template_part('module', $cb_featured_option);} 
	 ?>    
     
    <div id="<?php if ($cb_category_style == 'style-b2') {echo 'main-full-width';} else { echo 'main';}?>" class="clearfix<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo ' left-sidebar';} ?>" role="main">
	  
	  <?php 
	  		if ($cb_featured_option == 'slider' ) { get_template_part('module', 'f'); }  
			if ($cb_desc_option == '2') {echo '<h1>'.get_category($cat_id)->name.'</h1><div class="cb_cat_desc">'. $cb_cat_desc .'</div>';}
			
			get_template_part('cat', $cb_category_style);
			
			if ($cb_desc_option == '1') {echo '<div class="cb_cat_desc">'. $cb_cat_desc .'</div>';}
			
		?>

    </div> <!-- /main -->

    <?php if ($cb_category_style != 'style-b2') { get_sidebar();} ?>
    
</div> <!-- end #cb-content -->

<?php get_footer(); ?>