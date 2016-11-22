<?php

error_reporting(E_ALL);

Cft\Example\Post::hasCustomFields('post');


/**
 * Log some debug message in the PHP/WP error log
 * @param  mixed $message anything that can be var_export'ed
 */
function debug($message) {
  if(!is_string($message)) {
    $message = var_export($message,true);
  }

  // break up message by line and prefix each one
  error_log( implode("\n", array_map(function($line) {
    return "debug $line";
  }, explode("\n", $message))));
}

/**
 * Variadic (sprintf() style) version of debug(). Calls sprintf() internally.
 */
function sdebug() {
  debug(call_user_func_array('sprintf', func_get_args()));
}