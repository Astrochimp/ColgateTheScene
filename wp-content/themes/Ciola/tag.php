<?php get_header(); 
$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
 ?>

<div id="cb-content" class="wrap clearfix">

    <div id="main" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar';} ?>  clearfix" role="main">

		    <h1 class="archive-title">
			    <span><?php _e("Tagged:", "cubell"); ?></span> <?php single_tag_title(); ?>
		    </h1>

	   	<?php if (have_posts()) { 
	
							get_template_part('cat', 'style-a');
			 } ?>

	</div> <!-- end #main -->

	<?php get_sidebar(); ?>

</div> <!-- end #cb-content -->

<?php get_footer(); ?>