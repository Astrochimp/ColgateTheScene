<?php 
        $cb_sidebar_position = ot_get_option('cb_sidebar_position', 'cb_sidebar_right'); 
        $cb_sidebar_id = NULL;
        
        if ( is_category() ) {
            $cb_cat_id = get_query_var( 'cat' );
            $cb_cat = get_category($cb_cat_id);
            $cb_cat_name = sanitize_title( $cb_cat->cat_name );
            
            $cb_sidebar_id =  $cb_cat_name . '-sidebar';
        } elseif ( is_page() ) {
            $cb_page_id = get_the_id();   
            $cb_sidebar_id = 'page-'. $cb_page_id .'-sidebar';  
        } elseif ( is_single() ) {
            
            $cb_cat = get_the_category( $post->ID );
            $cb_cat_name = sanitize_title( $cb_cat[0]->cat_name );
            
            $cb_sidebar_id =  $cb_cat_name . '-sidebar';
        }
?>	
		
<div id="cb-sidebar" class="clearfix" role="complementary">

<?php
            if (is_active_sidebar($cb_sidebar_id) == true) {
                 
                        dynamic_sidebar( $cb_sidebar_id );
                
            } elseif ( is_active_sidebar( 'sidebar-1' ) ) {
                 
                        dynamic_sidebar( 'sidebar-1' );
            } 
?>
			

</div>