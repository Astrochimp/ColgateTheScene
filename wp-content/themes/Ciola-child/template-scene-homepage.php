<?php
/*
Template Name: Scene Home Page
*/
?>

<?php 
	get_header(); 
	$cb_category_style = ot_get_option('cb_category_style', 'style-a');
?>
			
<div id="cb-content-custom-grid" class="wrap clearfix">
	<?php get_template_part('module-full-grid-3');?>
    
    <!--<div id="main" class="entry-content clearfix" role="main">-->
    <div id="main" class="cb-full-width clearfix" role="main">

         <section class="entry-content" itemprop="articleBody">
             <?php while (have_posts()) : the_post(); ?>
                 <?php the_content(); ?>
              <?php endwhile; ?>
         </section> <!-- end article section -->
   
    </div> <!-- end #main -->

    
</div> <!-- end #cb-content -->
    

<?php get_footer(); ?>