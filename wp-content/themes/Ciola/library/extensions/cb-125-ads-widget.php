<?php  /* 125 Ads - Ciola Widget */

 class cb_wp_125_ads_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'ads-125-widget clearfix', 'description' =>  "Show up to six 125px x 125px ads" );
		parent::__construct('ads-125', 'Ciola 125px x 125px Ads', $widget_ops);
		$this->alt_option_name = 'widget_125_ads';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_125_ads', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
		ob_start();
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Ads' : $instance['title'], $instance, $this->id_base);
		$ad_url_1 = apply_filters('ad_url_1', empty($instance['ad_url_1']) ? '' : $instance['ad_url_1'], $instance, $this->id_base);
		$ad_img_1 = apply_filters('ad_img_1', empty($instance['ad_img_1']) ? '' : $instance['ad_img_1'], $instance, $this->id_base);
		$ad_url_2 = apply_filters('ad_url_2', empty($instance['ad_url_2']) ? '' : $instance['ad_url_2'], $instance, $this->id_base);
		$ad_img_2 = apply_filters('ad_img_2', empty($instance['ad_img_2']) ? '' : $instance['ad_img_2'], $instance, $this->id_base);
		$ad_url_3 = apply_filters('ad_url_3', empty($instance['ad_url_3']) ? '' : $instance['ad_url_3'], $instance, $this->id_base);
		$ad_img_3 = apply_filters('ad_img_3', empty($instance['ad_img_3']) ? '' : $instance['ad_img_3'], $instance, $this->id_base);
		$ad_url_4 = apply_filters('ad_url_4', empty($instance['ad_url_4']) ? '' : $instance['ad_url_4'], $instance, $this->id_base);
		$ad_img_4 = apply_filters('ad_img_4', empty($instance['ad_img_4']) ? '' : $instance['ad_img_4'], $instance, $this->id_base);
		$ad_url_5 = apply_filters('ad_url_5', empty($instance['ad_url_5']) ? '' : $instance['ad_url_5'], $instance, $this->id_base);
		$ad_img_5 = apply_filters('ad_img_5', empty($instance['ad_img_5']) ? '' : $instance['ad_img_5'], $instance, $this->id_base);
		$ad_url_6 = apply_filters('ad_url_6', empty($instance['ad_url_6']) ? '' : $instance['ad_url_6'], $instance, $this->id_base);
		$ad_img_6 = apply_filters('ad_img_6', empty($instance['ad_img_6']) ? '' : $instance['ad_img_6'], $instance, $this->id_base);
		$ads = array();
		
		if(($ad_url_1) && ($ad_img_1)) {
            $ads[] = array ( 'ad_img' => $ad_img_1, 'ad_url' => $ad_url_1 );
        }	
		if(($ad_url_2 && $ad_img_2)) {
            $ads[] = array ( 'ad_img' => $ad_img_2, 'ad_url' => $ad_url_2 );
        }	
		if(($ad_url_3 && $ad_img_3)) {
            $ads[] = array ( 'ad_img' => $ad_img_3, 'ad_url' => $ad_url_3 );
        }	
		if(($ad_url_4 && $ad_img_4)) {
            $ads[] = array ( 'ad_img' => $ad_img_4, 'ad_url' => $ad_url_4 );
        }	
		if(($ad_url_5 && $ad_img_5)) {
            $ads[] = array ( 'ad_img' => $ad_img_5, 'ad_url' => $ad_url_5 );
        }	
		if(($ad_url_6 && $ad_img_6)) {
            $ads[] = array ( 'ad_img' => $ad_img_6, 'ad_url' => $ad_url_6 );
        }	
		
		
		
			


		echo $before_widget; 
		
		if ( $title ) echo $before_title . $title . $after_title; 

		$i = 1;
		if ($ads != NULL){
			foreach ($ads as $ad) 
				{
?>
					<a href="<?php echo $ad['ad_url']; ?>" target="_blank" >
						<img src="<?php echo $ad['ad_img']; ?>" height="125" width="125" alt="125" />
					</a>
<?php
					$i++;
				}
		}

		echo $after_widget; 
		
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_125_ads', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['ad_url_1'] = strip_tags($new_instance['ad_url_1']);
		$instance['ad_img_1'] = strip_tags($new_instance['ad_img_1']);
		$instance['ad_url_2'] = strip_tags($new_instance['ad_url_2']);
		$instance['ad_img_2'] = strip_tags($new_instance['ad_img_2']);
		$instance['ad_url_3'] = strip_tags($new_instance['ad_url_3']);
		$instance['ad_img_3'] = strip_tags($new_instance['ad_img_3']);
		$instance['ad_url_4'] = strip_tags($new_instance['ad_url_4']);
		$instance['ad_img_4'] = strip_tags($new_instance['ad_img_4']);
		$instance['ad_url_5'] = strip_tags($new_instance['ad_url_5']);
		$instance['ad_img_5'] = strip_tags($new_instance['ad_img_5']);
		$instance['ad_url_6'] = strip_tags($new_instance['ad_url_6']);
		$instance['ad_img_6'] = strip_tags($new_instance['ad_img_6']);		
		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_125_ads']) )
			delete_option('widget_125_ads');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_125_ads', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$ad_url_1    = isset( $instance['ad_url_1'] ) ? esc_attr( $instance['ad_url_1'] ) : '';
		$ad_img_1    = isset( $instance['ad_img_1'] ) ? esc_attr( $instance['ad_img_1'] ) : '';
		$ad_url_2    = isset( $instance['ad_url_2'] ) ? esc_attr( $instance['ad_url_2'] ) : '';
		$ad_img_2    = isset( $instance['ad_img_2'] ) ? esc_attr( $instance['ad_img_2'] ) : '';
		$ad_url_3    = isset( $instance['ad_url_3'] ) ? esc_attr( $instance['ad_url_3'] ) : '';
		$ad_img_3    = isset( $instance['ad_img_3'] ) ? esc_attr( $instance['ad_img_3'] ) : '';
		$ad_url_4    = isset( $instance['ad_url_4'] ) ? esc_attr( $instance['ad_url_4'] ) : '';
		$ad_img_4    = isset( $instance['ad_img_4'] ) ? esc_attr( $instance['ad_img_4'] ) : '';
		$ad_url_5    = isset( $instance['ad_url_5'] ) ? esc_attr( $instance['ad_url_5'] ) : '';
		$ad_img_5    = isset( $instance['ad_img_5'] ) ? esc_attr( $instance['ad_img_5'] ) : '';
		$ad_url_6    = isset( $instance['ad_url_6'] ) ? esc_attr( $instance['ad_url_6'] ) : '';
		$ad_img_6    = isset( $instance['ad_img_6'] ) ? esc_attr( $instance['ad_img_6'] ) : '';										

