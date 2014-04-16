<?php 
		get_header(); 
		$cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
?>
			
<div id="cb-content" class="wrap clearfix">

    <div id="main" class="<?php if ($cb_sidebar_position == 'cb_sidebar_left'){echo 'left-sidebar';} ?>  clearfix" role="main">

		<?php cb_author_page(); ?>
		<!-- /Author Box -->
        
		<h2 class="cb-module-title"><?php echo __( 'Latest', 'cubell' ); ?></h2>
        
        <?php get_template_part('cat', 'style-b');?>	

	</div> <!-- end #main -->

	<?php get_sidebar(); ?>

</div> <!-- end #cb-inner-content -->
                
<?php get_footer(); ?>