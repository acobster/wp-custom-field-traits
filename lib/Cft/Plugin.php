<?php

namespace Cft;

/**
 * Simple Singleton Plugin class for bare-bones dependency injection
 */
final class Plugin {
  private static $instance;

  private $viewDirs = [
    CFT_PLUGIN_DIR
  ];

  public function getInstance() {
    if( ! self::$instance ) {
      self::$instance = new static();
    }

    return self::$instance;
  }

  // singleton constructor!
  private function __construct() { }

  public function get( $key ) {
    if( isset($this->{$key}) ) {
      return is_callable( $this->{$key} )
        ? call_user_func( $this->{$key} )
        : $this->{$key};
    }
  }

  public function set( $key, $value ) {
    $this->{$key} = $value;
  }
}