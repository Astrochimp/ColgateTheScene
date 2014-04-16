<?php 
/**
 * Ciola Random Post Widget
 */
 class CB_WP_Widget_Random_Post extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'random-article-widget', 'description' =>  "Shows a random post on every page load." );
		parent::__construct('ciola-random-post', 'Ciola Random Post', $widget_ops);
		$this->alt_option_name = 'widget_random_post';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_random_post', 'widget');

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
        
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Random Post', 'cubell') : $instance['title'], $instance, $this->id_base);
        $category = apply_filters('widget_category', empty($instance['category']) ? '' : $instance['category'], $instance, $this->id_base);
        if ($category != 'cb-all') { $cb_cat_qry = $category;} else {$cb_cat_qry = NULL;}

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'category_name' => $cb_cat_qry, 'no_found_rows' => true, 'posts_per_page' => 1, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'orderby' => 'rand' ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="cb-random-entry">
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
        <?php $format = get_post_format();
				$cb_custom_fields = get_post_custom();
				$cb_meta_onoff = ot_get_option('cb_meta_onoff', 'on');
				$cat_com_url = get_comments_link();
				$cb_review_checkbox = get_post_meta(get_the_id(), "cb_review_checkbox"); 
				if ($cb_review_checkbox) { $format = 'false'; }
		 ?>
            <li class="clearfix">
               <?php 
                                    $feature_size = "cb-thumb-350-crop" ;
                                
                                    if  (has_post_thumbnail())  {
                                       $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), $feature_size ); 
                                          echo '<img src="'.$thumbnail[0].'" >';
                                    } else { 
                                         $thumbnail = get_template_directory_uri().'/library/images/thumbnail-350x200.png'; ?>
                                        <img src="<?php echo $thumbnail; ?>" >
                                 <?php } ?> 
                                
                                 <?php if (get_comments_number() > 0) { ?>
                                    <a href="<?php echo $cat_com_url; ?>"><span class="cb-comments"><?php echo get_comments_number(); ?></span></a>
                                 <?php } ?>   
                               
                                <h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
                                
                                 <?php  if ( $cb_meta_onoff != 'off' ) { ?>
                                     <div class="cb-byline"><?php echo __('By', 'cubell'); echo ' '.get_the_author()?></div>
                                 <?php } ?>

                                
                                <div class="cb-excerpt"><?php echo cb_clean_excerpt('45', false);?></div>  
                                
                                <span class="cb-shadow"></span>
                                <a href="<?php the_permalink(); ?>" class="grid-overlay"></a>
            </li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_random_post', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = strip_tags($new_instance['category']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_random_post']) )
			delete_option('widget_random_post');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_random_post', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
	    $category     = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
        $cb_cats = get_categories();
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'cubell'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
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
function cb_random_post_loader () {
    register_widget( 'CB_WP_Widget_Random_Post' );
}
    add_action( 'widgets_init', 'cb_random_post_loader' );
?>