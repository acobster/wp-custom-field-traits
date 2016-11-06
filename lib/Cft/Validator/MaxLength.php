<?php

namespace Cft\Validator;

use \Cft\Field\AbstractBase as Field;
use \Cft\Exception;

class MaxLength extends AbstractBase {
  protected $max;

  public function __construct(array $config) {
    if( !isset($config['max']) || !is_int($config['max']) || $config['max'] < 1) {
      throw new Exception('MaxLength validators must be configured with a non-zero integer `max` value');
    }

    parent::__construct($config);
    $this->max = $config['max'];
  }

  public function isValid(Field $field) {
    return strlen($field->getValue()) <= $this->max;
  }
}

