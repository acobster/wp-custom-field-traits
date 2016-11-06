<?php

namespace Cft;

class ValidatorBuilder {
  protected $plugin;

  protected $types = [
    'required' => '\Cft\Validator\Required',
    'regex' => '\Cft\Validator\Regex',
    'alpha' => '\Cft\Validator\Alpha',
    'numeric' => '\Cft\Validator\Numeric',
    'alphanumeric' => '\Cft\Validator\Alphanumeric',
    'min_length' => '\Cft\Validator\MinLength',
    'max_length' => '\Cft\Validator\MaxLength',
    'email' => '\Cft\Validator\Email',
    'function' => '\Cft\Validator\Function',
  ];

  public function __construct(Plugin $plugin) {
    $this->plugin = $plugin;
  }

  public function build( $type, $config = [] ) {
    if( ! isset($this->types[$type]) ) {
      throw new Exception("No such validator type: {$type}");
    }

    $class = $this->types[$type];
    return new $class($this->transformConfig($config));
  }

  public function registerType( $type, $className ) {
    if ( ! isset($this->types[$type]) ) {
      $this->types[$type] = $className;
    }
  }

  protected function transformConfig($config) {
    if( ! is_array($config) ) {
      $config = [];
    }

    return $config;
  }
}