<?php

namespace Cft\Field;

use Cft\Plugin;

class TextArea extends AbstractBase {
  public function getValue() {
    return $this->meta[0];
  }

  public function getMetaBox() {
    $view = Plugin::getInstance()->get('view');

    return $view->render(
      'textarea.dust',
      [
        'name' => $this->getName(),
        'text' => $this->getValue(),
      ]
    );
  }

  public function save() {
     update_post_meta( $this->getPostId(), $this->getName(), $this->getPostedValue() );
  }

  public function getPostedValue() {
    return $_POST[$this->getName()];
  }
}