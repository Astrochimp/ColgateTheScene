<?php 
	get_header(); 
	$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
?>
			
	<div id="cb-content" class="wrap clearfix">
			
                  <?php if (is_front_page()) { 
								$cb_full_feature = ot_get_option('cb_homepage_featured', 'off'); 
								if 	($cb_full_feature == 'full-grid-4' ) { get_template_part('module', $cb_full_feature);} 
								if 	($cb_full_feature == 'full-grid-5' ) { get_template_part('module', $cb_full_feature);} 
								if 	($cb_full_feature == 'full-grid-6' ) { get_template_part('module', $cb_full_feature);} 
								if 	($cb_full_feature == 'full-grid-7' ) { get_template_part('module', $cb_full_feature);} 
								if 	($cb_full_feature == 'full-slider' ) { get_template_part('module', $cb_full_feature); } 
					} ?>    
                    
				 <div id="main" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar ';} ?>entry-content clearfix" role="main">
				 
				 <?php 
				    if (is_front_page()) { $cb_full_feature = ot_get_option('cb_homepage_featured', 'off'); 
                    
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
					
					    <?php endwhile; ?>	
					
					            <?php cb_page_navi(); ?>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    
				    <?php get_sidebar(); ?>
				    
	</div> <!-- end #cb-content -->
    
<?php get_footer(); ?>