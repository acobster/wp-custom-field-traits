<?php

namespace Cft\Field;

use Cft\Plugin;

class Text extends AbstractBase {
  use \Cft\Traits\Field\InMetaBox;

  public function getValue() {
    return $this->meta[0];
  }

  public function render() {
    $view = Plugin::getInstance()->get('view');

    echo $view->render(
      'input.dust',
      [
        'name' => $this->getName(),
        'value' => $this->getValue(),
        'type' => $this->getType(),
      ]
    );
  }


}