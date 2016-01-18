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
    $this->meta = $meta;
  }

  abstract public function getValue();
  abstract public function save();
  abstract public function getPostedValue();
  abstract public function getMetaBox();

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

  public function addMetaBox( $type = null ) {
    add_meta_box(
      $this->getHtmlId(),
      $this->getTitle(),
      [$this, 'renderMetaBox'],
      $type
    );
  }

  public function renderMetaBox() {
    echo $this->getMetaBox();
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