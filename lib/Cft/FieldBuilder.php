<?php

namespace Cft;

class FieldBuilder {
  protected $types = [
    'text' => '\Cft\Field\Text',
    'number' => '\Cft\Field\Number',
    'email' => '\Cft\Field\Email',
    'password' => '\Cft\Field\Password',
    'url' => '\Cft\Field\Url',
    'textarea' => '\Cft\Field\TextArea',
    'wysiwyg' => '\Cft\Field\Wysiwyg',
  ];

  public function build( $id, $name, $config, $value = '' ) {
    $type = is_array($config)
      ? $config['type']
      : strval($config);

    if( ! isset($this->types[$type]) ) {
      throw new \Cft\Exception("No such field type: {$type}");
    }

    $class = $this->types[$type];

    return new $class($id, $name, $config, $value);
  }

  public function registerType( $type, $className ) {
    if( ! isset($this->types[$type]) ) {
      $this->types[$type] = $className;
    }
  }
}