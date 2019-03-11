<?php
namespace Kokku\Cleanup\Cleanups;

/*
 * Kokku Cleanup
 *
 * You can enable/disable this feature in functions.php:
 * add_theme_support('kokku-cleanup');
*/


/*
 * Remove Wordpress version number from header
 *
*/
remove_action('wp_head', 'wp_generator');

//
/*
 * Use HTML5 gallery as default
 * https://developer.wordpress.org/reference/hooks/use_default_gallery_style/
*/
add_filter('use_default_gallery_style', '__return_false');


/*
 * Remove Index Rel Link
 * https://developer.wordpress.org/reference/functions/index_rel_link/
*/
if(function_exists('index_rel_link'))
  remove_action( 'wp_head', 'index_rel_link' );


/*
 * Remove relational link for parent item
 * https://developer.wordpress.org/reference/functions/parent_post_rel_link/
*/
if(function_exists('parent_post_rel_link'))
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

// start link
/*
 * Remove relational link for the first post.
 * https://developer.wordpress.org/reference/functions/start_post_rel_link/
*/
if(function_exists('start_post_rel_link'))
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

/*
 * Remove relational links for the posts adjacent to the current post.
 * https://developer.wordpress.org/reference/functions/adjacent_posts_rel_link/
*/
if(function_exists('adjacent_posts_rel_link'))
  remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );

/*
 * Remove WP Embed
 *
*/
function remove_wp_embed() {
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', __NAMESPACE__ . '\\remove_wp_embed' );


 ?>
