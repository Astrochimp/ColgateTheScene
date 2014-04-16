<?php 
/**
 * Ciola Tabs Widget
 */
 class CB_WP_Widget_tabs extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'cb-tabs-widget', 'description' =>  "Show multiple widgets in one widget." );
		parent::__construct('tabs', 'Ciola Tabs Widget', $widget_ops);
		$this->alt_option_name = 'widget_tabs';
	}

	function widget($args, $instance) {
		ob_start();
		extract($args);

		 echo $before_widget; 
		 	 if  (is_active_sidebar('cb_tabs') ) { ?>
		<div class="tabber">
     	  <?php dynamic_sidebar('cb_tabs'); ?>
		</div>
        
        <?php }
		
		echo $after_widget;
	
	}

	function form( $instance ) {
		
		echo '<p>Now you must add widgets in the "Ciola Tabs" sidebar below, and whatever you put there, will show here.</p>';    
	
	}
}
function cb_tabs_loader ()
{
 register_widget( 'CB_WP_widget_tabs' );
}
 add_action( 'widgets_init', 'cb_tabs_loader' );
 
?>