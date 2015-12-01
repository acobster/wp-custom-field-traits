# WP Custom Field Traits
A unique, object-oriented approach to custom WordPress fields. Heavily inspired by the awesome [Advanced Custom Fields](http://www.advancedcustomfields.com/) plugin.

This plugin is:

* Object-oriented
* Highly decoupled
* Code-centric

If these terms scare you, you are probably barking up the wrong tree. :) On the other hand, if you already know why it sucks to rely on the database to get custom field configurations, read on...

## Code-centric

This plugin makes no additional database calls to get the configuration for your fields. This is the most fundamental difference between it and ACF.

## PHP Traits

Traits have been around since PHP 5.4 (and OO PHP has been around even longer!), but WordPress development seldom takes advantage of this, typically favoring the imperative programming style. This can lead to all sorts of headaches, but the one I've found the most pervasive and the most counter-productive is the lack of reusability.
