<?php

namespace Cft\Field;

use \Cft\Exception;

abstract class AbstractBase {
  const HTML_PREFIX = 'cft-';

  protected $type;
  protected $postId;
  protected $name;
  protected $config;
  protected $value;

  public function __construct( $postId, $name, $config, $value = '' ) {
    if( is_array($config) && empty($config['type']) ) {
      throw new Exception('invalid config: no type specified');
    }

    $this->postId = $postId;
    $this->name = $name;
    $this->config = $config;

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

  public function save() {
     return update_post_meta( $this->getPostId(), $this->getName(), $this->getValue() );
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