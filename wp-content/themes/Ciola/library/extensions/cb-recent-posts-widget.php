<?php 
/**
 * Ciola Recent Posts
 */
 class CB_WP_Widget_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'latest-article-widget', 'description' =>  "Shows the latest posts on your site with a thumbnail." );
		parent::__construct('ciola-recent-posts', 'Ciola Latest Posts', $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');

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
        
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'cubell') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) { $number = 5; }
        $category = apply_filters('widget_category', empty($instance['category']) ? '' : $instance['category'], $instance, $this->id_base);
        if ($category != 'cb-all') { $cb_cat_qry = $category;} else {$cb_cat_qry = NULL;}

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'category_name' => $cb_cat_qry, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
        <?php $format = get_post_format();
				$cb_custom_fields = get_post_custom();
				$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
				$cb_review_checkbox = get_post_meta(get_the_id(), "cb_review_checkbox"); 
				if ($cb_review_checkbox) {$format = 'false'; }
		 ?>
            <li class="latest-entry clearfix">
                <a href="<?php the_permalink() ?>" class="cb-thumbnail" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>">
					<?php if  (has_post_thumbnail()) 
					{
						$featured_image = the_post_thumbnail('cb-thumb-90-crop'); 
              			 echo $featured_image[0];
                    } else { 
                    // if no featured image set backup image
                     $thumbnail = get_template_directory_uri().'/library/images/thumbnail-90x90.png'; ?>
                        <img src="<?php echo $thumbnail; ?>" alt="thumbnail">
                    <?php } ; ?>  
                    <span class="cb-icon <?php if (false == $format) { echo 'standard';} else { echo $format;} ?>-icon"></span>
                     <?php cb_review_widget_thumbnail(); ?>
                </a>      
                <h4 class="h6"><a href="<?php the_permalink() ?>"><?php echo get_the_title(); ?></a></h4>	
                 <?php  if ($cb_meta_onoff == 'on') { ?><p class="cb-byline"><?php printf(__('By <span class="author">%1$s</span> on <time class="updated" datetime="%2$s">%3$s</time>', 'cubell'), get_the_author(), get_the_time('Y-m-j'), get_the_time(get_option('date_format')) );?></p><?php } ?>
            </li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = strip_tags($new_instance['category']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
	    $category     = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
    	$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
        $cb_cats = get_categories();
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'cubell'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' , 'cubell'); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php  echo "Category:"; ?></label>
        <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
        <option value="cb-all" <?php if ($category == 'all') echo 'selected="selected"'; ?>>All Categories</option> 
        <?php foreach ($cb_cats as $cat) {
                if ($category == $cat->slug) {$selected = 'selected="selected"'; } else { $selected = NULL;}
                echo '<option value="'.$cat->slug.'" '.$selected.'>'.$cat->name.' ('.$cat->count.')</option>';
                
          } ?>
        </select></p>

     
<?php
	}
}
function cb_recent_posts_loader ()
{
 register_widget( 'CB_WP_Widget_Recent_Posts' );
}
 add_action( 'widgets_init', 'cb_recent_posts_loader' );
?>