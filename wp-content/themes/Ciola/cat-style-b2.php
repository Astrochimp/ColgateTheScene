<?php /* Blog Style B2 */

	$i = 1; 
	
	if (have_posts()) : while (have_posts()) : the_post(); 
	
	$format = get_post_format(); 
	$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on'); 
	 
    $category_data = NULL;
       
    foreach( ( get_the_category() ) as $category )  {
            $category_name = $category->cat_name;
            $category_url = get_category_link($category);
            $category_data .= '<span class="cb-category"><a href="'.$category_url.'">'.$category_name.'</a></span>';
    }     
	  
	$cb_custom_fields = get_post_custom();
	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off'; }
	if ($cb_review_checkbox == 'on') { $format = 'review'; }
	$j = $i / 3;
?>					  

    <article id="post-<?php the_ID(); ?>" class="cb-blog-style-b <?php  if (is_int($j)) {echo 'right-half '; } ?>clearfix<?php if (is_sticky()) echo ' sticky'; ?>" role="article">
   		<div class="mask"> 
        	<?php cb_review_thumbnail($post); ?>                        
            <a href="<?php the_permalink(); ?>">
                <?php 
                if ( has_post_thumbnail() ) {
                      the_post_thumbnail('cb-thumb-350-crop'); 
                  } else {
                      echo '<img src="'.get_template_directory_uri().'/library/images/thumbnail-350x200.png" alt="related post">';
                } 
                ?>
               <?php if (false !== $format) {echo '<span class="cb-icon '. $format . '-icon"></span>'; } ?>
             </a>
        </div>
        
        <?php 
          echo $category_data;
          echo cb_comment_line(); 
        ?>
                
        <h2 class="h4">
        	<a href="<?php the_permalink(); ?>">
          	  <?php the_title(); ?>
            </a>
        </h2> 
        
        <?php echo cb_byline(NULL, false, false) ?>
        
        <div class="cb-excerpt">
            <?php echo cb_clean_excerpt(150, true); ?>
        </div> 
                        
        <div class="cb-bottom-white"></div>
    </article> <!-- end article -->
    <?php  if (is_int($j)) {echo ' <div class="clearfix"></div>  '; } ?>
    
<?php
    $i++;     
    endwhile; 	
?>
     <div class="clearfix"></div>    
<?php 
      cb_page_navi();                    
    endif; 
?>