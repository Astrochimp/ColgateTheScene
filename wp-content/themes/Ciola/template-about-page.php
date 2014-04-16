<?php /* Template Name: About Us */

	  get_header(); 
	  $cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right');
?>

	<div id="cb-content" class="wrap clearfix">
	    <div id="main" class="<?php if ($cb_sidebar_position !== 'cb_sidebar_right'){echo 'left-sidebar ';} ?>entry-content cb-about-page clearfix" role="main">
       
        <h1><?php echo the_title(); ?></h1>
         
<?php 				
		while (have_posts()) : the_post(); 

			  the_content(); 
		  
		endwhile; 

		cb_contributors(); 
?>
	    </div> <!-- end #main -->

	    <?php get_sidebar(); ?>
	    
	</div> <!-- end #cb-inner-content -->
    
            
<?php get_footer(); ?>
