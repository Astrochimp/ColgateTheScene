<?php 
/**
 * Ciola Top Reviews Widget
 */
 class CB_WP_Widget_top_reviews extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'cb-top-reviews-widget', 'description' =>  "Shows the top reviews in a given category" );
		parent::__construct('top-reviews', 'Ciola Top Reviews', $widget_ops);
		$this->alt_option_name = 'widget_top_reviews';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_top_reviews', 'widget');

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

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Top Reviews', 'cubell') : $instance['title'], $instance, $this->id_base);
		$category = apply_filters('widget_category', empty($instance['category']) ? '' : $instance['category'], $instance, $this->id_base);
		$filter = apply_filters('widget_filter', empty($instance['filter']) ? '' : $instance['filter'], $instance, $this->id_base);
		if ($filter == NULL) {$filter = 'alltime';}
		
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 5;
	
		if ($filter == 'week') {
		$week = date('W');
		$year = date('Y');
				
		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number,'category_name' => $category, 'year' => $year, 'w' => $week , 'no_found_rows' => true, 'post_status' => 'publish', 'meta_key' => 'cb_final_score', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'ignore_sticky_posts' => true ) ) );
		} 

		if ($filter == 'alltime') {

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number,'category_name' => '', 'no_found_rows' => true, 'post_status' => 'publish', 'meta_key' => 'cb_final_score', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'ignore_sticky_posts' => true ) ) );
		} 
		
		if ($filter == 'month') {
			
		$month = date('m', strtotime('-30 days'));
		$year = date('Y', strtotime('-30 days'));
		
		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number,'category_name' => $category, 'year' => $year, 'monthnum' => $month ,  'no_found_rows' => true, 'post_status' => 'publish', 'meta_key' => 'cb_final_score', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'ignore_sticky_posts' => true ) ) );
		} 
		
		if ($filter == '2012') {

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number,'category_name' => $category, 'year' => '2012', 'no_found_rows' => true, 'post_status' => 'publish', 'meta_key' => 'cb_final_score', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'ignore_sticky_posts' => true ) ) );
		} 
		if ($filter == '2013') {

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number,'category_name' => $category, 'year' => '2013', 'no_found_rows' => true, 'post_status' => 'publish', 'meta_key' => 'cb_final_score', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'ignore_sticky_posts' => true ) ) );
		} 
		if ($filter == '2011') {

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number,'category_name' => $category, 'year' => '2011', 'no_found_rows' => true, 'post_status' => 'publish', 'meta_key' => 'cb_final_score', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'ignore_sticky_posts' => true ) ) );
		} 
		
			
		
		$cb_review_final_score = NULL;
		
		$count_posts = $r->post_count; 
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
        <?php $i = 1; ?>
        
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
        <?php $cb_rating_short_summary = NULL;
			$cb_custom_fields = get_post_custom();
			$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
			if (isset($cb_custom_fields['cb_score_display_type'][0]) && $cb_custom_fields['cb_score_display_type'][0]) { $cb_score_display_type = $cb_custom_fields['cb_score_display_type'][0]; }
			if (isset($cb_custom_fields['cb_final_score'][0]) && $cb_custom_fields['cb_final_score'][0]) { $cb_final_score = $cb_custom_fields['cb_final_score'][0]; } 
			$cb_review_final_score = intval($cb_final_score);
			$cb_review_final_score_stars = $cb_review_final_score / 20; 
		?>
            <li class="clearfix">
            
					<a href="<?php the_permalink() ?>">
						<?php if  (has_post_thumbnail()) 
                        {

							$featured_image = the_post_thumbnail('cb-thumb-90-crop'); 
              			 echo $featured_image[0];
                        } else { 
                        // if no featured image set backup image
                         $thumbnail = get_template_directory_uri().'/library/images/thumbnail-90x90.png'; ?>
                            <img src="<?php echo $thumbnail; ?>" alt="thumbnail">
                        <?php } ; ?> 
                         <div class="cb-countdown header-font"><?php echo $i; ?></div>
       
                   </a>
                   <h4 class="h6"><a href="<?php the_permalink() ?>"><?php echo get_the_title(); ?></a></h4>
                  <?php  if ($cb_meta_onoff == 'on') { ?><p class="cb-byline"><?php printf(__('By <span class="author">%1$s</span>', 'cubell'), get_the_author()); ?></p><?php } ?>
                   <?php cb_review_widget_thumbnail(); ?>
                   
            </li>
            
         <?php $i++; ?> 
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_top_reviews', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['filter'] =  strip_tags($new_instance['filter']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_top_reviews']) )
			delete_option('widget_top_reviews');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_top_reviews', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$category     = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		$filter    = isset( $instance['filter'] ) ? esc_attr( $instance['filter'] ) : '';
        $cb_cats = get_categories();
?>
	
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'cubell' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php  echo "Category:"; ?></label>
        <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
        <option value="cb-all" <?php if ($category == 'all') echo 'selected="selected"'; ?>>All Categories</option> 
        <?php foreach ($cb_cats as $cat) {
                if ($category == $cat->slug) {$selected = 'selected="selected"'; } else { $selected = NULL;}
                echo '<option value="'.$cat->slug.'" '.$selected.'>'.$cat->name.' ('.$cat->count.')</option>';
                
        } ?>
        </select></p>
		
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of reviews to show:', 'cubell' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		 <p><label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php  echo "Filter:"; ?></label>
		 	
		 <select id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>">
           <option value="alltime" <?php if ($filter == 'alltime') echo 'selected="selected"'; ?>>All-time</option> 
           <option value="month" <?php if ($filter == 'month') echo 'selected="selected"'; ?>>Last Month</option> 
           <option value="week" <?php if ($filter == 'week') echo 'selected="selected"'; ?>>Past 7 Days</option> 
           <option value="2013" <?php if ($filter == '2013') echo 'selected="selected"'; ?>>Only 2013</option> 
           <option value="2012" <?php if ($filter == '2012') echo 'selected="selected"'; ?>>Only 2012</option> 
           <option value="2011" <?php if ($filter == '2012') echo 'selected="selected"'; ?>>Only 2011</option> 
            	
         </select></p>
<?php
	}
}
function cb_top_reviews_loader ()
{
 register_widget( 'CB_WP_Widget_top_reviews' );
}
 add_action( 'widgets_init', 'cb_top_reviews_loader' );
?>