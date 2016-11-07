<?php

namespace Cft\Validator;

use \Cft\Field\AbstractBase as Field;
use \Cft\Exception;

class Callback extends AbstractBase {
  protected $callable;

  public function __construct(array $config) {
    if( !isset($config['callback']) || !is_callable($config['callback']) ) {
      throw new Exception('Callable validators must be configured with a valid callable');
    }

    $this->callable = $config['callback'];
    parent::__construct($config);
  }

  public function isValid(Field $field) {
    return call_user_func($this->callable, $field->getValue());
  }
}

