<?php
  namespace Kokku\Cleanup\DisablejQueryMigrate;

  /*
   * Disable WordPress Emojis
   *
   * You can enable/disable this feature in functions.php:
   * add_theme_support('kokku-disable-jquery-migrate');
  */

  /*
   * Remove the jQuery Migrate script from the front end of the site.
   *
  */
  function disable_jquery_migrate($scripts) {
    if ( !is_admin() && isset($scripts->registered['jquery']) ) {
      $script = $scripts->registered['jquery'];
      if ( $script->deps ) {
        $script->deps = array_diff($script->deps, array(
          'jquery-migrate'
        ));
      }
    }
  }
  add_action('wp_default_scripts', __NAMESPACE__ . '\\disable_jquery_migrate');

 ?>
