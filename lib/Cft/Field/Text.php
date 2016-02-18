<?php

namespace Cft\Field;

use Cft\Plugin;

class Text extends AbstractBase {
  use \Cft\Traits\Field\InMetaBox;

  public function render() {
    $view = Plugin::getInstance()->get('view');

    echo $view->render(
      'input.twig',
      [
        'name' => $this->getName(),
        'value' => $this->getValue(),
        'type' => $this->getType(),
        'attributes' => $this->getConfig('attributes') ?: [],
      ]
    );
  }
}
