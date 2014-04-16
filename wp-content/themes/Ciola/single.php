<?php 
	get_header();
	$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
	$cb_author_box_onoff = ot_get_option('cb_author_box_onoff', 'on'); 
	$cb_previous_next_onoff = ot_get_option('cb_previous_next_onoff', 'on'); 
	$cb_related_onoff = ot_get_option('cb_related_onoff', 'on'); 
    $cb_social_sharing = ot_get_option('cb_social_sharing', 'on'); 
    $cb_social_sharing_top = ot_get_option('cb_social_sharing_top', 'on'); 
	$cb_comments_onoff = ot_get_option('cb_comments_onoff', 'on'); 
	$cb_format = get_post_format();
	
	$cb_custom_fields = get_post_custom();
	if (isset($cb_custom_fields['cb_full_width_post'][0])) {$cb_full_width_post = $cb_custom_fields['cb_full_width_post'][0];} else {$cb_full_width_post = NULL;}
	if (isset($cb_custom_fields['cb_featured_image_settings_post'][0])) {$cb_featured_image_settings = $cb_custom_fields['cb_featured_image_settings_post'][0]; } else {$cb_featured_image_settings = 'Normal';}
	
	// Pull review meta data
	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
	// Start the loop
	if (have_posts()) : while (have_posts()) : the_post(); 

		if ( ( !$cb_format ) && ( $cb_featured_image_settings == "Full-BG with Void" ) ) { cb_featured_full_bg($post); }
	
        if ( (!$cb_format) && ( $cb_featured_image_settings == "Cover Image" ) ) { cb_featured_cover_image($post); }
?>	
                      
		<div id="cb-content" class="wrap clearfix">
                  
		  <?php  if ((!$cb_format) && ($cb_featured_image_settings == "Full-Width")) cb_featured_full_width($post); ?>
                

            <div id="<?php if ($cb_full_width_post == 1) { echo 'main-full-width'; } else {echo 'main';}?>" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar ';} ?>clearfix" role="main">
                      
              <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" <?php if ($cb_review_checkbox != 'on') { echo 'itemscope itemtype="http://schema.org/BlogPosting"';} ?>>
                    
					<?php if ((!$cb_format) && (($cb_featured_image_settings == "Normal") || ($cb_featured_image_settings == "no-featured-images"))) cb_featured_normal($post); ?>
                    
                    <section class="entry-content clearfix" <?php if ($cb_review_checkbox != 'on') { echo 'itemprop="articleBody"'; } ?> >

                     <?php if ((false === $cb_format) && ($cb_featured_image_settings == "Normal") && ($post->post_type != 'attachment')) { 
							 	echo '<div class="cb-featured-image">';
											if ( has_post_thumbnail() ) {
												
												   the_post_thumbnail('cb-thumb-600-crop'); 
												   
											} else {
												
												 echo '<img src="'.get_template_directory_uri().'/library/images/thumbnail-600x350.png" alt="thumbnail">';
											} 
								echo '</div>';		 
                     		} else { 
							
								get_template_part('library/post-formats/format-'.$cb_format, $cb_format); 
							} 
						if ($cb_social_sharing_top != 'off') { echo cb_social_sharing($post); }
                       // Display Score Box - Top post (If enabled)
                   		cb_review_top($post);
?>                                                                        
                       <?php if ($cb_review_checkbox == 'on') echo '<span itemprop="reviewBody">'; ?>
                              <?php the_content(); ?>
                       <?php if ($cb_review_checkbox == 'on') echo '</span>'; ?>
                         
                      </section> <!-- /article section -->
              
                      <footer class="cb-article-footer">
                      
                      <?php 
						  
						  // Score Box - Bottom of post (If enabled)
						  cb_review_bottom($post); 
                          
						  //wp_link_pages
						  wp_link_pages('before=<div class="cb-wp-link-pages clearfix"><p><span class="wp-link-pages-title">'. __('Pages:', 'cubell').'</span>&after=</p></div>&next_or_number=number&pagelink=<span class="wp-link-pages-number">%</span>');
                          
						  // Tags
						  the_tags('<p class="tags clearfix"><span class="tags-title">' . __('Tags', 'cubell') . '</span>', '', '</p>'); 
                          
                          //Social Sharing
                          if ($cb_social_sharing != 'off') { echo cb_social_sharing($post); }
                          
						  // Previous/Next navigation
						 if (($cb_previous_next_onoff != 'cb_previous_next_off') && ($post->post_type != 'attachment')) { cb_previous_next_links(); }
						 
						  // Author block
						  if ($cb_author_box_onoff != 'cb_author_box_off') {cb_about_author($post); }
						  						 
						  // Related Posts
						  if ($cb_related_onoff != 'cb_related_off') { cb_related_posts(); }
						  				  
					  ?>
                          
                      </footer> <!-- /article footer -->
          
                      <?php
						  // Comments
						  if ($cb_comments_onoff == 'cb_comments_on') { comments_template(); }
					  ?>
          
                  </article> <!-- /article -->
          
              <?php endwhile; ?>			
          
              <?php endif; ?>
    
           </div> <!-- /#main -->

     	 <?php if ($cb_full_width_post != '1') get_sidebar(); ?>

        </div> <!-- /#cb-content -->


<?php get_footer(); ?>