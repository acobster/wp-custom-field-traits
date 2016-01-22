<?php

define( 'CFT_PLUGIN_DIR', realpath(__DIR__.'/../') );

require_once 'vendor/autoload.php';
require_once 'lib/Cft/Plugin.php';

spl_autoload_register(function($className) {
  $components = explode('\\', $className);

  if( array_shift($components) == 'CftTest' ) {
    $file = 'test/test-lib/' . implode('/', $components) . '.php';

    if( file_exists($file) ) {
      require $file;
    }
  }
});


?>