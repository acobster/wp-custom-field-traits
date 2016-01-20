<?php

namespace Cft\Field;

use Cft\View\DustView;

class Text extends AbstractBase {
  public function getValue() {
    return $this->meta[0];
  }

  public function getMetaBox() {
    $template = new DustView();
    return $template->render(
      CFT_PLUGIN_DIR . 'views/input.dust',
      [
        'name' => $this->getName(),
        'value' => $this->getValue(),
        'type' => $this->getType(),
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