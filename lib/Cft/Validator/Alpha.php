<?php

namespace Cft\Validator;

use Cft\Field\AbstractBase as Field;

class Alpha extends AbstractBase {
  public function isValid(Field $field) {
    return ctype_alpha($field->getValue());
  }
}

