<?php

namespace Cft\Field;

final class Factory {
  protected static $TYPES = [
    'text' => '\Cft\Field\Text',
    'textarea' => '\Cft\Field\TextArea',
  ];

  public static function build( $id, $name, $config, array $meta = null ) {
    $type = is_array( $config )
      ? $config['type']
      : strval( $config );

    if( ! isset(static::$TYPES[$type]) ) {
      throw new \Cft\Exception("No such field type: $type");
    }

    $class = static::$TYPES[$type];

    return new $class($id, $name, $config, $meta);
  }

  public static function registerType( $type, $className ) {
    if( ! isset(static::$TYPES[$type]) ) {
      static::$TYPES[$type] = $className;
    }
  }
}