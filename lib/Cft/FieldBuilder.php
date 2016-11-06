<?php

namespace Cft;

class FieldBuilder {
  protected $plugin;
  protected $validatorBuilder;

  protected $types = [
    'text' => '\Cft\Field\Text',
    'number' => '\Cft\Field\Number',
    'email' => '\Cft\Field\Email',
    'password' => '\Cft\Field\Password',
    'url' => '\Cft\Field\Url',
    'textarea' => '\Cft\Field\TextArea',
    'select' => '\Cft\Field\Select',
    'wysiwyg' => '\Cft\Field\Wysiwyg',
  ];

  public function __construct(Plugin $plugin) {
    $this->plugin = $plugin;
    $this->validatorBuilder = $plugin->get('validatorBuilder');
  }

  public function build( $id, $name, $config, $value = '' ) {
    // get type from config, or take it as a string for shorthand
    $type = is_array($config)
      ? $config['type']
      : strval($config);

    if( ! isset($this->types[$type]) ) {
      throw new \Cft\Exception("No such field type: {$type}");
    }

    $class = $this->types[$type];

    $field = new $class($id, $name, $config, $value);

    // attach validators
    if( isset($config['validators']) ) {
      if( ! is_array($config['validators'])) {
        throw new Exception('`validators` must be an array');
      }

      foreach( $config['validators'] as $type => $validatorConfig ) {
        if ($validatorConfig) {
          $field->attachValidator( $this->validatorBuilder->build($type, $validatorConfig) );
        }
      }
    }

    return $field;
  }

  public function registerType( $type, $className ) {
    if( ! isset($this->types[$type]) ) {
      $this->types[$type] = $className;
    }
  }
}