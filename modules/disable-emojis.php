<?php
  namespace Kokku\Cleanup\DisableEmojis;

  /*
   * Disable WordPress Emojis
   *
   * You can enable/disable this feature in functions.php:
   * add_theme_support('kokku-disable-emojis');
  */


  /*
   * Disable printing the inline Emoji detection script
   * https://developer.wordpress.org/reference/functions/print_emoji_detection_script/
  */
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

  /*
   * Disable printing the inline Emoji detection script in /wp-admin.
   * https://developer.wordpress.org/reference/functions/print_emoji_detection_script/
  */
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

  /*
   * Disable printing the important emoji-related styles.
   * https://developer.wordpress.org/reference/functions/print_emoji_styles/
  */
  remove_action( 'wp_print_styles', 'print_emoji_styles' );

  /*
   * Disable printing the important emoji-related styles in /wp-admin.
   * https://developer.wordpress.org/reference/functions/print_emoji_styles/
  */
  remove_action( 'admin_print_styles', 'print_emoji_styles' );

  /*
   * Disable converting emoji to a static img element.
   * https://developer.wordpress.org/reference/functions/wp_staticize_emoji/
  */
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );

  /*
   * Disable converting emoji to a static img element in RSS Feed.
   * https://developer.wordpress.org/reference/functions/wp_staticize_emoji/
  */
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  /*
   * Disable converting emoji to a static img element in Email.
   * https://developer.wordpress.org/reference/functions/wp_staticize_emoji/
  */
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

  /*
   * Disable filtering the URL where emoji SVG images are hosted.
   * https://developer.wordpress.org/reference/hooks/emoji_svg_url/
  */
  add_filter('emoji_svg_url', '__return_false');

  /*
   * Remove emoji CDN hostname from DNS prefetching hints.
   * https://developer.wordpress.org/reference/hooks/emoji_svg_url/
  */
  function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( $relation_type == 'dns-prefetch' ) {
      // Strip out any URLs referencing the WordPress.org emoji location
      $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
      foreach ( $urls as $key => $url ) {
        if ( strpos( $url, $emoji_svg_url_bit ) !== false )  unset( $urls[$key] );
      }
    }
    return $urls;
  }
  add_filter( 'wp_resource_hints', __NAMESPACE__ . '\\disable_emojis_remove_dns_prefetch', 10, 2 );

  /*
   * Remove TinyMCE emojis
   * https://developer.wordpress.org/reference/hooks/emoji_svg_url/
  */
  function disable_emojicons_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
      return array();
    }
  }
  add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\\disable_emojicons_tinymce' );

 ?>
