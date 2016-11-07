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
    'callback' => '\Cft\Validator\Callback',
  ];

  protected $configTransforms;

  public function __construct(Plugin $plugin) {
    $this->plugin = $plugin;
    
    $this->configTransforms = [
      'required' => function() { return []; },

      'regex' => function($config) {
        if(is_string($config)) {
          $config = ['pattern' => $config];
        }
        return $config;
      },

      'max_length' => function($config) {
        if( is_int($config) ) {
          $config = ['max' => $config];
        }
        return $config;
      },

      'min_length' => function($config) {
        if( is_int($config) ) {
          $config = ['min' => $config];
        }
        return $config;
      },

      'callback' => function($config) {
        if( is_callable($config) ) {
          $config = ['callback' => $config];
        }
        return $config;
      },
    ];
  }

  public function build( $type, $config = [] ) {
    if( ! isset($this->types[$type]) ) {
      throw new Exception("No such validator type: {$type}");
    }

    $class = $this->types[$type];
    return new $class($this->transformConfig($type, $config));
  }

  public function registerType( $type, $className ) {
    if ( ! isset($this->types[$type]) ) {
      $this->types[$type] = $className;
    }
  }

  protected function transformConfig($type, $config) {
    if( isset($this->configTransforms[$type]) ) {
      $config = $this->configTransforms[$type]($config);
    }

    if( ! is_array($config) ) {
      $config = [];
    }

    return $config;
  }
}