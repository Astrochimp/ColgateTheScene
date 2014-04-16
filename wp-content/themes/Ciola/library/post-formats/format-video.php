 <?php
	 /* Post Format: Video */
	$cb_custom_fields = get_post_custom();
	if (isset($cb_custom_fields['cb_video_embed_code_post'][0])) { $cb_featured_video_url = $cb_custom_fields['cb_video_embed_code_post']; }
	if (isset($cb_custom_fields['cb_review_checkbox'][0])) { $cb_review_checkbox = 'on'; } else { $cb_review_checkbox = 'off';}

	$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on'); 
	
	foreach( ( get_the_category() ) as $category ) 
		{
			$category_name = $category->cat_name;
			$category_url = get_category_link($category);
			$cat_com_url = get_comments_link();
		}
?>
           <header class="article-header small-featured">
               <h1 class="cb-entry-title cb-single-title<?php if ($cb_review_checkbox == 'on') { echo ' entry-title';}?>" <?php if ($cb_review_checkbox == 'on') { echo 'itemprop="itemReviewed"';} else {echo 'itemprop="headline"';}?>><?php the_title(); ?></h1>  						
               <?php  if ($cb_meta_onoff == 'on') { ?><p class="cb-byline vcard"><?php printf(__('By <span class="author" itemprop="author">%1$s</span> on <time class="updated" datetime="%2$s" pubdate>%3$s</time>', 'cubell'), cb_get_the_author_posts_link(), get_the_time('Y-m-j'), get_the_time(get_option('date_format')) ); ?> <?php echo __( 'in', 'cubell' ); ?> <span class="cb-cat"><a href="<?php echo $category_url; ?>"><?php echo $category_name; ?></a></span></p><?php } ?>
            
	           <?php if (get_comments_number() > 0) { ?>
	           		<a href="<?php echo $cat_com_url; ?>"><p class="cb-comments"><?php echo get_comments_number(); ?></p></a>
			   <?php } ?> 
			   
			   
          </header> <!-- /article header -->
          
<div class="cb-video-frame"><?php if ($cb_featured_video_url !== NULL)  echo $cb_featured_video_url[0];?></div>