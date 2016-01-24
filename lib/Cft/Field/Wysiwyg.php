<?php

namespace Cft\Field;

use Cft\Plugin;

class Wysiwyg extends AbstractBase {
  public function getValue() {
    return $this->meta[0];
  }

  public function register( $postType ) {
    add_action( 'edit_form_advanced', [$this, 'render'] );
  }

  public function render() {
    wp_editor(
      $this->getValue(),
      $this->getHtmlId(),
      [ 'textarea_name' => $this->getName() ]
    );
  }

  /**
   * Special implementation required here, since the id "may only contain lowercase
   * letters and underscores...hyphens will cause editor to not display properly"
   *
   * @see https://codex.wordpress.org/Function_Reference/wp_editor
   */
  protected function getHtmlId() {
    $id = 'cft_editor_' . $this->getName();
    return preg_replace( '/[^a-z_]/i', '_', $id );
  }
}