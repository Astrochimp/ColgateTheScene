<?php 
	get_header();
	$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
?>

<div id="cb-content" class="wrap clearfix">

 <div id="main" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar';} ?>  clearfix" role="main">
	
    <h1 class="archive-title"><span><?php _e('Search Results for:', 'cubell'); ?></span> <span class="cb-search-term">"<?php echo esc_attr(get_search_query()); ?>"</span></h1>
	<?php if (have_posts()) { 
	
							get_template_part('cat', 'style-a');
	
		} else { ?>
	
		    <article id="post-not-found" class="hentry clearfix">
		    		<h2><?php _e('Sorry, nothing found.', 'cubell'); ?></h2>
                
		    	<section class="entry-content">
                <img src="<?php echo get_template_directory_uri();?>/library/images/404-cloud.png" class="cloud-404" alt="<?php bloginfo('name');?> 404"/>
		    		<p><?php _e('Please try searching for it again with different keywords.', 'cubell'); ?></p>
		    	</section>
		    	<footer class="article-footer">
		    	    <p><?php get_search_form(); ?></p>
		    	</footer>
		    </article>
	
	    <?php } ?>

    </div> <!-- end #main -->

    <?php get_sidebar(); ?>

</div> <!-- end #cb-content -->

            
<?php get_footer(); ?>