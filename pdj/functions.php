<?php
/*
 *  Author: Framework | @Framework
 *  URL: wordfly.com | @wordfly
 *  Custom functions, support, custom post types and more.
 */

/*ini_set('log_errors','On');
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);*/

// Theme setting
require_once('init/theme-init.php');
require_once('init/theme-shortcode.php');
require_once('init/options/option.php');

/* Custom for theme */
//echo get_stylesheet_directory_uri();

if(!is_admin()) {
  // Add scripts
  function ct_libs_scripts() {
    wp_register_script('lib-slick', get_stylesheet_directory_uri() . '/dist/js/libs/slick.js', array('jquery'), FALSE, '0.7.0', TRUE);
    wp_enqueue_script('lib-slick');

    wp_register_script('lib-matchHeight', get_stylesheet_directory_uri() . '/dist/js/libs/jquery.matchHeight-min.js', array('jquery'), FALSE, '0.7.0', TRUE);
    wp_enqueue_script('lib-matchHeight');

    wp_register_script('lib-fancybox', get_stylesheet_directory_uri() . '/dist/js/libs/jquery.fancybox.pack.js', array('jquery'),  FALSE, '2.1.5', TRUE);
    wp_enqueue_script('lib-fancybox');

    wp_register_script('script', get_stylesheet_directory_uri() . '/dist/js/script.js', FALSE, '1.0.0', TRUE);
    wp_localize_script( 'script', 'paginationAjax', array( 'ajaxurl' => admin_url('admin-ajax.php' )));
    wp_enqueue_script('script');
  }
  add_action('wp_print_scripts', 'ct_libs_scripts');

  // Add stylesheet
  function ct_styles() {
    $styles = get_stylesheet_directory_uri() . '/dist/css/styles.css';
    wp_register_style('theme-style', $styles, array(), '1.0', 'all');
    wp_enqueue_style('theme-style');
  }
  add_action('wp_enqueue_scripts', 'ct_styles');
}

// Add admin script
function ct_admin_scripts() {
  wp_register_script('lib-moment', get_stylesheet_directory_uri() . '/dist/js/admin-libs/moment.js', array('jquery'), '2.13.0');
  wp_enqueue_script('lib-moment');

  wp_register_script('lib-datetimepicker', get_stylesheet_directory_uri() . '/dist/js/admin-libs/bootstrap-datetimepicker.min.js', array('jquery'), '4.17.37');
  wp_enqueue_script('lib-datetimepicker');

  wp_register_script('admin-script', get_stylesheet_directory_uri() . '/dist/js/admin-script.js', array('jquery'), '1.0.0');
  wp_enqueue_script('admin-script');
}
add_action('admin_init', 'ct_admin_scripts');

// Add admin script
function ct_admin_styles() {
  wp_register_style('admin-style', get_stylesheet_directory_uri() . '/dist/css/admin.css', array(), '1.0', 'all');
  wp_enqueue_style('admin-style');
}
add_action('admin_init', 'ct_admin_styles');

/*
 *
 * Add custom post type
 *
 */
function pdj_create_custom_post_types() {
  // Programs
  register_post_type( 'program', array(
    'labels' => array(
      'name' => __( 'Programs', 'pdj_theme' ),
      'singular_name' => __( 'Program', 'pdj_theme' )
    ),
    'public' => true,
    'has_archive' => false,
    'menu_position' => 28,
    'rewrite' => array('slug' => 'program'),
    'supports' => array( 'title', 'editor', 'thumbnail' ),
  ));
}
//add_action( 'init', 'pdj_create_custom_post_types' );

/*
 *
 * Custom Taxonomy
 *
 */
function pdj_create_custom_taxonomy() {
  $labels_subsite = array(
    'name' => __('Subsite Taxonomies', 'pdj_theme'),
    'singular' => __('Subsite Taxonomy', 'pdj_theme'),
    'menu_name' => __('Subsite Taxonomy', 'pdj_theme')
  );
  $args_subsite = array(
    'labels'                     => $labels_subsite,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'show_in_quick_edit'         => false,
  );
  register_taxonomy('subsite_taxonomy', array('program'), $args_subsite);
}
//add_action( 'init', 'pdj_create_custom_taxonomy', 0 );

/*
 *
 *
 * Custom for theme
 *
 */
// Remove Editor Field for Landing page
function pdj_remove_editor() {
  remove_post_type_support('page', 'editor');
}
add_action('admin_init', 'pdj_remove_editor');

// Add google API Key
add_action('acf/init', function() {
  $theme_options = get_option('pdj_board_settings');
  $google_api_key = $theme_options['pdj_google_api_key'];
  acf_update_setting('google_api_key', $google_api_key);
});
