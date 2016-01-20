<?php

namespace Cft\Traits;

trait HasTextField {
  use HasField;

  protected $type = 'text';
}