<?php
namespace Kokku\Cleanup\UnregisterWidgets;

/*
 * Unregister WordPress Default Widgets
 *
 * You can enable/disable this feature in functions.php:
 * add_theme_support('kokku-unregister-widgets');
*/


/**
 * Unregister default widgets
 * @link https://codex.wordpress.org/Function_Reference/unregister_widget
 */
function unregister_default_widgets() {
  $widgets = [
    'WP_Widget_Archives',
    'WP_Widget_Media_Audio',
    'WP_Widget_Calendar',
    'WP_Widget_Categories',
    'WP_Widget_Custom_HTML',
    'WP_Widget_Media_Gallery',
    'WP_Widget_Media_Image',
    'WP_Widget_Meta',
    'WP_Nav_Menu_Widget',
    'WP_Widget_Pages',
    'WP_Widget_Recent_Comments',
    'WP_Widget_Recent_Posts',
    'WP_Widget_RSS',
    'WP_Widget_Search',
    'WP_Widget_Tag_Cloud',
    'WP_Widget_Text',
    'WP_Widget_Media_Video'
  ];
  foreach ($widgets as $widget ) {
    unregister_widget($widget);
  }
}
add_action( 'widgets_init', __NAMESPACE__ . '\\unregister_default_widgets', 11);

 ?>
