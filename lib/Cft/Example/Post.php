<?php

namespace Cft\Example;

class Post {
  use \Cft\Traits\HasTextField { getFieldConfigs as protected; }

  protected $postId;
  protected $bar;
  protected $baz;

  public function __construct($postId) {
    $this->postId = $postId;
  }

  protected function getFieldConfigs() {
    return [
      'bar' => 'text',
      'baz' => 'text',
      'qux' => 'textarea',
    ];
  }
}