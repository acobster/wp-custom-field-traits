# WP Custom Field Traits

A unique, object-oriented approach to custom WordPress fields. Heavily inspired by the awesome [Advanced Custom Fields](http://www.advancedcustomfields.com/) plugin.

This plugin is:

* Object-oriented
* Highly decoupled
* Code-centric

If these terms scare you, you are probably barking up the wrong tree. :) On the other hand, if you already know why it sucks to rely on the database to get custom field configurations, read on...

## Example

```
class MyPost {
  use \Cft\HasTextField;
  
  public getFieldConfigs(
    return [
      'my_field' => 'text' // defaults to an optional text field
    ];
  );
}

MyPost::hasCustomFields();
```

## Code-centric

WP Custom Field Traits is for developers who want to manage custom field configuration through code rather than through the database. This is the most fundamental difference between it and ACF. This approach has two key advantages:

* It's faster
* It's easier to track your field configurations in source control, because they're already part of your code

Instead, this plugin defines traits that you can `use` in your own theme or plugin classes. Activating this plugin will not create a new admin panel for you to add fields to your posts. To get new fields on the back end, you still have to write your own code.

While this is the plugin's biggest drawback, it is also its sharpest advantage: a skilled programmer can set up a group of custom fields in as much time as it would take to configure an ACF group--or less. The result will perform better than ACF because it doesn't have to go to the database just to know which meta fields to query. It's all right there in the code. This also means that deployment to staging/production/wherever is a breeze: if the code is there, It Just Works.

## Why Traits?

Traits have been around since PHP 5.4 (and OO PHP has been around even longer!), but WordPress development seldom takes advantage of this, typically favoring the imperative programming style. This can lead to all sorts of headaches, but the one I've found the most pervasive and the most counter-productive is the lack of reusability.

Say you've got a simple custom post type, `robot`. Each robot has a name, a standard greeting, and a disposition (for example, "homicidal"), and you want these to be driven by custom meta boxes. If you're in standard procedural WordPress land, you'll probably declare all this straight in your functions.php:

```
register_post_type('robot', ['label' => 'Robots', ...]);

add_action('add_meta_boxes', function() {
  wp_nonce_field('save_robot', 'robot_nonce');
  add_meta_box(
    'robot-meta',
    __("This Robot's Characteristics"),
    'render_robot_meta_boxes',
    'robot'
  );
});

add_action('save_post_robot', function($id) {
  if( ! wp_verify_nonce($_POST['save_robot'], 'save_robot') ) return;

  save_post_meta($id, 'name', $_POST['robot_name']);
  save_post_meta($id, 'greeting', $_POST['robot_greeting']);
  save_post_meta($id, 'disposition', $_POST['robot_disposition']);
}, 10 , 3);

function render_robot_meta_boxes() {
  // I won't bore you.
}
```

OK, so that's not so bad. But what happens when you get two or three more custom post types you need to manage, and each of them has their own custom meta boxes? That's, like, nine inputs to render yourself! Hey, why isn't this field saving? Oh, there's a typo in the input markup, because yeah you still had to type that all our yourself.

This is the part in the infomercial where the distraught customer says...

### There's got to be a better way!

Try this:

```
// functions.php
include 'Robot.php';
Robot::register();

// Robot.php
class Robot {
  use \Cft\Traits\HasTextField;

  public static function register() {
    register_post_type('robot', ['label' => 'Robots', ...]);
    self::hasCustomFields('robot');
  }
  
  public function getFieldConfigs() {
    return [
      'name' => 'text',
      'greeting' => 'text',
      'disposition' => 'text'
    ];
  }
}
```

Now isn't that nice?

## Contributing

First install the repo and dev dependencies:

```
$ git clone wp-custom-field-traits
$ cd wp-custom-field-traits
$ npm install
$ grunt install
```

This will prompt you for your local root MySQL password create a new database and user (see Gruntfile). Using some (really insecure) credentials it will install WordPress for you and finally start a server at localhost:8000.

This ought to go without saying, but...

#### DO NOT use this process to install WordPress on a public-facing server!

### Advanced Installation

The `grunt install` task is really just a very thin wrapper around a couple `mysql` and `wp-cli` commands. If you want a custom WP installation for your own dev workflow, just create a MySQL database and WP installation as you normally would. For convenience, `grunt composer` will create a `vendor/bin/wp` script for you so you can do stuff like this to install WordPress:

```
$ cd wordpress
$ ../vendor/bin/wp core config --prompt
$ ../vendor/bin/wp core install --prompt
```

## TODO

#### Currently this only supports basic text fields, with no configuration.

2. Bootstrap testing workflow (PHPUnit, WP_UnitTestCase, QUnit/Jasmine/Karma?)
3. Implement text field configurations
3. Implement fields:
	* textarea
	* number
	* email
	* url
	* password
	* wysiwyg
	* image (with crop option)
	* file
	* gallery
	* select
	* checkbox
	* radio
	* link picker
	* post
	* taxonomy
	* user
	* map
	* date/time pickers
	* color picker
4. Implement other goodies:
	* message
	* tabs
	* repeater


