<?php /* Template Name: Contact Page */
	
	$cb_contact_google_maps = ot_get_option('cb_contact_google_maps', false);
	$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
	
	 get_header(); 
?>
				    
<div id="cb-content" class="wrap clearfix">

    <div id="main" class="<?php if ($cb_sidebar_position !== 'cb_sidebar_right'){echo 'left-sidebar ';} ?>entry-content cb-contact-page clearfix" role="main">
        
        <h1 class="page-title"><?php the_title(); ?></h1>
        
        <?php if ($cb_contact_google_maps !== false) { echo '<div class="google-maps-frame clearfix">'.$cb_contact_google_maps.'</div>';} ?>
        
					<?php if (have_posts()) : ?>
					
					<?php while (have_posts()) : the_post(); ?>
						<?php the_content(); ?>
					  
		<?php endwhile; endif; ?>
		
	</div> <!-- end #main -->

	<?php get_sidebar(); ?>
		    
</div> <!-- end #cb-content -->	
    
			
<?php get_footer(); ?>