?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'ad_img_1' ); ?>">Ad 1: Image url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_img_1' ); ?>" name="<?php echo $this->get_field_name( 'ad_img_1' ); ?>" type="text" value="<?php echo $ad_img_1; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_url_1' ); ?>">Ad 1: Link url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_1' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_1' ); ?>" type="text" value="<?php echo $ad_url_1; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_img_2' ); ?>">Ad 2: Image url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_img_2' ); ?>" name="<?php echo $this->get_field_name( 'ad_img_2' ); ?>" type="text" value="<?php echo $ad_img_2; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_url_2' ); ?>">Ad 2: Link url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_2' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_2' ); ?>" type="text" value="<?php echo $ad_url_2; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_img_3' ); ?>">Ad 3: Image url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_img_3' ); ?>" name="<?php echo $this->get_field_name( 'ad_img_3' ); ?>" type="text" value="<?php echo $ad_img_3; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_url_3' ); ?>">Ad 3: Link url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_3' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_3' ); ?>" type="text" value="<?php echo $ad_url_3; ?>" size="3" /></p>
        
       	<p><label for="<?php echo $this->get_field_id( 'ad_img_4' ); ?>">Ad 4: Image url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_img_4' ); ?>" name="<?php echo $this->get_field_name( 'ad_img_4' ); ?>" type="text" value="<?php echo $ad_img_4; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_url_4' ); ?>">Ad 4: Link url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_4' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_4' ); ?>" type="text" value="<?php echo $ad_url_4; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_img_5' ); ?>">Ad 5: Image url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_img_5' ); ?>" name="<?php echo $this->get_field_name( 'ad_img_5' ); ?>" type="text" value="<?php echo $ad_img_5; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_url_5' ); ?>">Ad 5: Link url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_5' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_5' ); ?>" type="text" value="<?php echo $ad_url_5; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_img_6' ); ?>">Ad 6: Image url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_img_6' ); ?>" name="<?php echo $this->get_field_name( 'ad_img_6' ); ?>" type="text" value="<?php echo $ad_img_6; ?>" size="3" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'ad_url_6' ); ?>">Ad 6: Link url</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_6' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_6' ); ?>" type="text" value="<?php echo $ad_url_6; ?>" size="3" /></p>

     
<?php
	}
}

function cb_125_ads_loader () { register_widget( 'cb_wp_125_ads_widget' ); }

add_action( 'widgets_init', 'cb_125_ads_loader' );
?>