<?php

namespace Cft\Validator;

use Cft\Field\AbstractBase as Field;
use Cft\Validator\Regex;

class AlphaNumeric extends Regex {
  public function __construct(array $config) {
    $config['pattern'] = '/^[a-z0-9]*$/i';
    parent::__construct($config);
  }

  public function isValid(Field $field) {
    return preg_match($this->pattern, $field->getValue());
  }
}

