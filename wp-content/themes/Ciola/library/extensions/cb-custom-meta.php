<?php

$prefix = 'cb_';

$cb_meta_review = array(
	'id' => 'cb_review',
	'title' => 'Review Options',
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Include Review Box',
			'id' => $prefix . 'review_checkbox',
			'type' => 'checkbox',
			'desc' => 'Enable Review On This Post'
		),
		array(
			'name' => 'Include User Scores',
			'id' => $prefix . 'user_score',
			'type' => 'checkbox',
			'desc' => 'Enable User Scores'
		),
		array(
			'name' => 'placement',
			'id' => $prefix . 'placement',
			'type' => 'select',
			'options' => array('Bottom', 'Top'),
			'desc' => 'Location Of Score Box'
		),
		array(
			'name' => 'Display type',
			'id' => $prefix . 'score_display_type',
			'type' => 'select',
			'options' => array('Out of 10', 'Stars', 'Percentage'),
			'desc' => 'Score Box Type'
		),
		array(
			'name' => 'Rating 1',
			'desc' => 'Criteria Name 1',
			'id' => $prefix . 'rating_1_title',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 1',
			'desc' => 'Score',
			'id' => $prefix . 'rating_1_score',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 2',
			'desc' => 'Criteria Name 2',
			'id' => $prefix . 'rating_2_title',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 2',
			'desc' => 'Score',
			'id' => $prefix . 'rating_2_score',
			'type' => 'text',
			'std' => ''		
		),
				array(
			'name' => 'Rating 3',
			'desc' => 'Criteria Name 3',
			'id' => $prefix . 'rating_3_title',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 3',
			'desc' => 'Score',
			'id' => $prefix . 'rating_3_score',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 4',
			'desc' => 'Criteria Name 4',
			'id' => $prefix . 'rating_4_title',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 4',
			'desc' => 'Score',
			'id' => $prefix . 'rating_4_score',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 5',
			'desc' => 'Criteria Name 5',
			'id' => $prefix . 'rating_5_title',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 5',
			'desc' => 'Score',
			'id' => $prefix . 'rating_5_score',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 6',
			'desc' => 'Criteria Name 6',
			'id' => $prefix . 'rating_6_title',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Rating 6',
			'desc' => 'Score',
			'id' => $prefix . 'rating_6_score',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Final Rating',
			'desc' => '',
			'id' => $prefix . 'final_score',
			'type' => 'text',
			'std' => ''	
		),
		array(
			'name' => 'Short Summary',
			'desc' => 'One/Two words that appear under the score (Only applies to Percentage/Out of 10 reviews)',
			'id' => $prefix . 'rating_short_summary',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Pros Title',
			'desc' => 'Positives Title',
			'id' => $prefix . 'pros_title',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Pros - 1',
			'desc' => 'Positive 1',
			'id' => $prefix . 'pros_one',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Pros - 2',
			'desc' => 'Positive 2',
			'id' => $prefix . 'pros_two',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Pros - 3',
			'desc' => 'Positive 3',
			'id' => $prefix . 'pros_three',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Cons Title',
			'desc' => 'Negatives Title',
			'id' => $prefix . 'cons_title',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Cons - 1',
			'desc' => 'Negative 1',
			'id' => $prefix . 'cons_one',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Cons - 2',
			'desc' => 'Negative 2',
			'id' => $prefix . 'cons_two',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Cons - 3',
			'desc' => 'Negative 3',
			'id' => $prefix . 'cons_three',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Final Rating Override',
			'desc' => 'Final Rating Override (1-100)',
			'id' => $prefix . 'final_score_override',
			'type' => 'text',
			'std' => ''	
		),
	)
);

// Review Meta Box Setup
function cb_meta_review_setup($postType) {
	global $cb_meta_review;
	$types = array( 'post', 'page');
	if(in_array($postType, $types)){
    add_meta_box(
	$cb_meta_review['id'], 
	$cb_meta_review['title'], 
	'cb_meta_review_box', 
	$postType, 
	$cb_meta_review['context'], 
	$cb_meta_review['priority']);
	}	
}

