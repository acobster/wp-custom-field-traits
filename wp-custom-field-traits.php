<?php
/*
 * Plugin Name: WP Custom Field Traits
 * Description: A unique OO approach to custom WordPress fields
 * Author: Coby Tamayo
 * Author URI: http://tamayoweb.net
 */

define('CFT_PLUGIN_DIR', plugin_dir_path(__FILE__));

spl_autoload_register(function($className) {
  $path = str_replace('\\', '/', $className);

  $dir = CFT_PLUGIN_DIR . 'lib/';

  if( file_exists("{$dir}/{$path}.php") ) {
    require "{$dir}/{$path}.php";
  }
});



$_cft_plugin_init = function() {

  /*
   * Set up sane, overrideable defaults for dependency injection
   */
  $plugin = Cft\Plugin::getInstance();

  // where to look for view files
  $plugin->set('viewDirs', [CFT_PLUGIN_DIR . 'views/']);

  // how to render views
  $plugin->set('view', function() {
    return new Cft\View\DustView( new \Dust\Dust() );
  });

};

$_cft_plugin_init();


// Clear up the global namespace
unset($_cft_plugin_init);

