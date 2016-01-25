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

  // encapsulate the HTTP request so that we can populate it explicitly,
  // with data from anywhere
  if( $_POST ) {
    $plugin->set('request', $_POST);
  }

  $plugin->set('fieldBuilder', new Cft\FieldBuilder());

  // where to look for view files
  $plugin->set('viewDirs', [CFT_PLUGIN_DIR . 'views/']);

  // how to render views
  $plugin->set('view', function() {
    $dust = new \Dust\Dust();

    $dust->filters['atts'] = new Cft\View\DustFilter( function( array $atts ) {
      $htmlAtts = [];
      foreach( $atts as $key => $value ) {
        // allow for specifying value-less attributes such as "disabled"
        // by passing literal true
        $htmlAtts[] = $value === true
          ? $key
          : "{$key}=\"{$value}\"";
      }

      return implode( ' ', $htmlAtts );
    });

    return new Cft\View\DustView( $dust );
  });

};

$_cft_plugin_init();


// Clear up the global namespace
unset($_cft_plugin_init);

