<?php

namespace CftTest\TestCase;

require_once 'lib/Cft/FieldBuilder.php';
require_once 'lib/Cft/ValidatorBuilder.php';
require_once 'lib/Cft/Field/AbstractBase.php';
require_once 'lib/Cft/Traits/Field/InMetaBox.php';
require_once 'lib/Cft/Field/Text.php';
require_once 'lib/Cft/Field/Email.php';
require_once 'lib/Cft/Field/Number.php';
require_once 'lib/Cft/Field/Password.php';
require_once 'lib/Cft/Field/TextArea.php';
require_once 'lib/Cft/Field/Url.php';
require_once 'lib/Cft/Field/Wysiwyg.php';

use \Cft\FieldBuilder;
use \Cft\ValidatorBuilder;
use \Cft\Plugin;

class FieldBuilderTest extends Base {
  protected $plugin;
  protected $builder;

  public function setUp() {
    $this->plugin = Plugin::getInstance();
    $this->plugin->set('validatorBuilder', new ValidatorBuilder($this->plugin));
    $this->builder = new FieldBuilder($this->plugin);
  }

  public function tearDown() {
    unset($this->builder);
  }

  public function testBuild() {
    $types = $this->getProtectedProperty($this->builder, 'types');

    foreach( $types as $type => $class ) {
      if ($type === 'select') {
        // Select will throw a Cft\Exception if options array not present
        $type = ['type' => 'select', 'options' => [1 => 'one', 2 => 'two']];
      }

      $field = $this->builder->build( 123, 'my_field', $type );
      $this->assertInstanceOf( $class, $field );
    }

    // test with some validators
    $requiredField = $this->builder->build( 123, 'required_field', [
      'type' => 'text',
      'validators' => ['required' => true]
    ]);
    $this->assertInstanceOf('\Cft\Field\Text', $requiredField);
    $this->assertInstanceOf('\Cft\Validator\Required', $requiredField->getValidators()[0]);
    $this->assertEquals(1, count($requiredField->getValidators()));
  }

  public function testRegisterType() {
    $this->builder->registerType('foo', 'Foo');
    $this->builder->registerType('bar', '\Name\Space\Bar');

    $types = $this->getProtectedProperty($this->builder, 'types');

    $this->assertEquals( 'Foo', $types['foo'] );
    $this->assertEquals( '\Name\Space\Bar', $types['bar'] );
  }
}

