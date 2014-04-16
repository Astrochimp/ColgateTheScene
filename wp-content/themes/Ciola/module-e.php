 <?php /* Module: Slider 100% width */

	$cat_id = get_category_by_slug($category)->term_id;
	$main_cat_name = get_category($cat_id)->cat_name;
	if ($amount == '') {$cb_amount = '12';} else { $cb_amount = $amount; }
    
	$args=array( 'cat' => $cat_id, 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $cb_amount, 'ignore_sticky_posts'=> 1);

	$my_query = null;
	$my_query = new WP_Query($args);
	if( $my_query->have_posts() ) {
	  echo '<div class="clearfix"></div>
		  <div class="module-e">
	  		<h2 class="cb-module-title">'.$main_cat_name.'</h2>
	 		 <div class="flexslider-e clearfix">
					 <ul class="slides">';
	  while ($my_query->have_posts()) : $my_query->the_post(); 
		
		
		 // Get category meta data
		 foreach( ( get_the_category() ) as $category ) 
				{
					$category_name = $category->cat_name;
					$category_url = get_category_link($category);
				}
?>
             <li>
       		    <a href="<?php the_permalink(); ?>">
					<?php if  (has_post_thumbnail()) 
					{
						$featured_image = the_post_thumbnail('cb-thumb-350-crop'); 
              			 echo $featured_image[0];
						
                    } else { 
                     	$thumbnail = get_template_directory_uri().'/library/images/thumbnail-350x200.png'; ?>
                        <img src="<?php echo $thumbnail; ?>" alt="thumbnail">
                    <?php } ; ?>
                </a> 
                
               <span class="cb-category"><a href="<?php echo $category_url; ?>"><?php echo $category_name; ?></a></span>
               
                <?php echo cb_comment_line(); ?>  
          
                <h2 class="h6"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
              	<a href="<?php the_permalink(); ?>" class="overlay"></a>
			</li> 
 
<?php  
	endwhile; 	
	echo '</ul></div></div>';
	}
	
	wp_reset_postdata();  
	
	
?>