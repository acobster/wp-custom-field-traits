<?php

namespace Cft\Validator;

use \Cft\Field\AbstractBase as Field;

class Required extends AbstractBase {
  public function isValid(Field $field) {
    return ! empty($field->getValue());
  }
}

