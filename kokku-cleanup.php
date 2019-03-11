<?php
/*
Plugin Name:        Kokku Cleanup
Plugin URI:         https://kokku.com/
Description:        A collection of cleanup, security & optimization modules.
Version:            0.4.0
Author:             Kokku
Author URI:         https://kokku.com/
License:            MIT License
License URI:        http://opensource.org/licenses/MIT
*/

namespace Kokku\Cleanup;

/*
 * Autoload modules and construct functions to be used in themes
 * Copyright Ben Word & Scott Walkinshaw
 * Licence: MIT License
 * URL: https://github.com/roots/soil
 */
class Options {
  protected static $modules = [];
  protected $options = [];
  public static function init($module, $options = []) {
    if (!isset(self::$modules[$module])) {
      self::$modules[$module] = new static((array) $options);
    }
    return self::$modules[$module];
  }
  public static function getByFile($file) {
    if (file_exists($file) || file_exists(__DIR__ . '/modules/' . $file)) {
      return self::get('kokku-' . basename($file, '.php'));
    }
    return [];
  }
  public static function get($module) {
    if (isset(self::$modules[$module])) {
      return self::$modules[$module]->options;
    }
    if (substr($module, 0, 5) !== 'kokku-') {
      return self::get('kokku-' . $module);
    }
    return [];
  }
  protected function __construct($options) {
    $this->set($options);
  }
  public function set($options) {
    $this->options = $options;
  }
}

require_once __DIR__ . '/lib/utils.php';

function load_modules() {
  global $_wp_theme_features;
  // Skip loading modules in the admin.
  if (is_admin()) {
    return;
  }
  foreach (glob(__DIR__ . '/modules/*.php') as $file) {
    $feature = 'kokku-' . basename($file, '.php');
    if (isset($_wp_theme_features[$feature])) {
      Options::init($feature, $_wp_theme_features[$feature]);
      require_once $file;
    }
  }
}

add_action('after_setup_theme', __NAMESPACE__ . '\\load_modules', 100);
