 <?php  
		 $cb_enable_footer_logo = ot_get_option('cb_enable_footer_logo', false); 
		 $cb_footer_logo = ot_get_option('cb_footer_logo', false); 
		 $cb_footer_copyright = ot_get_option('cb_footer_copyright', false);
 ?>	
    		<footer class="cb-footer wrap" role="contentinfo">
			
				<div id="cb-footer-inner" class="clearfix">
                    
                    <?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
                        <div class="cb-footer-widget clearfix first">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php } ?>
                    <?php if ( is_active_sidebar( 'footer-2' ) ) { ?>
                        <div class="cb-footer-widget clearfix">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php } ?>
                    <?php if ( is_active_sidebar( 'footer-3' ) ) { ?>
                        <div class="cb-footer-widget clearfix">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php } ?>
                    <?php if ( is_active_sidebar( 'footer-4' ) ) { ?>
                        <div class="cb-footer-widget clearfix">
                            <?php dynamic_sidebar('footer-4'); ?>
                        </div>
                    <?php } ?>
                        
                </div>
                 
                <div class="cb-footer-lower clearfix">
                                    
                <?php if ( ( $cb_enable_footer_logo == false ) && ( $cb_footer_logo != false ) ) {
                                    echo '<div class="logo"> <a class="cb-footer-logo" href="'. home_url() .'"><img src="'. $cb_footer_logo .'" alt="logo"></a></div>';
                        } 
                ?>
                
                <?php cb_social_media_footer(); ?>
                    
				<nav role="navigation"><?php footer_nav(); ?></nav>
					
					<?php if ($cb_footer_copyright != false) { ?> 
					    <div class="cb-copyright"><?php echo $cb_footer_copyright; ?></div>
					<?php } ?>
   					 
				</div>
				
			</footer> <!-- end footer -->
			
		</div> <!-- end #cb-container -->
		
		<?php wp_footer(); ?>

	</body>

</html> <!-- End. What a ride! -->