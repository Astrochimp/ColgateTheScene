<?php 
/**
 * Ciola Social Media widget
 */
 class cb_social_media_icons_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'cb-social-media-widget clearfix', 'description' =>  "Social media icon widget" );
		parent::__construct('social-media-icons', 'Ciola Social Media Icons', $widget_ops);
		$this->alt_option_name = 'widget_social_media';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_social_media', 'widget');

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

		$facebook = apply_filters('widget_title', empty($instance['facebook']) ? '' : $instance['facebook'], $instance, $this->id_base);
		$twitter = apply_filters('widget_title', empty($instance['twitter']) ? '' : $instance['twitter'], $instance, $this->id_base);
		$pinterest = apply_filters('widget_title', empty($instance['pinterest']) ? '' : $instance['pinterest'], $instance, $this->id_base);
        $youtube = apply_filters('widget_title', empty($instance['youtube']) ? '' : $instance['youtube'], $instance, $this->id_base);
        $googleplus = apply_filters('widget_title', empty($instance['googleplus']) ? '' : $instance['googleplus'], $instance, $this->id_base);
		$rss = apply_filters('widget_title', empty($instance['rss']) ? '' : $instance['rss'], $instance, $this->id_base);
		
?>
		<?php echo $before_widget; 
		$i = 0;
		?>
		
		<?php if ($rss != '') {$i++; ?><a href="<?php echo $rss;?>" target="_blank"><span class="cb-social-media-icon rss icon-<?php echo $i; ?>"></span></a><?php } ?>
		<?php if ($twitter != '') {$i++; ?><a href="<?php echo $twitter;?>" target="_blank"><span class="cb-social-media-icon twitter icon-<?php echo $i; ?>"></span></a><?php } ?>	
		<?php if ($facebook != '') {$i++; ?><a href="<?php echo $facebook;?>" target="_blank"><span class="cb-social-media-icon facebook icon-<?php echo $i; ?>"></span></a><?php } ?>
        <?php if ($pinterest != '') {$i++; ?><a href="<?php echo $pinterest;?>" target="_blank"><span class="cb-social-media-icon pinterest icon-<?php echo $i; ?>"></span></a><?php } ?>
        <?php if ($youtube != '') {$i++; ?><a href="<?php echo $youtube;?>" target="_blank"><span class="cb-social-media-icon youtube icon-<?php echo $i; ?>"></span></a><?php } ?>
        <?php if ($googleplus != '') {$i++; ?><a href="<?php echo $googleplus;?>" target="_blank"><span class="cb-social-media-icon googleplus icon-<?php echo $i; ?>"></span></a><?php } ?>
		

    <?php echo $after_widget; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();


		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_social_media', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['facebook'] = strip_tags($new_instance['facebook']);
		$instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['pinterest'] = strip_tags($new_instance['pinterest']);
        $instance['youtube'] = strip_tags($new_instance['youtube']);
        $instance['googleplus'] = strip_tags($new_instance['googleplus']);
		$instance['rss'] = strip_tags($new_instance['rss']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_social_media']) )
			delete_option('widget_social_media');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$facebook     = isset( $instance['facebook'] ) ? esc_attr( $instance['facebook'] ) : '';
		$twitter     = isset( $instance['twitter'] ) ? esc_attr( $instance['twitter'] ) : '';
		$pinterest     = isset( $instance['pinterest'] ) ? esc_attr( $instance['pinterest'] ) : '';
        $youtube     = isset( $instance['youtube'] ) ? esc_attr( $instance['youtube'] ) : '';
        $googleplus     = isset( $instance['googleplus'] ) ? esc_attr( $instance['googleplus'] ) : '';
		$rss     = isset( $instance['rss'] ) ? esc_attr( $instance['rss'] ) : '';
?>
		<p><label for="<?php echo $this->get_field_id( 'twitter' ); ?>">Twitter URL:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo $twitter; ?>" /></p>
        
		<p><label for="<?php echo $this->get_field_id( 'facebook' ); ?>">Facebook URL:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo $facebook; ?>" /></p>
        
		<p><label for="<?php echo $this->get_field_id( 'pinterest' ); ?>">Pinterest URL:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" type="text" value="<?php echo $pinterest; ?>" /></p>        
		
		<p><label for="<?php echo $this->get_field_id( 'youtube' ); ?>">YouTube URL:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo $youtube; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'googleplus' ); ?>">Google Plus URL:</label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'googleplus' ); ?>" name="<?php echo $this->get_field_name( 'googleplus' ); ?>" type="text" value="<?php echo $googleplus; ?>" /></p>
        
		<p><label for="<?php echo $this->get_field_id( 'rss' ); ?>">RSS URL:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" type="text" value="<?php echo $rss; ?>" /></p> 
               
	
     <?php
	}
}
function cb_social_media_widget ()
{
 register_widget( 'cb_social_media_icons_widget' );
}
 add_action( 'widgets_init', 'cb_social_media_widget' );
?>