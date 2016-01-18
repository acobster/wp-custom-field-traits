<?php

namespace Cft\Field;

class Text extends AbstractBase {
  public function getValue() {
    return $this->meta[0];
  }

  public function getMetaBox() {
    return "<input type=\"text\" name=\"{$this->name}\" value=\"{$this->getValue()}\">";
  }

  public function save() {
     update_post_meta( $this->getPostId(), $this->name, $this->getPostedValue() );
  }

  public function getPostedValue() {
    return $_POST[$this->name];
  }
}