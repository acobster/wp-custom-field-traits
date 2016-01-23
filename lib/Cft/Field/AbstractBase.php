<?php

namespace Cft\Field;

abstract class AbstractBase {
  const HTML_PREFIX = 'cft-';

  protected $type;
  protected $postId;
  protected $name;
  protected $config;
  protected $meta;
  protected $value;

  public function __construct( $postId, $name, $config, array $meta = null ) {
    $this->postId = $postId;
    $this->name = $name;
    $this->config = $config;

    $this->type = is_array($config)
      ? $config['type']
      : $config;

    $this->meta = $meta;
  }

  /**
   * Get this field's current value
   */
  abstract public function getValue();

  /**
   * Register this field to render in the admin
   */
  abstract public function register( $postType );

  /**
   * Render this field in the admin
   */
  abstract public function render();

  /**
   * Save this field as metadata on the post
   */
  abstract public function save();

  /**
   * Get the new, user-submitted value to save
   */
  abstract public function getPostedValue();


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

  protected function getHtmlId() {
    return static::HTML_PREFIX . $this->getName();
  }

  protected function getTitle() {
    return $this->getConfig('title') ?: $this->getName();
  }

  protected function getConfig( $key ) {
    return isset($this->config[$key]) ? $this->config[$key] : null;
  }
}