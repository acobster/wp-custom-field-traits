<?php

namespace Cft\Validator;

use Cft\Field\AbstractBase as Field;

class AlphaNumeric extends AbstractBase {
  public function isValid(Field $field) {
    return ctype_alnum($field->getValue());
  }
}

