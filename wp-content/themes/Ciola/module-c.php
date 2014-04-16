 <?php /* Module: C 50% width */

	$cat_id = get_category_by_slug($category)->term_id;	
	$main_cat_name = get_category($cat_id)->cat_name;
	$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
	$cb_qry = NULL;
    

	$articlecount = 0;

    if ( $amount == '' ) {
    	$cb_amount = '2';
    } else { 
    	$cb_amount = $amount; 
    }



    ?>



    <?php
    	
	$cb_args = array( 'cat' => $cat_id, 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $cb_amount, 'ignore_sticky_posts'=> 0);
	$cb_qry = new WP_Query($cb_args);
	
	if( $cb_qry->have_posts() ) {
	  $cb_review_final_score = NULL;
	  $cb_final_score = NULL;
	  $category_title = '<div class="cb-newscat-title">'.$main_cat_name.'</div>';


	  echo '<div class="cb-module-c cb-half-mod clearfix">';
	  while ($cb_qry->have_posts()) : $cb_qry->the_post(); 
	  


	  $cat_com_url = get_comments_link();
	
	 foreach ( ( get_the_category() ) as $category ) {
				$category_name = $category->cat_name;
				$category_url = get_category_link($category);
	}
		
	  $cb_custom_fields = get_post_custom();
?>
		
<?php

	  if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
?>				


    <?php 
    	


    	if ($articlecount > 0) {
    		?>
    			<h2 class="h6 cb-extralinks"><a href="<?php echo the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
    		<?php
    	} else {
    ?>
    

    <article class="cb-article clearfix" role="article">
    			<?php echo $category_title ?>
       		    <a href="<?php the_permalink(); ?>">
       		    <?php if  (has_post_thumbnail()) { ?>
					<?php 

								$featured_image = the_post_thumbnail('cb-thumb-350-crop'); 
              			 		echo $featured_image[0];
                      ?>
					<?php }  else { ?> 

					<?php }  ?>                     
                   <span class="cb-shadow"></span>
                   
                </a> 
                    
               <?php if (get_comments_number() > 0) { ?>
                  <a href="<?php echo $cat_com_url; ?>"><span class="cb-comments"><?php echo get_comments_number(); ?></span></a>
               <?php } ?>    
          
                
               
               <?php  if ( $cb_meta_onoff == 'on' ) { ?><p class="cb-byline vcard"><?php printf(__('By <span class="author">%1$s</span>', 'cubell'), get_the_author()); ?></p><?php } ?>
	</article>               
             

             <h2 class="newstitle"><a href="<?php echo the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
<?php  
	  } // check article count.

	  $articlecount++;
	  endwhile; 
?>

	

<?php	  
	  echo '</div>';
}


	wp_reset_postdata(); 
	
	
?>