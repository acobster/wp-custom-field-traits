<?php

namespace Cft\View;

use \Dust;

class DustView extends AbstractBase {
  public function render( $file, $data ) {
    $dust = $this->getInternalTemplate();
    $templateBody = $dust->compileFile( $file );

    if( ! isset($templateBody) ) {
      throw new Dust\DustException( "Template not found: {$file}" );
    }

    return $dust->renderTemplate( $templateBody, $data );
  }

  public function compile( $template, $data ) {
    $dust = $this->getInternalTemplate();
    $templateBody = $dust->compile( $template );
    return $dust->renderTemplate( $templateBody, $data );
  }

  public function getInternalTemplate() {
    return new Dust\Dust();
  }
}

