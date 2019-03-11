<?php
  namespace Kokku\Cleanup\DisableTrackbacks;

  /*
   * Disable WordPress Asset Versioning
   *
   * You can enable/disable this feature in functions.php:
   * add_theme_support('kokku-disable-trackbacks');
  */

  /*
   * Disable pingback XMLRPC method
   * https://developer.wordpress.org/reference/hooks/xmlrpc_methods/
  */
  add_filter( 'xmlrpc_enabled', '__return_false' );

  /*
   * Unset pingback XMLRPC methods
   * https://developer.wordpress.org/reference/hooks/xmlrpc_methods/
  */
  function unset_xmlrpc_method($methods) {
    return [];
  }
  add_filter('xmlrpc_methods', __NAMESPACE__ . '\\unset_xmlrpc_method', PHP_INT_MAX);

  /*
   * Send error msg if XMLRPC is pinged
   *
  */
  function kill_xmlrpc($action) {
    if ($action === 'pingback.ping') {
      wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
    }
  }
  add_action('xmlrpc_call', __NAMESPACE__ . '\\kill_xmlrpc');

  /*
   * Remove pingback header
   *
  */
  function unset_x_pingback($headers) {
    if (isset($headers['X-Pingback'])) unset($headers['X-Pingback']);
    return $headers;
  }
  add_filter('wp_headers', __NAMESPACE__ . '\\unset_x_pingback', 10, 1);

  /*
   * Kill trackback rewrite rule
   * https://codex.wordpress.org/Plugin_API/Filter_Reference/rewrite_rules_array
  */
  function filter_rewrites($rules) {
    foreach ($rules as $rule => $rewrite) {
      if (preg_match('/trackback\/\?\$$/i', $rule)) unset($rules[$rule]);
    }
    return $rules;
  }
  add_filter('rewrite_rules_array', __NAMESPACE__ . '\\filter_rewrites');

  /*
   * Kill bloginfo( 'pingback_url' ) function
   *
  */
  function kill_pingback_url($output, $show) {
    if ($show === 'pingback_url') $output = '';
    return $output;
  }
  add_filter('bloginfo_url', __NAMESPACE__ . '\\kill_pingback_url', 10, 2);

  /*
   * Remove RSD link from wp_head
   * https://developer.wordpress.org/reference/functions/rsd_link/
  */
  remove_action( 'wp_head', 'rsd_link', 1);

  /*
   * Disable any options updating for XMLRPC
   * https://developer.wordpress.org/reference/functions/rsd_link/
  */
  add_filter( 'pre_update_option_enable_xmlrpc', '__return_false' );
  add_filter( 'pre_option_enable_xmlrpc', '__return_zero' );

 ?>
