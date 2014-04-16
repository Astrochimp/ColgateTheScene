 <?php  /* Module: Slider Full */  
 
     $cb_grid_filter = ot_get_option('cb_grid_filter', NULL);
     if ($cb_grid_filter == NULL) {$cb_filtered_cat = implode(",", get_all_category_ids());  } else { $cb_filtered_cat = implode(",", $cb_grid_filter); } 
?>
 
<div class="flexslider-full clearfix">
      <ul class="slides">                              
<?php
	if (is_category()) { 
			
			$current_cat_id = get_query_var('cat');
	
			$cb_featured_qry = array( 'post_type' => 'post', 'meta_key' => 'cb_featured_post', 'cat' => $current_cat_id, 'posts_per_page' => '6', 'orderby' => 'date', 'order' => 'DESC',  'post_status' => 'publish', 'meta_value' => 1,  'meta_compare' => '==', 'ignore_sticky_posts' => true);
			$qry = new WP_Query( $cb_featured_qry );
		   
			if ($qry->post_count == 0) { 
				$qry = NULL;
				$qry = new WP_Query(array( 'posts_per_page' => '6', 'no_found_rows' => true, 'post_type' => 'post', 'cat' => $current_cat_id, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );
			}
	
    } else { 
			 $cb_featured_qry = array( 'post_type' => 'post', 'meta_key' => 'cb_featured_post', 'posts_per_page' => '6', 'cat' => $cb_filtered_cat, 'orderby' => 'date', 'order' => 'DESC',  'post_status' => 'publish', 'meta_value' => 1,  'meta_compare' => '==', 'ignore_sticky_posts' => true);
			$qry = new WP_Query( $cb_featured_qry );
			   
			if ($qry->post_count == 0) { 
					$qry = NULL;
					$qry = new WP_Query(array( 'posts_per_page' => '6', 'no_found_rows' => true, 'post_type' => 'post', 'cat' => $cb_filtered_cat, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );
			}
	}

	if ($qry->have_posts()) :

			while ( $qry->have_posts() ) : $qry->the_post(); 
		
			  $cb_custom_fields = get_post_custom();
?>
 			 <li>
                <a href="<?php the_permalink(); ?>">
					<?php if  (has_post_thumbnail()) {
						
						 $featured_image = the_post_thumbnail('cb-thumb-1020-crop'); 
                         echo $featured_image[0];
						 
                    } else { 
                     	$thumbnail = get_template_directory_uri().'/library/images/thumbnail-1020x500.png'; ?>
                        <img src="<?php echo $thumbnail; ?>" alt="thumbnail">
                    <?php } ; ?>
                    
                </a>     
                 
                <h2 class="h3"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
               
               <div class="cb-excerpt"><?php if (has_excerpt() == NULL) {echo cb_clean_excerpt(100, false); } else { echo get_the_excerpt();} ?></div> 
               
            </li> 
<?php  		
			endwhile; 
		endif;
			
		wp_reset_postdata();  // Restore global post data 
?>
            
      </ul>
</div>				    