// Display the review meta box. 
function cb_meta_review_box( $object, $box ) { 
	global $cb_meta_review, $post;
 	wp_nonce_field( basename( __FILE__ ), 'cb_meta_review_nonce' ); 
	$i = 0;
	$j = 0;
	foreach ($cb_meta_review['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) {
			case 'text':
				 if ($i == 0){ echo '<div class="cb-meta title">Scores</div>';}
				if (($i % 2 == 0) && ($i < 12)){
						echo '<div class="cb-meta-review-score-box clearfix"><div class="sub-title">'.$field['desc'].'</div><input type="text" name="', $field['id'], '" id="', $field['id'], '" class="cb-review-title" value="', $meta ? $meta : $field['std'], '"  " />';}
				elseif (($i % 2 !== 0) && ($i < 12)){
						echo '<div class="sub-title">'.$field['desc'].' (1 - 100)</div><input type="number" max="100" maxlength="3" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="1"  " /></div>';}
				if ($i == 12){ echo '<div class="clearfix"></div><div class="cb-meta title">Summaries</div><div class="hidden">'.$field['name'].'<div class="sub-title">'.$field['desc'].'</div><input type="text" readonly="readonly" name="', $field['id'], '" id="', $field['id'], '" class="cb-review-final-score" value="', $meta ? $meta : $field['std'], '"  " /></div>';}
				if ($i == 13){ echo $field['name'].'<div class="sub-title">'.$field['desc'].'</div><input type="text" name="', $field['id'], '" id="', $field['id'], '" class="cb-pros-cons" value="', $meta ? $meta : $field['std'], '"  " />';}
				if ($i == 14){ echo '<div class="clearfix"></div><div class="pros-box"><div class="sub-title">'.$field['desc'].'</div><input type="text" name="', $field['id'], '" id="', $field['id'], '" class="cb-pros-cons" value="', $meta ? $meta : $field['std'], '"  " />';}
				if (($i == 15) || ($i == 16)){ echo '<div class="sub-title">'.$field['desc'].'</div><input type="text" name="', $field['id'], '" id="', $field['id'], '" class="cb-pros-cons" value="', $meta ? $meta : $field['std'], '"  " />';}
				if ($i == 17){ echo '<div class="sub-title">'.$field['desc'].'</div><input type="text" name="', $field['id'], '" id="', $field['id'], '" class="cb-pros-cons" value="', $meta ? $meta : $field['std'], '"  " /></div><div class="cons-box">';}
				if ($i >= 18){ echo '<div class="sub-title">'.$field['desc'].'</div><input type="text" name="', $field['id'], '" id="', $field['id'], '" class="cb-pros-cons" value="', $meta ? $meta : $field['std'], '"  " />';}
				if ($i == 21) { echo '</div><div class="clearfix"></div>';}
				if ($i == 22) { echo '</div><div class="clearfix"></div>';}
				$i++;
				
			break;
			case 'textarea':
				echo $field['name'].'<div class="sub-title">'.$field['desc'].'</div><textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:50%">', $meta ? $meta : $field['std'], '</textarea><div class="clearfix"></div>';
				break;
			case 'select':
				echo $field['desc'].'<select class="spaced" name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo '</select><div class="clearfix"></div>';
				break;
			case 'radio':
			echo '<div class="clearfix"></div><div class="title">'.$field['desc'].'</div>';
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' class="spaced" checked="checked"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
			if ($j == 0){ 
					echo '<div class="clearfix"></div>'.$field['desc'];
					echo '<input class="spaced" type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? '  checked="checked"' : '', ' /><div class="clearfix"></div>';
			} else {
					echo '<div class="review-main hidden">'; 	
					echo $field['desc'];
					echo '<input class="spaced" type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? '  checked="checked"' : '', ' /><div class="clearfix"></div>';
			}
			$j++;
				break;
		}
	}
} 

