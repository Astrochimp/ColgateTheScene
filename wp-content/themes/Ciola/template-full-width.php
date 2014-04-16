<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>
			
<div id="cb-content" class="wrap clearfix">

    <div id="main" class="cb-full-width entry-content" role="main">
    
		 <header class="article-header">
     		 <h1><?php echo the_title(); ?></h1>
    	 </header> 
         <!-- end article header -->
         
         <section class="entry-content" itemprop="articleBody">
             <?php while (have_posts()) : the_post(); ?>
                 <?php the_content(); ?>
              <?php endwhile; ?>
         </section> <!-- end article section -->
   
    </div> <!-- end #main -->

    
</div> <!-- end #cb-content -->
    

<?php get_footer(); ?>