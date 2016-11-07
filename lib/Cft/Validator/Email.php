<?php

namespace Cft\Validator;

use \Cft\Field\AbstractBase as Field;

class Email extends AbstractBase {
  public function isValid(Field $field) {
    return filter_var($field->getValue(), FILTER_VALIDATE_EMAIL) !== false;
  }
}

