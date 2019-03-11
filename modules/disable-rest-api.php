<?php
  namespace Kokku\Cleanup\DisableRestApi;

  /*
   * Disable WordPress REST API
   *
   * You can enable/disable this feature in functions.php:
   * add_theme_support('kokku-disable-rest-api');
  */
  

  /*
   * Disable additional APIs to the Really Simple Discovery (RSD) endpoint.
   * https://developer.wordpress.org/reference/hooks/xmlrpc_rsd_apis/
   */
  remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');

  /*
   * Disable REST API link tag output in page header.
   * https://developer.wordpress.org/reference/functions/rest_output_link_wp_head/
   */
  remove_action('wp_head', 'rest_output_link_wp_head', 10);

  /*
   * Disable template page redirect from Rest API output header.
   * https://codex.wordpress.org/Plugin_API/Action_Reference/template_redirect
   */
  remove_action('template_redirect', 'rest_output_link_header', 11);

  /*
   * Return REST API errors with statuscode and message
   * https://developer.wordpress.org/reference/functions/rest_output_link_wp_head/
   */
  add_filter('rest_authentication_errors', function ($result) {
    return new \WP_Error('rest_forbidden', __('REST API forbidden.', 'kokku'), ['status' => rest_authorization_required_code()]);
  });

  /*
   * Remove the REST API endpoint.
   * https://developer.wordpress.org/reference/functions/wp_oembed_register_route/
   * https://developer.wordpress.org/reference/hooks/rest_api_init/
   */
  add_action( 'init', function() {
    remove_action('rest_api_init', 'wp_oembed_register_route');
  }, PHP_INT_MAX - 1 );

 ?>
