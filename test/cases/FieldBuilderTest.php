<?php

namespace CftTest\TestCase;

require_once 'lib/Cft/FieldBuilder.php';
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

class FieldBuilderTest extends Base {
  protected $builder;

  public function setUp() {
    $this->builder = new FieldBuilder();
  }

  public function tearDown() {
    unset($this->builder);
  }

  public function testBuild() {
    $reflection = new \ReflectionClass($this->builder);
    $prop = $reflection->getProperty('types');
    $prop->setAccessible(true);
    $types = $prop->getValue($this->builder);

    foreach( $types as $type => $class ) {
      if ($type === 'select') {
        // Select will throw a Cft\Exception if options array not present
        $type = ['type' => 'select', 'options' => [1 => 'one', 2 => 'two']];
      }

      $field = $this->builder->build( 123, 'my_field', $type );
      $this->assertInstanceOf( $class, $field );
    }
  }

  public function testRegisterType() {
    $this->builder->registerType('foo', 'Foo');
    $this->builder->registerType('bar', '\Name\Space\Bar');

    $reflection = new \ReflectionClass($this->builder);
    $prop = $reflection->getProperty('types');
    $prop->setAccessible(true);
    $types = $prop->getValue($this->builder);

    $this->assertEquals( 'Foo', $types['foo'] );
    $this->assertEquals( '\Name\Space\Bar', $types['bar'] );
  }
}

