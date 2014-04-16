<?php 
		get_header(); 
		$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
?>
	
	<div id="cb-content" class="wrap clearfix">
	  
		<div id="main" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar';} ?>  clearfix" role="main">

	
			<article id="post-not-found" class="hentry clearfix">
	      
	            <h1><?php _e("404 - Not Found, Oops!", "cubell"); ?></h1>
	              
				<section class="entry-content">
				
					<p class="page-404"><?php _e("The page you were looking for was not found. Please try searching for it again with different keywords.", "cubell"); ?></p>
	                <img src="<?php echo get_template_directory_uri();?>/library/images/404-cloud.png" class="cloud-404" alt="<?php bloginfo('name');?> 404"/>
		
				</section> <!-- end article section -->
	
				<section class="search">
	
				    <p><?php get_search_form(); ?></p>
	
				</section> <!-- end search section -->
					
			</article> <!-- end article -->
	
		</div> <!-- end #main -->
		
		<?php get_sidebar(); ?>
		
	</div> <!-- end #cb-content -->
    
<?php get_footer(); ?>
