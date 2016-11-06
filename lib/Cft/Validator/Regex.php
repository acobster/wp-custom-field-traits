<?php

namespace Cft\Validator;

use \Cft\Field\AbstractBase as Field;
use \Cft\Exception;

class Regex extends AbstractBase {
  protected $pattern;

  public function __construct(array $config) {
    if( !isset($config['pattern']) || !is_string($config['pattern']) ) {
      throw new Exception('Regex validators must be configured with a `pattern` string value');
    }

    parent::__construct($config);
    $this->pattern = $config['pattern'];
  }

  public function isValid(Field $field) {
    return preg_match($this->pattern, $field->getValue());
  }
}

