<?php
  namespace Kokku\Cleanup\DisableoEmbed;

  /*
   * Disable WordPress auto-embeds (oEmbed)
   *
   * You can enable/disable this feature in functions.php:
   * add_theme_support('kokku-disable-oembed');
  */


  global $wp;

  /*
   * Remove the embed query var.
   *
   */
   $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
 		'embed',
   ) );

  /*
   * Remove the REST API endpoint.
   * https://developer.wordpress.org/reference/functions/wp_oembed_register_route/
   */
  remove_action( 'rest_api_init', 'wp_oembed_register_route' );

  /*
   * Remove the oembed/1.0/embed REST route.
   *
   */
  function disable_embeds_remove_embed_endpoint( $endpoints ) {
    unset( $endpoints['/oembed/1.0/embed'] );
    return $endpoints;
  }
	add_filter( 'rest_endpoints', __NAMESPACE__ . '\\disable_embeds_remove_embed_endpoint' );

  /*
   * Disable handling of internal embeds in oembed/1.0/proxy REST route.
   *
   */
  function disable_embeds_filter_oembed_response_data( $data ) {
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) return false;
    return $data;
  }
  add_filter( 'oembed_response_data', __NAMESPACE__ . '\\disable_embeds_filter_oembed_response_data' );

  /*
   * Turn off oEmbed auto discovery.
   * https://developer.wordpress.org/reference/hooks/embed_oembed_discover/
   */
  add_filter( 'embed_oembed_discover', '__return_false' );

  /*
   * Don't filter oEmbed results.
   * https://developer.wordpress.org/reference/functions/wp_filter_oembed_result/
   */
  remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

  /*
   * Remove filter of the oEmbed result before any HTTP requests are made.
   * https://developer.wordpress.org/reference/functions/wp_filter_pre_oembed_result/
   */
  remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );

  /*
   * Remove oEmbed discovery links.
   * https://developer.wordpress.org/reference/functions/wp_oembed_add_discovery_links/
   */
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

  /*
   * Remove oEmbed-specific JavaScript.
   * https://developer.wordpress.org/reference/functions/wp_oembed_add_host_js/
   */
  remove_action( 'wp_head', 'wp_oembed_add_host_js' );

  /*
   * Remove oEmbed-specific JavaScript from TinyMCE.
   *
   */
  function disable_embeds_tiny_mce_plugin( $plugins ) {
    return array_diff( $plugins, array( 'wpembed' ) );
  }
  add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\\disable_embeds_tiny_mce_plugin' );

  /*
   * Remove all embeds rewrite rules.
   * https://developer.wordpress.org/reference/functions/wp_oembed_register_route/
   */
  function disable_embeds_rewrites( $rules ) {
    foreach ( $rules as $rule => $rewrite ) {
      if ( false !== strpos( $rewrite, 'embed=true' ) )unset( $rules[ $rule ] );
    }
    return $rules;
  }
  add_filter( 'rewrite_rules_array', __NAMESPACE__ . '\\disable_embeds_rewrites' );

  /*
   * Load block editor JavaScript. This is used to unregister the `core-embed/wordpress` block type.
   *
   */
  function disable_embeds_enqueue_block_editor_assets() {
    wp_enqueue_script(
      'disable-embeds',
      plugins_url( 'lib/js/editor.js', __FILE__ ),
      array(
        'wp-edit-post',
        'wp-editor',
        'wp-dom',
      ),
      '20181202',
      true
    );
  }
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\disable_embeds_enqueue_block_editor_assets' );

  /*
   * Remove wp-embed dependency of wp-edit-post script handle.
   *
   */
  function disable_embeds_remove_script_dependencies( $scripts ) {
    if ( ! empty( $scripts->registered['wp-edit-post'] ) ) {
      $scripts->registered['wp-edit-post']->deps = array_diff(
        $scripts->registered['wp-edit-post']->deps,
        array( 'wp-embed' )
      );
    }
  }
  add_action( 'wp_default_scripts', __NAMESPACE__ . '\\disable_embeds_remove_script_dependencies' );

  /*
   * Wrap embedded media as suggested by Readability
   *
  */
  function embed_wrap($cache) {
    return '<div class="entry-content-asset">' . $cache . '</div>';
  }
  add_filter('embed_oembed_html', __NAMESPACE__ . '\\embed_wrap');


 ?>
