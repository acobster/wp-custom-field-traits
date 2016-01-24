<?php

namespace Cft\Field;

final class Factory {
  protected static $TYPES = [
    'text' => '\Cft\Field\Text',
    'number' => '\Cft\Field\Number',
    'email' => '\Cft\Field\Email',
    'password' => '\Cft\Field\Password',
    'url' => '\Cft\Field\Url',
    'textarea' => '\Cft\Field\TextArea',
    'wysiwyg' => '\Cft\Field\Wysiwyg',
  ];

  public static function build( $id, $name, $config, $value = '' ) {
    $type = is_array( $config )
      ? $config['type']
      : strval( $config );

    if( ! isset(static::$TYPES[$type]) ) {
      throw new \Cft\Exception("No such field type: $type");
    }

    $class = static::$TYPES[$type];

    return new $class($id, $name, $config, $value);
  }

  public static function registerType( $type, $className ) {
    if( ! isset(static::$TYPES[$type]) ) {
      static::$TYPES[$type] = $className;
    }
  }
}