<?php
  namespace Kokku\Cleanup\DisableAssetVersioning;

  /*
   * Disable WordPress Asset Versioning
   *
   * You can enable/disable this feature in functions.php:
   * add_theme_support('kokku-disable-asset-versioning');
  */


  /*
   * Remove Wordpress version from assets
   *
   */
   function remove_asset_version($src) {
     return $src ? esc_url(remove_query_arg('ver', $src)) : false;
   }
   add_filter('script_loader_src', __NAMESPACE__ . '\\remove_asset_version', 15, 1);
   add_filter('style_loader_src', __NAMESPACE__ . '\\remove_asset_version', 15, 1);

 ?>
