<?php
/*
 * Plugin Name: WP Custom Field Traits
 * Description: A unique OO approach to custom WordPress fields
 * Author: Coby Tamayo
 * Author URI: http://tamayoweb.net
 */

define('CFT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CFT_ACTION_PRIORITY', 10);

spl_autoload_register(function($className) {
  $path = str_replace('\\', '/', $className);

  $dir = CFT_PLUGIN_DIR . 'lib/';

  if( file_exists("{$dir}/{$path}.php") ) {
    require "{$dir}/{$path}.php";
  }
});

$plugin = Cft\Plugin::getInstance();



/*
 * Set up sane, overrideable defaults for dependency injection
 */


// where to look for view files
$plugin->set('viewDirs', [CFT_PLUGIN_DIR . 'views/']);

// how to render views
$plugin->set('view', function() {
  return new Cft\View\DustView( new \Dust\Dust() );
});

Cft\Example\Post::hasCustomFields('post');

// $post = new Cft\Example\Post(1);
// $post->hydrate();

// $magic = new Cft\Example\MagicPost(1);
// $magic->hydrate();

// echo <<<_HTML_
// <h1>Regular post</h1>

// <p><code>\$post->get('bar')</code>: {$post->get('bar')}</p>
// <p><code>\$post->get('baz')</code>: {$post->get('baz')}</p>

// <h1>Magic post</h1>

// <p><code>\$magic->bar</code>: {$magic->bar}</p>
// <p><code>\$magic->baz</code>: {$magic->baz}</p>
// _HTML_;

// die();
