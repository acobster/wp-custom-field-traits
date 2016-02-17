<?php

namespace CftTest\Traits;

trait RendersMetaBox {
  public function getRendered( $renderFunc ) {
    ob_start();
    $renderFunc();
    return ob_get_clean();
  }
}