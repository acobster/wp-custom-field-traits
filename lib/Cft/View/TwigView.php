<?php

namespace Cft\View;

use \Dust;

class TwigView extends AbstractBase {
  public function render( $file, $data ) {
    return $this->engine->render( $file, $data );
  }

  public function compile( $template, $data ) {
    $templateBody = $this->engine->compile( $template );
    return $this->engine->renderTemplate( $templateBody, $data );
  }
}

