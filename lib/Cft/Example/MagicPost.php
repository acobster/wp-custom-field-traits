<?php

namespace Cft\Example;

class MagicPost {
  use \Cft\Traits\HasTextField { getFieldConfigs as protected; }
  use \Cft\Traits\HasMagicField;

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