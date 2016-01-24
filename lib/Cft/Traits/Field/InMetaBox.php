<?php

namespace Cft\Traits\Field;

trait InMetaBox {
  public function register( $postType ) {
    add_meta_box(
      $this->getHtmlId(),
      $this->getLabel(),
      [$this, 'render'],
      $postType
    );
  }
}