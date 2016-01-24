<?php

namespace Cft;

/**
 * Simple Singleton Plugin class for bare-bones dependency injection
 */
final class Plugin {
  const ACTION_PRIORITY = 10;

  private static $instance;

  private $attributes = [];

  private $viewDirs = [
    CFT_PLUGIN_DIR
  ];

  public static function getInstance() {
    if( ! self::$instance ) {
      self::$instance = new Plugin();
    }

    return self::$instance;
  }

  // singleton constructor!
  private function __construct() { }

  public function get( $key ) {
    if( isset($this->attributes[$key]) ) {
      if( is_callable( $this->attributes[$key] ) ) {
        // Cache the value of the callable in object memory
        $this->attributes[$key] = call_user_func( $this->attributes[$key] );
      }

      return $this->attributes[$key];
    }
  }

  public function set( $key, $value ) {
    $this->attributes[$key] = $value;
  }
}