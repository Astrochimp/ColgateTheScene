 <?php /* Module: Grid - 6 Articles */ 

	$i = 1;
    $cb_meta_onoff_grid = ot_get_option('cb_meta_onoff_grid', 'on'); 
	if ($cb_meta_onoff_grid != 'on') { $cb_no_byline = 'cb-no-byline ';} else {$cb_no_byline = NULL;} 
    $cb_grid_filter = ot_get_option('cb_grid_filter', NULL);
    if ($cb_grid_filter == NULL) {$cb_filtered_cat = implode(",", get_all_category_ids());  } else { $cb_filtered_cat = implode(",", $cb_grid_filter); } 
    
    echo '<div class="cb-grid-6 '.$cb_no_byline.'clearfix">';
	
	if (is_category()) { 
			
			$current_cat_id = get_query_var('cat');
	
			$cb_featured_qry = array( 'post_type' => 'post', 'meta_key' => 'cb_featured_post', 'cat' => $current_cat_id, 'posts_per_page' => '6', 'orderby' => 'date', 'order' => 'DESC',  'post_status' => 'publish', 'meta_value' => 1,  'meta_compare' => '==', 'ignore_sticky_posts' => true );
			$qry = new WP_Query( $cb_featured_qry );
		   
			if ($qry->post_count == 0) { 
				$qry = NULL;
				$qry = new WP_Query(array( 'posts_per_page' => '6', 'no_found_rows' => true, 'post_type' => 'post', 'cat' => $current_cat_id, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );
			}
	
    } else { 
			 $cb_featured_qry = array( 'post_type' => 'post', 'meta_key' => 'cb_featured_post', 'posts_per_page' => '6', 'cat' => $cb_filtered_cat, 'orderby' => 'date', 'order' => 'DESC',  'post_status' => 'publish', 'meta_value' => 1,  'meta_compare' => '==', 'ignore_sticky_posts' => true );
			$qry = new WP_Query( $cb_featured_qry );
			   
			if ($qry->post_count == 0) { 
					$qry = NULL;
					$qry = new WP_Query(array( 'posts_per_page' => '6', 'no_found_rows' => true, 'post_type' => 'post','cat' => $cb_filtered_cat, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );
			}
	}
	

	if ($qry->have_posts()) :
		
	while ( $qry->have_posts() ) : $qry->the_post(); 
			  $format = get_post_format();
			  $cb_custom_fields = get_post_custom();
			  $cb_review_checkbox = get_post_meta(get_the_id(), "cb_review_checkbox"); 
			  if ($cb_review_checkbox) {$format = 'review'; }
			  
			  $feature_size = "cb-thumb-380-crop" ;
			  if ($i == 1) { $feature_size = "cb-thumb-600-crop"; }
			  if (($i == 5) || ($i == 6))  { $feature_size = "cb-thumb-350-crop"; }
			  
			   	 // Get category meta data
			 foreach( ( get_the_category() ) as $category ) 
			 		{
						$category_name = $category->cat_name;
						$category_url = get_category_link($category);
						$cat_com_url = get_comments_link();
					}
?>

     <div class="feature no-<?php echo $i; ?> <?php if ($i == 1) {echo 'big-article';} elseif (($i == 5) || ($i == 6)) {echo 'small-article'; } else {echo 'square-article';} ?>">
                        
            <?php if  (has_post_thumbnail()) {
            	 	
            	$featured_image = the_post_thumbnail($feature_size); 
                echo $featured_image[0];
			
            } else {
            	 
			  if ($i == 1) { $thumbnail = get_template_directory_uri().'/library/images/thumbnail-600x350.png'; }
			  elseif (($i == 5) || ($i == 6))  { $thumbnail = get_template_directory_uri().'/library/images/thumbnail-350x200.png';}
			  else  {$thumbnail = get_template_directory_uri().'/library/images/thumbnail-380x380.png'; } ?>
               <img src="<?php echo $thumbnail; ?>" alt="thumbnail" >
                
           <?php } ?>   
                              
		   <?php echo cb_comment_line(); ?>                       
                    
            <h2 class="h4"><a href="<?php the_permalink() ?>"><?php echo get_the_title(); ?></a></h2>
             
             <?php  if ($cb_meta_onoff_grid == 'on') { ?><div class="cb-byline"><?php echo __('By', 'cubell'); echo ' '.get_the_author()?></div><?php } ?>
            
            <span class="cb-shadow"></span>
             
              <?php if ($i == 1) { ?>
           			  <div class="cb-excerpt"><?php if (has_excerpt() == NULL) {echo cb_clean_excerpt(150, false); } else { echo get_the_excerpt();} ?></div>  
              <?php } elseif (($i !== 5) && ($i !== 6)) { ?>
          			   <div class="cb-excerpt"><?php if (has_excerpt() == NULL) {echo cb_clean_excerpt(65, false); } else { echo get_the_excerpt();} ?></div>  
             <?php } ?>
         
         <a href="<?php the_permalink() ?>" class="grid-overlay"></a> 
     </div> 
            
<?php  
	
	$i++;
	
		endwhile; 
	endif;
			
	wp_reset_postdata();  // Restore global post data 
?>

</div>