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
      'bar' => [
        'type' => 'text',
        'label' => 'Bar',
        'attributes' => [
          'class' => 'bar-box',
        ],
      ],
      'baz' => 'text',
      'number_of_things' => 'number',
      'some_email' => 'email',
      'super_secure_password' => 'password',
      'my_website' => 'url',
      'qux' => [
        'type' => 'textarea',
        'label' => 'Q. U. X.',
        'attributes' => [
          'style' => 'background: rgba(128,128,128,.5);'
        ],
      ],
      'hello' => 'wysiwyg',
    ];
  }
}