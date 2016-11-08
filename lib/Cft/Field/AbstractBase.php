<?php

namespace Cft\Field;

use \Cft\Validator\AbstractBase as Validator;
use \Cft\Exception;
use \Cft\Exception\ValidationError;

abstract class AbstractBase {
  const HTML_PREFIX = 'cft-';

  protected $type;
  protected $postId;
  protected $name;
  protected $config;
  protected $value;

  protected $validators;
  protected $errors;

  public function __construct( $postId, $name, $config, $value = '' ) {
    if( is_array($config) && empty($config['type']) ) {
      throw new Exception('invalid config: no type specified');
    }

    $this->postId = $postId;
    $this->name = $name;
    $this->config = $config;
    $this->validators = [];

    $this->type = is_array($config)
      ? $config['type']
      : $config;

    $this->value = $value;
  }


  /**
   * Register this field to render in the admin
   */
  abstract public function register( $postType );

  /**
   * Render this field in the admin
   */
  abstract public function render();


  public function getValue() {
    // Assume value is scalar. If you need to store an array,
    // use a more specialized field type for that.
    if( is_array($this->value) && isset($this->value[0]) ) {
      return $this->value[0];
    }

    return $this->value;
  }

  public function setValue( $value ) {
    $this->value = $value;
  }

  public function getName() {
    return $this->name;
  }

  public function getType() {
    return $this->type;
  }

  public function getPostId() {
    return $this->postId;
  }

  public function getErrors() {
    return $this->errors;
  }

  public function getValidators() {
    return $this->validators;
  }

  public function save() {
    $this->clearErrors();

    if (!$this->validate()) {
      return false;
    }

    return update_post_meta( $this->getPostId(), $this->getName(), $this->getValue() );
  }

  public function validate() {
    return array_reduce($this->validators, function($valid, $validator) {
      if( ! $fieldValid = $validator->isValid($this) ) {
        $this->errors[] = $validator->getErrorMessage();
      }

      $valid = $fieldValid && $valid;

      return $valid;
    }, true);
  }

  public function attachValidator(Validator $validator) {
    $this->validators[] = $validator;
  }

  public function clearErrors() {
    $this->errors = [];
  }

  protected function getHtmlId() {
    return static::HTML_PREFIX . $this->getName();
  }

  protected function getLabel() {
    return $this->getConfig('label') ?: $this->getName();
  }

  protected function getConfig( $key ) {
    return isset($this->config[$key]) ? $this->config[$key] : null;
  }
}