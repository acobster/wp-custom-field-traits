<?php

namespace CftTest;

require 'lib/Cft/FieldBuilder.php';
require 'lib/Cft/Field/AbstractBase.php';
require 'lib/Cft/Field/Email.php';
require 'lib/Cft/Field/Number.php';
require 'lib/Cft/Field/Password.php';
require 'lib/Cft/Field/Text.php';
require 'lib/Cft/Field/TextArea.php';
require 'lib/Cft/Field/Url.php';
require 'lib/Cft/Field/Wysiwyg.php';

use \Cft\FieldBuilder;

class FieldBuilderTest extends Base {
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
    $types = $prop->getValue();

    foreach( $types as $type => $class ) {
      $field = $this->builder->build( $type );
      $this->assertInstanceOf( $class, $field );
    }
  }

  public function testRegisterType() {
    $this->builder->registerType('foo', 'Foo');
    $this->builder->registerType('bar', '\Name\Space\Bar');

    $reflection = new \ReflectionClass($this->builder);
    $prop = $reflection->getProperty('types');
    $prop->setAccessible(true);
    $types = $prop->getValue();

    $this->assertEquals( $types['foo'], 'Foo' );
    $this->assertEquals( $types['bar'], '\Name\Space\Bar' );
  }
}