<?php
/********************* META BOX DEFINITIONS ***********************/

$prefix = 'cb_';

global $meta_boxes;

$meta_boxes = array();

// Post Options Format
$meta_boxes[] = array(
	'id' => 'style',
	'title' => 'Style Options',
	'pages' => array( 'post', 'main_feature' ),
	'context' => 'normal',
	'priority' => 'high',

	'fields' => array(
		// Featured on homepage
		array(
			'name' => 'Featured On Homepage/Category ',
			'id' => $prefix . 'featured_post',
			'type' => 'checkbox',
			'desc' => 'Only applicable if there is a slider/grid turned on',
		),
		// Full-width post option
		array(
			'name' => 'Full-Width Post',
			'id' => $prefix . 'full_width_post',
			'type' => 'checkbox',
			'desc' => '(No sidebar)',
		),
		// Featured Image Settings
		array(
			'name'     => 'Featured Image Settings',
			'id'       => "{$prefix}featured_image_settings_post",
			'desc' => "How do you want to display the featured image?",
			'type'     => 'select',
			// Array of 'value' => 'Label' pairs for select box
			'options'  => array(
				'Normal' => 'Standard',
				'Full-Width' => 'Full-Width',
				'Cover Image' => 'Screen-Wide',
				'Full-BG with Void' => 'Full-Background with Void',
				'no-featured-images' => 'Do not show featured image'
			),
			// Select multiple values, optional. Default is false.
			'multiple' => false,
		),
		// Background Color
		array(
			'name' => 'Background Color',
			'id'   => "{$prefix}bg_color_post",
			'type' => 'color',
			'desc' => 'Overrides Base/Category Background Color'
		),
		// Background Image
		array(
			'name' => 'Background Image',
			'id'   => "{$prefix}bg_image_post",
			'type' => 'thickbox_image',
			'desc' => 'Overrides Base/Category Background Image'
		),
		// Background Image Settings
		array(
			'name'     => 'Background Image Settings',
			'id'       => "{$prefix}bg_image_post_setting",
			'desc' => "How do you want the background image to look?",
			'type'     => 'select',
			'options'  => array(
				'1' => 'Full-Width Stretch',
				'2' => 'Repeat',
				'3' => 'No-Repeat',				
			),
			// Select multiple values, optional. Default is false.
			'multiple' => false,
		),
		array(
            'name' => 'Format Options: Audio',
            'desc' => 'Soundcloud Wordpress Embed Code',
            'id' => $prefix . 'soundcloud_embed_code_post',
            'type' => 'textarea',
            'std' => ''
		),
		array(
            'name' => 'Format Options: Video',
            'desc' => 'Video iframe embed code',
            'id' => $prefix . 'video_embed_code_post',
            'type' => 'textarea',
            'std' => ''
        )
	)
);
$meta_boxes[] = array(
	'id' => 'style',
	'title' => 'Style Options',
	'pages' => array( 'page' ),
	'context' => 'normal',
	'priority' => 'high',

	'fields' => array(
		// Overall Color
		array(
			'name' => 'Overall Color',
			'id'   => "{$prefix}overall_color_post",
			'type' => 'color',
			'desc' => 'Overrides color of styling'
		),
		// Background Color
		array(
			'name' => 'Background Color',
			'id'   => "{$prefix}bg_color_post",
			'type' => 'color',
			'desc' => 'Overrides Background Color'
		),
		// Background Image
		array(
			'name' => 'Background Image',
			'id'   => "{$prefix}bg_image_post",
			'type' => 'thickbox_image',
			'desc' => 'Overrides Background Image (and color)'
		),
		// Background Image Settings
		array(
			'name'     => 'Background Image Settings',
			'id'       => "{$prefix}bg_image_post_setting",
			'desc' => "How do you want the background image to look?",
			'type'     => 'select',
			'options'  => array(
				'1' => 'Full-Width Stretch',
				'2' => 'Repeat',
				'3' => 'No-Repeat',				
			),
			// Select multiple values, optional. Default is false.
			'multiple' => false,
		),
		// Custom Sidebar
		array(
			'name'     => 'Custom Sidebar',
			'id'       => "{$prefix}page_sidebar",
			'desc' => "Enable custom sidebar?",
			'type'     => 'select',
			'options'  => array(
				'Off' => 'Off',
				'On' => 'On'
			),
			// Select multiple values, optional. Default is false.
			'multiple' => false,
		),
	)
);


/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function cb_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'cb_register_meta_boxes' );