 <?php /* Module: A 100% width */

		$cat_id = get_category_by_slug($category)->term_id;
		$parent_cat_name = get_category($cat_id)->cat_name;
		$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
    $cb_query = NULL;
    $i = 0 ;
    
    if ( $amount == NULL ) {
      $cb_amount = '12';
    } else { 
      $cb_amount = $amount; 
    }
		
		$cb_args = array( 'cat' => $cat_id,  'post_type' => 'post',  'post_status' => 'publish', 'posts_per_page' => $cb_amount,  'ignore_sticky_posts'=> 1	);
		$cb_query = new WP_Query( $cb_args );
		
		if( $cb_query->have_posts() ) {
			
		  $cb_review_final_score = NULL;
		  $cb_final_score = NULL;
		  echo '<div class="cb-module-a clearfix"><h2 class="cb-module-title">'.$parent_cat_name.'</h2>';
		  
		  while ( $cb_query->have_posts() ) : $cb_query->the_post(); 
		 
		 	// Determine post format
		 	$format = get_post_format(); 	
			$cb_custom_fields = get_post_custom();
			if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off'; }
			if ($cb_review_checkbox == 'on') { $format = 'review'; }
            $cat_com_url = get_comments_link();
             $category_data = NULL;
	
            foreach ( ( get_the_category() ) as $category )  {
                $category_name = $category->cat_name;
                $category_url = get_category_link($category);
                $category_data .= '<span class="cb-category"><a href="'.$category_url.'">'.$category_name.'</a></span>';
            }
				
		$i++;  
		if ( $i == 1 ) { 
?>
              <article class="cb-article-big clearfix" role="article">
                   <div class="mask">
                       <a href="<?php the_permalink(); ?>">
                          <?php if  (has_post_thumbnail()) {
                                  $featured_image = the_post_thumbnail('cb-thumb-350-crop'); 
                                      echo $featured_image[0];
                          } else { 
                                   $thumbnail = get_template_directory_uri().'/library/images/thumbnail-350x200.png'; ?>
                                      <img src="<?php echo $thumbnail; ?>" alt="article thumbnail" />
                          <?php } ?>
                          
                          <?php if ((false != $format) && ($format != 'review')) {echo '<span class="cb-icon '. $format . '-icon"></span>'; } ?>
                       </a>
                   </div>
                    
                   <?php 
                     cb_review_thumbnail(); 
                     echo $category_data;
                     echo cb_comment_line(); 
                   ?>
                    
                    <h3 class="h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    
                    <p><?php if (has_excerpt() == NULL) {echo cb_clean_excerpt(80, false); } else { echo get_the_excerpt();} ?></p>                  
                    
                    
                </article> 
					
<?php		} else { ?>

    				<article class="cb-article-small clearfix" role="article">
                  	 	<div class="mask">
                            <a href="<?php the_permalink();?>">
                                    <?php if  (has_post_thumbnail())  {
                                    $featured_image = the_post_thumbnail('cb-thumb-90-crop'); 
                                        echo $featured_image[0];
                                    } else { 
                                    // if no featured image set backup image
                                     $thumbnail = get_template_directory_uri().'/library/images/thumbnail-90x90.png'; ?>
                                        <img src="<?php echo $thumbnail; ?>" alt="article thumbnail" />
                                    <?php } ; ?> 
                             </a>
                        </div>
                        <?php  
                          echo $category_data;
                          echo cb_comment_line(); 
                        ?>
                         
                        <h3 class="h6"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                         
                        <?php echo cb_byline(NULL, false, false) ?>
                         
    				</article> 
                        
<?php 	} 
		
		endwhile; 

	echo '</div>';

	} // end if have posts
	
	wp_reset_postdata(); 

?>