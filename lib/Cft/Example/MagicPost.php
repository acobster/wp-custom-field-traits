<?php

namespace Cft\Example;

class MagicPost {
  use \Cft\HasTextField { getFieldConfigs as protected; }
  use \Cft\HasMagicField;

  protected $postId;

  public function __construct($postId) {
    $this->postId = $postId;
  }

  protected function getFieldConfigs() {
    return [
      'bar' => 'text',
      'baz' => 'text',
    ];
  }
}