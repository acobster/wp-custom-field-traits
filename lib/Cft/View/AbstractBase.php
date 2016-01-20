<?php

namespace Cft\View;

abstract class AbstractBase {
  /**
   * Should return the rendered template markup based on the contents $file
   * @param  {string} $file the template file name
   * @param  {array} $data the view data
   * @return {string} the rendered template markup
   */
  abstract public function render( $file, $data );

  /**
   * Should render the $template markup directly and return the result
   * @param  string $template the literal template contents
   * @param  array $data the view data
   * @return  string the rendered template markup
   */
  abstract public function compile( $template, $data );

  /**
   * Should return an instance of the template class used internally,
   * such as \Dust\Dust
   * @return  object an internal template instance
   */
  abstract public function getInternalTemplate();
}