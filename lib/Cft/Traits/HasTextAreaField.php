<?php

namespace Cft\Traits;

trait HasTextAreaField {
  use HasField;

  protected $type = 'textarea';
}