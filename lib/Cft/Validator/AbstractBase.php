<?php

namespace Cft\Validator;

use \Cft\Field\AbstractBase as Field;

abstract class AbstractBase {
  const DEFAULT_ERROR_MESSAGE = 'Field is invalid';

  protected $config;
  protected $message;

  abstract public function isValid(Field $field);

  public function __construct(array $config) {
    $this->config = $config;
    $this->message = isset($config['message'])
      ? $config['message']
      : static::DEFAULT_ERROR_MESSAGE;
  }

  public function getErrorMessage() {
    return $this->message;
  }
}

