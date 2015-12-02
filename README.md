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
