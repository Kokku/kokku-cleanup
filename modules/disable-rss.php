<?php
  namespace Kokku\Cleanup\DisableRSSFeed;

  /*
   * Disable WordPress RSS Feed
   *
   * You can enable/disable this feature in functions.php:
   * add_theme_support('kokku-disable-rss');
  */


  /*
   * Remove RSS feed links from wp_head
   *
   */
  function remove_feed_wp_head() {

    // Display the links to the general feeds: Post and Comment Feed
    remove_action( 'wp_head', 'feed_links', 2 );

    // Display the links to the extra feeds such as category feeds
    remove_action( 'wp_head', 'feed_links_extra', 3 );

    // Display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action( 'wp_head', 'rsd_link' );

    // Display the link to the Windows Live Writer manifest file.
    remove_action( 'wp_head', 'wlwmanifest_link' );

  }
  add_action( 'wp_head', __NAMESPACE__ . '\\remove_feed_wp_head', 1 );

  /*
   * Return error msg if RSS feed is requested
   *
  */
  function wp_remove_rss_feed() {
    wp_die( __('No feed available. Please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!', 'kokku') );
  }
  add_action('do_feed', __NAMESPACE__ . '\\wp_remove_rss_feed', 1);
  add_action('do_feed_rdf', __NAMESPACE__ . '\\wp_remove_rss_feed', 1);
  add_action('do_feed_rss', __NAMESPACE__ . '\\wp_remove_rss_feed', 1);
  add_action('do_feed_rss2', __NAMESPACE__ . '\\wp_remove_rss_feed', 1);
  add_action('do_feed_atom', __NAMESPACE__ . '\\wp_remove_rss_feed', 1);
  add_action('do_feed_rss2_comments', __NAMESPACE__ . '\\wp_remove_rss_feed', 1);
  add_action('do_feed_atom_comments', __NAMESPACE__ . '\\wp_remove_rss_feed', 1);

  /*
   * Remove the WordPress version function from RSS feeds
   *
  */
  add_filter('the_generator', '__return_false');

  /*
   * Remove unnecessary self-closing tags (img, input, img)
   *
  */
  function remove_self_closing_tags($input) {
    return str_replace(' />', '>', $input);
  }
  add_filter('get_avatar', __NAMESPACE__ . '\\remove_self_closing_tags');
  add_filter('comment_id_fields', __NAMESPACE__ . '\\remove_self_closing_tags');
  add_filter('post_thumbnail_html', __NAMESPACE__ . '\\remove_self_closing_tags');

  /*
   * Don't return the default description in the RSS feed if it hasn't been changed
   *
  */
  function remove_default_description($bloginfo) {
    $default_tagline = 'Just another WordPress site';
    return ($bloginfo === $default_tagline) ? '' : $bloginfo;
  }
  add_filter('get_bloginfo_rss', __NAMESPACE__ . '\\remove_default_description');

  /*
   * Disable automatic feed links from theme
   *
  */
  remove_theme_support( 'automatic-feed-links' );

  /*
   * Remove trackback from post-types
   *
  */
  function remove_post_trackback_support() {
    remove_post_type_support( 'page', 'trackbacks' );
    remove_post_type_support( 'post', 'trackbacks' );
  }
  add_action( 'admin_menu' , __NAMESPACE__ . '\\remove_post_trackback_support' );

  /*
   * Trackbacks metabox
   *
  */
  function remove_post_custom_fields() {
    remove_meta_box( 'trackbacksdiv', 'page', 'normal' );
    remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
  }
  add_action( 'admin_menu' , __NAMESPACE__ . '\\remove_post_custom_fields' );

 ?>