// Save data from review meta box
function cb_meta_review_save($post_id) {
	global $cb_meta_review;
	// Check nonce before proceeding
	 if ( !isset( $_POST['cb_meta_review_nonce'] ) || !wp_verify_nonce($_POST['cb_meta_review_nonce'], basename(__FILE__))) {
		return $post_id;
	}
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	// Check if user can edit
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	// Get review meta data
	foreach ($cb_meta_review['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
	// Replace review meta data	
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}

// Create Top Reviews Template Array
$cb_meta_top_reviews = array(
	'id' => $prefix . 'top_reviews',
	'title' => 'Top Review Template Options',
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Category with reviews',
			'desc' => 'Enter the slug of the category (The slug value for each category can be found in Posts -> Categories)',
			'id' => $prefix . 'top_reviews_category',
			'type' => 'text',
			'std' => ''		
		),
		array(
			'name' => 'Amount',
			'desc' => 'Enter the amount of reviews you wish to show',
			'id' => $prefix . 'top_reviews_amount',
			'type' => 'text',
			'std' => ''		
		)
	)
);

// Top reviews meta box Setup
function cb_meta_top_reviews_setup() {
	global $cb_meta_top_reviews;
    add_meta_box(
	$cb_meta_top_reviews['id'], 
	$cb_meta_top_reviews['title'], 
	'cb_meta_top_reviews_box', 
	$cb_meta_top_reviews['page'], 
	$cb_meta_top_reviews['context'], 
	$cb_meta_top_reviews['priority']);	
}

// Display the top reviews meta box
function cb_meta_top_reviews_box( $object, $box ) { 
	global $cb_meta_top_reviews, $post;
 	wp_nonce_field( basename( __FILE__ ), 'cb_meta_top_reviews_nonce' ); 
	foreach ($cb_meta_top_reviews['fields'] as $field) {
		// get current top reviews data
		$meta = get_post_meta($post->ID, $field['id'], true);
		
		switch ($field['type']) {
			case 'text':
				echo '<div class="cb-meta"><div class="title">'.$field['name'].'</div><div class="desc">'. $field['desc'].'</div><div class="clearfix"></div><input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="20"  " /></div>';
				break;
			case 'textarea':
				echo '<div class="cb-meta"><div class="title">'.$field['name'].'</div><div class="desc">'. $field['desc'].'</div></div><textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
					'<br />';
				break;
			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo '</select>';
				break;
			case 'radio':
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="spaced"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
				echo '<div class="cb-meta"><div class="title">'.$field['name'].'</div></div>'.$field['desc'].'<input type="checkbox" class="spaced" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				break;
		}

	}
	
} 

// Save data from top reviews meta box
function cb_meta_top_reviews_save($post_id) {
	global $cb_meta_top_reviews;
	// Check nonce before proceeding
	 if ( !isset( $_POST['cb_meta_top_reviews_nonce'] ) || !wp_verify_nonce($_POST['cb_meta_top_reviews_nonce'], basename(__FILE__))) {
		return $post_id;
	}
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	// Check if user can edit
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	// Get top reviews meta data
	foreach ($cb_meta_top_reviews['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
	// Replace top reviews meta data	
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}

// Load Meta Boxes on Admin Post Editor Screen 
add_action( 'load-post.php', 'cb_meta_review_setup' );
add_action( 'load-post-new.php', 'cb_meta_review_setup' );
add_action( 'add_meta_boxes', 'cb_meta_review_setup' );
add_action( 'save_post', 'cb_meta_review_save', 10, 2);

add_action( 'load-post.php', 'cb_meta_top_reviews_setup' );
add_action( 'load-post-new.php', 'cb_meta_top_reviews_setup' );
add_action( 'add_meta_boxes', 'cb_meta_top_reviews_setup' );
add_action( 'save_post', 'cb_meta_top_reviews_save', 10, 2);
?>