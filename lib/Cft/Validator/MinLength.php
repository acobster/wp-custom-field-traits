<?php

namespace Cft\Validator;

use \Cft\Field\AbstractBase as Field;
use \Cft\Exception;

class MinLength extends AbstractBase {
  protected $min;

  public function __construct(array $config) {
    if( !isset($config['min']) || !is_int($config['min']) || $config['min'] < 1) {
      throw new Exception('MinLength validators must be configured with a non-zero integer `min` value');
    }

    parent::__construct($config);
    $this->min = $config['min'];
  }

  public function isValid(Field $field) {
    return strlen($field->getValue()) >= $this->min;
  }
}

