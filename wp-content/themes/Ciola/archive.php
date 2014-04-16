<?php get_header(); 
$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
 ?>

<div id="cb-content" class="wrap clearfix">

    <div id="main" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar';} ?>  clearfix" role="main">

	    <?php if (is_day()) { ?>
		    <h1 class="archive-title">
				<span><?php _e("Daily Archives:", "cubell"); ?></span> <?php the_time(get_option('date_format')); ?>
		    </h1>

		<?php } elseif (is_month()) { ?>
		    <h1 class="archive-title">
    	    	<span><?php _e("Monthly Archives:", "cubell"); ?></span> <?php the_time(get_option('date_format')); ?>
	        </h1>
	
	    <?php } elseif (is_year()) { ?>
	        <h1 class="archive-title">
	    	    <span><?php _e("Yearly Archives:", "cubell"); ?></span> <?php the_time(get_option('date_format')); ?>
	        </h1>
	    <?php } ?>

	   	<?php if (have_posts()) { 
	
							get_template_part('cat', 'style-a');
			 } ?>

	</div> <!-- end #main -->

	<?php get_sidebar(); ?>

</div> <!-- end #cb-content -->

<?php get_footer(); ?>