 <?php /* Module: D 50% width */
		
		$cb_cat_id = get_category_by_slug($category)->term_id;
		$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
		$cb_main_cat_name = get_category($cb_cat_id)->cat_name;
        if ($amount == '') {$cb_amount = '5';} else { $cb_amount = $amount; }
        
		$args=array(  'cat' => $cb_cat_id,  'post_type' => 'post',  'post_status' => 'publish',  'posts_per_page' => $cb_amount,  'ignore_sticky_posts'=> 1	);

		$cb_query = null;
		$cb_query = new WP_Query($args);
		if( $cb_query->have_posts() )	{
					
		  echo '<div class="cb-module-d cb-half-mod"><h2 class="cb-module-title">'. $cb_main_cat_name .'</h2>';
		  
		  while ($cb_query->have_posts()) : $cb_query->the_post(); 
			
           $cat_com_url = get_comments_link();
          $category_data = NULL;
    
            foreach( ( get_the_category() ) as $category )  {
                $category_name = $category->cat_name;
                $category_url = get_category_link($category);
                $category_data .= '<span class="cb-category"><a href="'.$category_url.'">'.$category_name.'</a></span>';
            }
?>
              <article class="text-article clearfix" role="article">
                       
                <?php  
                    echo $category_data;
                    echo cb_comment_line(); 
                 ?>
                 
                 <h2 class="h6"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                  
                 <?php if ( $cb_meta_onoff == 'on' ) { ?><p class="cb-byline vcard"><?php printf(__('By <span class="author">%1$s</span>', 'cubell'), get_the_author()); ?></p><?php } ?>
                        
               </article> 
                       
<?php 
		  endwhile; 
		  
	echo '</div>';		  
	   }
	
	wp_reset_postdata(); 
	 
	
	
?>