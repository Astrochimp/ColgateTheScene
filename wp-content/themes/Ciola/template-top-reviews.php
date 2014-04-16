<?php /* Template Name: Top Reviews Page */

	$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
	$cb_top_reviews_category = NULL;
	$cb_custom_fields = get_post_custom();
	if (isset($cb_custom_fields['cb_top_reviews_category'][0])) { $cb_top_reviews_category = $cb_custom_fields['cb_top_reviews_category'][0]; }
	if (isset($cb_custom_fields['cb_top_reviews_amount'][0])) { $cb_top_reviews_amount = $cb_custom_fields['cb_top_reviews_amount'][0]; }
	$i = 1;

	get_header(); 
?>    
        <div id="cb-content" class="cb-top-reviews-page wrap clearfix">
        
            <div id="main" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar ';} ?>entry-content clearfix" role="main">
            
         		<h1><?php the_title(); ?></h1>
                
                <?php if (have_posts()) : while (have_posts()) : the_post();
					
					// only echo if there is content
					if($post->post_content != "") {
				?>
						<div class="cb-content"><?php the_content(); ?></div>
						
<?php 				}
										endwhile; 
					 endif; 
				
							$cb_review_final_score = NULL;
							
							$cb_top_reviews_args = array( 'category_name' => $cb_top_reviews_category, 'post_type' => 'post', 'no_found_rows' => true, 'meta_key' => 'cb_final_score', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'posts_per_page' => $cb_top_reviews_amount);
                     	   $cb_top_reviews_query = new WP_Query( $cb_top_reviews_args );
						   
						   // Reverse order of array
							$count_posts = $cb_top_reviews_query->post_count; 
							$count_posts_static = $count_posts; 
							$cb_top_reviews_query = array_reverse($cb_top_reviews_query->get_posts());
							
							foreach( $cb_top_reviews_query as $post ) :	setup_postdata($post); 
							
								// Set up review meta data
								$cb_rating_short_summary = NULL;
								$cb_custom_fields = get_post_custom();							
						
								if (($i == $count_posts_static)) {
?> 
                                  <article id="post-<?php the_ID(); ?>" class="cb-top-reviews cb-one clearfix" role="article">
                                 
                                 		<div class="cb-mask"> 
                                 			
                                            <?php if ( has_post_thumbnail() ) { ?> 
                                            		<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail('cb-thumb-600-crop', '');  ?>
                                                    </a>
                                            <?php } else { ?>
                                                 <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri().'/library/images/thumbnail-600x350.png'; ?>" alt="Review Thumbnail"></a>
                                           	<?php } 
											 
											cb_review_thumbnail(); ?>
                                        </div>
                                        
                                  	     <div class="cb-meta">
                                        	
                                        		<div class="cb-countdown"><a href="<?php the_permalink(); ?>"><?php echo ($count_posts);?></a></div>
                                         
                                                <h2 class="h3"><a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
                                                
                                                <p class="cb-byline vcard"><?php printf(__('By <span class="author">%1$s</span> on <time class="updated" datetime="%2$s" pubdate>%3$s</time>', 'cubell'), get_the_author(), get_the_time('Y-m-j'), get_the_time(get_option('date_format')) ); ?></p>
                                                
                                                <div class="cb-excerpt"><?php echo cb_clean_excerpt(220, true); ?></div> 
                                         </div>
                                                                                   
                                         
                             <?php } else { ?>                                        	
                                    <article id="post-<?php the_ID(); ?>" class="cb-top-reviews cb-others clearfix" role="article">
                                         
                                         <div class="cb-mask">
											  <?php if ( has_post_thumbnail() ) { ?> 
                                                        <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('cb-thumb-220-crop');  ?>
                                                        </a>
                                                <?php } else { ?>
                                                 <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri().'/library/images/thumbnail-220x180.png'; ?>" alt="Review Thumbnail"></a>
                                           	<?php } 

												 cb_review_thumbnail(); ?>

                                         </div>  
                                         <div class="cb-meta">
                                         	
                                         	<div class="cb-countdown"><a href="<?php the_permalink(); ?>"><?php echo ($count_posts);?></a></div>
                                         	
                                            <h2 class="h4"><a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
                                             
                                            <p class="cb-byline vcard"><?php printf(__('By <span class="author">%1$s</span> on <time class="updated" datetime="%2$s" pubdate>%3$s</time>', 'cubell'), get_the_author(), get_the_time('Y-m-j'), get_the_time(get_option('date_format')) ); ?></p>
                                    
                                             <div class="cb-excerpt"><?php echo cb_clean_excerpt(170, true); ?></div> 
                                         </div>

                             <?php } ?>     
                                    </article><!-- /article -->
                                    
                        <?php	
                        $i++;
						$count_posts--;
                        endforeach;
                       wp_reset_postdata();
                    ?>
            </div> <!-- end #main -->

            <?php get_sidebar(); ?>
            
        </div> <!-- end #cb-content -->

<?php get_footer(); ?>
