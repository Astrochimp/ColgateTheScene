<?php /* Category/Blog Style D */

$i = 0;

if (have_posts()) : while (have_posts()) : the_post(); 

	$format = get_post_format(); 
	
	$cat = get_the_category(); 
	$cat_id = $cat[0]->cat_ID;   
	$cat_url = get_category_link($cat_id);
	$cat_name = $cat[0]->cat_name;
	$cat_com_url = get_comments_link();
	
	$cb_custom_fields = get_post_custom();
	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}
	if ($cb_review_checkbox == 'on') { $format = 'review';}
?>					 

    <article id="post-<?php the_ID(); ?>" class="cb-blog-style-d <?php if ($i % 2 != 0) {echo 'right-half '; } ?>clearfix" role="article">
                            
          <div class="cb-mask"> 
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
          
              <span class="cb-category">
               <a href="<?php echo $cat_url; ?>">
                   <?php echo $cat_name; ?>
                </a>
             </span>
             
            <?php 
            echo cb_comment_line(); 
            ?>
             
          </div>
          <div class="cb-meta">
                
             <a href="<?php the_permalink(); ?>"></a>
         
             <h2 class="h6">
                    <?php the_title(); ?>
              </h2> 
              
              <div class="cb-excerpt">
                 <?php echo cb_clean_excerpt(70, false); ?>
              </div> 
                                                      
          </div>					
                               
    </article> <!-- end article -->

<?php
    $i++;     
    endwhile; 	
?>
     <div class="clearfix"></div>    
					
<?php 
      cb_page_navi();                    
    endif; 
?>