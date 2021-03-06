<?php

namespace Cft\Field;

use Cft\Plugin;

class TextArea extends AbstractBase {
  use \Cft\Traits\Field\InMetaBox;

  public function render() {
    $view = Plugin::getInstance()->get('view');

    echo $view->render(
      'textarea.twig',
      [
        'name' => $this->getName(),
        'text' => $this->getValue(),
        'attributes' => $this->getConfig('attributes'),
      ]
    );
  }


}