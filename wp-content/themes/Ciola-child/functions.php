<?php /* To overwrite a function from either functions.php or from library/core.php, overwrite it in this file */ 

/*********************
CHILD STYLESHEET ENQUEUEING
*********************/
if ( ! function_exists( 'cb_script_loaders_child' ) ) {   
    function cb_script_loaders_child() {

        add_action('wp_enqueue_scripts', 'cb_scripts_and_styles_child', 999);
    }
}

add_action('after_setup_theme','cb_script_loaders_child', 16);
    

if ( ! function_exists( 'cb_scripts_and_styles_child' ) ) {
       
    function cb_scripts_and_styles_child() {
                
      if (!is_admin()) {
       
        wp_register_style( 'cb-child-stylesheet',  get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all' );
        wp_enqueue_style('cb-child-stylesheet'); // enqueue it
      }
    }

}


add_action( 'init', 'create_post_type' );

function create_post_type() {


	register_post_type( 'main_feature',
		array(
			'labels' => array(
				'name' => __( 'Category Feature' ),
				'singular_name' => __( 'Feature' )
			),
		'description' => 'Articles in categories featured on the homepage',
		'public' => true,
		'has_archive' => true,
		'public' => true,
		'menu_position' => 5,
  		'supports' => array( 'title', 'thumbnail','excerpt', 'editor'),
  		'taxonomies' => array( 'category', 'post_tag' ),
  		'show_ui' => true,
  		'capability_type' => 'post'

	));
}



?>