<?php

namespace Cft\Validator;

use Cft\Field\AbstractBase as Field;

class Numeric extends AbstractBase {
  public function isValid(Field $field) {
    return is_numeric($field->getValue());
  }
}

