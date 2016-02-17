<?php

namespace Cft\Field;

use \Cft\Plugin;

class Select extends AbstractBase {
  use \Cft\Traits\Field\InMetaBox;

  protected $type = 'select';

  public function __construct( $postId, $name, $config, $value = '' ) {
    if (!is_array($config)) {
      throw new \InvalidArgumentException(
        'config must be an array for Select instances');
    } elseif ( ! (isset($config['options']) and is_array($config['options'])) ) {
      throw new \InvalidArgumentException(
        'Select instances require an options array in $config');
    }

    parent::__construct( $postId, $name, $config, $value );
  }

  public function render() {
    $view = Plugin::getInstance()->get('view');

    $options = [];
    foreach ($this->getConfig('options') as $value => $label) {
      $options[] = ['value' => $value, 'label' => $label];
    }

    echo $view->render(
      'select.dust',
      [
        'name' => $this->getName(),
        'value' => $this->getValue(),
        'type' => $this->getType(),
        'attributes' => $this->getConfig('attributes'),
        'options' => $options,
      ]
    );
  }
}