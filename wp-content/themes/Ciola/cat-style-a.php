<?php /* Category/Blog Style A */

if (have_posts()) : while (have_posts()) : the_post(); 

	$format = get_post_format(); 
	$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on'); 
	
	$category_data = NULL;
		
	foreach( ( get_the_category() ) as $category ) 	{
			$category_name = $category->cat_name;
			$category_url = get_category_link($category);
			$category_data .= '<span class="cb-category"><a href="'.$category_url.'">'.$category_name.'</a></span>';
			}
	$cat_com_url = get_comments_link();
	
	$cb_custom_fields = get_post_custom();
	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
	if ($cb_review_checkbox == 'on') { $format = 'review'; }

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
  
  	<?php 
        echo $category_data;
        echo cb_comment_line(); 
    ?>
     
     <h2 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
   	 
   	<?php echo cb_byline(NULL, false, false) ?>
    
    <div class="cb-excerpt"><?php if (has_excerpt() == NULL) {echo cb_clean_excerpt(90, true); } else { echo get_the_excerpt();} ?></div>
  
  </div>
  
</article> <!-- end article -->

<?php endwhile; ?>	
					
	<?php cb_page_navi(); ?>
    
<?php endif; ?>