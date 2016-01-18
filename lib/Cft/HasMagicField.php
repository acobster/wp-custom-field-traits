<?php

namespace Cft;

use Cft\Field\Factory;

trait HasMagicField {
  public function __get( $name ) {
    return $this->get( $name );
  }

  public function __set( $name, $value ) {
    $this->set( $name, $value );
  }
}
