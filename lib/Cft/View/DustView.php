<?php

namespace Cft\View;

use \Dust;

class DustView extends AbstractBase {
  public function render( $file, $data ) {
    $templateBody = $this->engine->compileFile( $this->getViewPath($file) );

    if( ! isset($templateBody) ) {
      throw new Dust\DustException( "Template not found: {$file}" );
    }

    return $this->engine->renderTemplate( $templateBody, $data );
  }

  public function compile( $template, $data ) {
    $templateBody = $this->engine->compile( $template );
    return $this->engine->renderTemplate( $templateBody, $data );
  }
}
