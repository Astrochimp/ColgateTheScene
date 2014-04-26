<?php
/*
Template Name: New Scene Home Page
*/
?>
<?php 
	get_header(); 
	$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
?>
			
	<div id="cb-content-custom-grid" class="wrap clearfix">
				  <?php get_template_part('module-full-grid-3');?>
			
                    
				     <!--<div id="main" class="cb-full-width clearfix" role="main">-->

				    <?php
				     if(!is_front_page() ) {
					?>
					
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                        
                     <?php } ?>
					<div id="mainwide" class="entry-content clearfix">

						    <section class="entry-content clearfix">
							    <?php echo do_shortcode('[module type=g category="People" amount="12" ]'); ?>
                    
							</section> <!-- end article section -->
					</div>	    					
                	<?php if(!is_front_page() ) { ?>
				   	 </article> <!-- end article -->
                    <?php } ?>


					<div id="main" class="<?php //if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar ';} ?>entry-content clearfix" role="main">

					<h2 class="cb-module-title">News Digest</h2>
				 
				 <?php 
				    if (is_front_page()) { 

				      $cb_full_feature = ot_get_option('cb_homepage_featured', 'off'); 
                    
				      if  ($cb_full_feature == 'small-slider' ) {
				           get_template_part('module', 'f'); 
                      } 
				    }

					if(!is_front_page() ) { ?><h1><?php the_title(); ?></h1><?php } ?> 						

					<?php 
						if (have_posts()) : while (have_posts()) : the_post();
						
						if(!is_front_page() ) {
					?>
					
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                        
                     <?php } ?>
					
						    <section class="entry-content clearfix">
                            
							    <?php the_content(); ?>
                    
						    </section> <!-- end article section -->
						    					
                    	<?php if(!is_front_page() ) { ?>
					   	 </article> <!-- end article -->
                        <?php } ?>
					


	    	


                       <div>
                       	


                       </div> 	


					    <?php endwhile; ?>	
					
					            <?php cb_page_navi(); ?>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    
				    <?php get_sidebar(); ?>
				    
	<p>
	&nbsp;
	</p>
	<br clear="all">

			<!-- 
				
				New photo gallery section using a new module page specifically for photos.
				Section uses the jquery.colorbox-min.js and modal.js files.

			-->
			<div class="clearfix" id="photogallery">

							<div  class="entry-content clearfix">

								    <section class="entry-content clearfix">
									    <?php echo do_shortcode('[module type=m category="Photos" amount="5" ]'); ?>
		                    
									</section> 
							</div>

			</div>


   
	</div> <!-- end #cb-content -->
<?php get_footer(); ?>