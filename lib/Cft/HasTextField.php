<?php

namespace Cft;

trait HasTextField {
  use HasField;

  protected $type = 'text';
}