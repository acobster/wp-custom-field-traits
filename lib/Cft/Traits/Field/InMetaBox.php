<?php

namespace Cft\Traits\Field;

trait InMetaBox {
  public function register() {
    add_meta_box(
      $this->getHtmlId(),
      $this->getTitle(),
      [$this, 'render'],
      $type
    );
  }
}