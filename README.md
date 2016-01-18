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
  use \Cft\HasCustomFields;
  
  protected static $cft_fields = [
    'my_field' => [] // defaults to an optional text field
  ];
}

MyPost::register_custom_fields();
```

## Code-centric

WP Custom Field Traits is for developers who want to manage custom field configuration through code rather than through the database. This is the most fundamental difference between it and ACF. This approach has two key advantages:

* It's faster
* It's easier to track your field configurations in source control, because they're already part of your code

Instead, this plugin defines traits that you can `use` in your own theme or plugin classes. Activating this plugin will not create a new admin panel for you to add fields to your posts. To get new fields on the back end, you still have to write your own code.

## Why Traits?

Traits have been around since PHP 5.4 (and OO PHP has been around even longer!), but WordPress development seldom takes advantage of this, typically favoring the imperative programming style. This can lead to all sorts of headaches, but the one I've found the most pervasive and the most counter-productive is the lack of reusability.

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


