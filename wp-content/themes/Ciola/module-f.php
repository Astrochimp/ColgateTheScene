 <?php  /* Module: Slider 100% width - 1 post */

	if (is_category()) { 
			
			$cat_id = get_query_var('cat');
	} else {
		 if (isset($category)) {
			$cat_id = get_category_by_slug($category)->term_id;
         }
            if (!isset($cat_id)) {
                
            $cb_grid_filter = ot_get_option('cb_grid_filter', NULL);
            if ($cb_grid_filter == NULL) {$cat_id = implode(",", get_all_category_ids());  } else { $cat_id = implode(",", $cb_grid_filter); }  
            
            }
	}
    
    if ($amount == '') {$cb_amount = '6';} else { $cb_amount = $amount; }
	
	$cb_featured_qry = array( 'post_type' => 'post', 'cat' => $cat_id, 'meta_key' => 'cb_featured_post', 'posts_per_page' => $cb_amount, 'orderby' => 'date', 'order' => 'DESC',  'post_status' => 'publish', 'meta_value' => 1,  'meta_compare' => '==', 'ignore_sticky_posts' => true);
	   $qry = new WP_Query( $cb_featured_qry );
	   
	if ($qry->post_count == 0) { 
				$qry = NULL;
				$qry = new WP_Query(array( 'posts_per_page' => $cb_amount, 'cat' => $cat_id, 'no_found_rows' => true, 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );
	}

	if ($qry->have_posts()) {
		
	  echo '<div class="cb-module-f clearfix"><div class="flexslider clearfix">
			   <ul class="slides">';
			   
	  while ($qry->have_posts()) {
	  	
	  $qry->the_post(); 

	  $format = get_post_format();
	  $cb_custom_fields = get_post_custom();
	  $cb_review_checkbox = get_post_meta(get_the_id(), "cb_review_checkbox"); 
	  if ($cb_review_checkbox) {$format = 'review'; }
	  
?>
         <li>
             <a href="<?php the_permalink();?>" >   
			 <?php if  (has_post_thumbnail()) {
								$featured_image = the_post_thumbnail('cb-thumb-600-crop'); 
									echo $featured_image[0];
					} else { 
							// if no featured image set backup image
							$thumbnail = get_template_directory_uri().'/library/images/thumbnail-600x350.png'; ?>
							<img src="<?php echo $thumbnail; ?>" alt="thumbnail" />
								<?php } ; ?>
                      <?php if ($format !== false) { ?> <span class="cb-icon <?php echo $format; ?>-icon"></span>  <?php } ?>
               </a>
                                
            <h2 class="h4">
                <a href="<?php the_permalink(); ?>">
                    <?php echo get_the_title(); ?>
                </a>
           </h2>
           
           <div class="cb-excerpt">
                <?php if (has_excerpt() == NULL) {echo cb_clean_excerpt(70, false); } else { echo get_the_excerpt(); } ?>           
          </div> 
                                       
       </li>
<?php  		
			}
		
			echo '</ul></div></div>';
		}
			
		wp_reset_postdata();  // Restore global post data 
?>
		