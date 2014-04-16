 <?php /* Module: H 100% width */

		$cat_id = get_category_by_slug($category)->term_id;
		$parent_cat_name = get_category($cat_id)->cat_name;
		$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
        $cb_query = null;
        if ($amount == '') {$cb_amount = '4';} else { $cb_amount = $amount; }
               
		$args=array(  'cat' => $cat_id, 'post_type' => 'post',  'post_status' => 'publish',	 'posts_per_page' => $cb_amount, 'ignore_sticky_posts'=> 1);
		$cb_query = new WP_Query($args);
		
		if( $cb_query->have_posts() ) {
			
		  $cb_review_final_score = $cb_final_score = NULL;
		  echo '<div class="cb-module-h clearfix"><h2 class="cb-module-title">'.$parent_cat_name.'</h2>';
		  
		  while ($cb_query->have_posts()) : $cb_query->the_post(); 
		  global $post;
		 	// Determine post format
		 	$format = get_post_format(); 	
			$cb_custom_fields = get_post_custom();
			if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off'; }
			if ($cb_review_checkbox == 'on') { $format = 'review'; }
            $cat_com_url = get_comments_link();
             $category_data = NULL;
    
            foreach( ( get_the_category() ) as $category )  {
                $category_name = $category->cat_name;
                $category_url = get_category_link($category);
                $category_data .= '<span class="cb-category"><a href="'.$category_url.'">'.$category_name.'</a></span>';
            }
?>
             <article id="post-<?php the_ID(); ?>" class="cb-blog-style-a clearfix<?php if (is_sticky()) echo ' sticky'; ?>" role="article">

                   <div class="mask">
                        <?php cb_review_thumbnail($post); ?>
                         
                         <a href="<?php the_permalink(); ?>">
                             <?php if ( has_post_thumbnail() ) {
                                    the_post_thumbnail('cb-thumb-220-crop'); 
                             } else {
                                    echo '<img src="'.get_template_directory_uri().'/library/images/thumbnail-220x180.png"  alt="thumbnail">';
                              } ?>
                             <?php if (false !== $format) {echo '<span class="cb-icon '. $format . '-icon"></span>'; } ?>
                         </a>
                  </div>
                        
                  <div class="cb-meta">
                  
                    <?php echo $category_data; ?>
                     
                     <?php if (get_comments_number() > 0) { ?>
                        <a href="<?php echo $cat_com_url; ?>">
                            <span class="cb-comments"><?php echo get_comments_number(); ?></span>
                        </a>
                     <?php } ?>
                     
                     <h2 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
                     
                      <?php  if ($cb_meta_onoff == 'on') { ?><p class="cb-byline vcard"><?php printf(__('By <span class="author">%1$s</span> on <time class="updated" datetime="%2$s" pubdate>%3$s</time>', 'cubell'), cb_get_the_author_posts_link(), get_the_time('Y-m-j'), get_the_time(get_option('date_format')) ); ?></p><?php } ?>
                    
                    <div class="cb-excerpt"><?php if (has_excerpt() == NULL) {echo cb_clean_excerpt(90, true); } else { echo get_the_excerpt();} ?></div>
                  
                  </div>
                  
            </article> <!-- end article -->
<?php
		
		endwhile; 
		
		echo '</div>';
		
	} // end if have posts
		
	wp_reset_postdata(); 
	
?>