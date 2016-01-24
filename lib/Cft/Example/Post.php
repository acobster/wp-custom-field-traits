<?php

namespace Cft\Example;

class Post {
  use \Cft\Traits\HasCustomFields { getFieldConfigs as protected; }

  protected $postId;
  protected $bar;
  protected $baz;

  public function __construct($postId) {
    $this->postId = $postId;
  }

  public function __get($var) {
    return $this->fetchPost($this->postId)->{$var};
  }

  protected function getFieldConfigs() {
    return [
      'bar' => 'text',
      'baz' => 'text',
      'number_of_things' => 'number',
      'some_email' => 'email',
      'super_secure_password' => 'password',
      'my_website' => 'url',
      'qux' => 'textarea',
      'hello' => 'wysiwyg',
    ];
  }
}