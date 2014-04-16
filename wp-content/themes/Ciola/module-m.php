 <?php /* Module: Slider 100% width - 3 posts */

 /* 
	Module slider for the photo gallery section
 */

	$cat_id = get_category_by_slug($category)->term_id;
	$main_cat_name = get_category($cat_id)->cat_name;
	if ($amount == '') {$cb_amount = '12';} else { $cb_amount = $amount; }
     
	$args=array( 'cat' => $cat_id, 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $cb_amount,  'ignore_sticky_posts'=> 1);

	$my_query = null;
	$my_query = new WP_Query($args);
	if( $my_query->have_posts() ) {
	  echo '<div class="clearfix"></div>
	  <div class="module-g">
	  		<h2 class="cb-module-title">'.$main_cat_name.'</h2>
	  		<div class="flexslider-g clearfix">
					 <ul class="slides">';
	  while ($my_query->have_posts()) : $my_query->the_post(); 
		
		
		 // Get category meta data
		 foreach( ( get_the_category() ) as $category ) {
					$category_name = $category->cat_name;
					$category_url = get_category_link($category);
				}
		
		$cat_com_url = get_comments_link();

		$large_image_url = "";
		$thumbnail = "";	

		$id = get_the_ID();

		if  (has_post_thumbnail()) 	{
			 $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'large');
			 $thumbnail = $large_image_url[0];
		
        } else { 
          	  $thumbnail = get_template_directory_uri().'/library/images/thumbnail-380x380.png'; 
        }  
?>


           <li> 
           		<a href="<?php  echo $thumbnail; ?>" class="photogallerypics">
           			<?php the_post_thumbnail('cb-thumb-380-crop');?>	
                </a> 
               
               
                <h2 class="h6">
                	<a href="<?php the_permalink(); ?>">
                    	<?php echo get_the_title(); ?>
                    </a>
               </h2>
			</li> 
 
<?php  
	endwhile; 	
	
	echo '</ul></div></div>';
	}
	
	wp_reset_postdata();  
	
	
?>