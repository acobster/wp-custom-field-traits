<?php

namespace CftTest\TestCase;

use \WP_Mock as WP;
use \Cft\Plugin;
use PHPUnit\Framework\TestCase;

/**
 * Base test class for the plugin. Declared abstract so that PHPUnit doesn't
 * complain about a lack of tests defined here.
 */
abstract class Base extends TestCase {
  protected $plugin;

  public function setUp() {
    WP::setUp();
    $this->plugin = \Cft\Plugin::getInstance();
    $this->plugin->set('validatorBuilder', new \Cft\ValidatorBuilder($this->plugin));
    $this->plugin->set('fieldBuilder', new \Cft\FieldBuilder($this->plugin));
  }

  public function tearDown() {
    WP::tearDown();
    unset($this->plugin);
  }


  protected function getProtectedProperty($object, $name) {
    $reflection = new \ReflectionClass($object);
    $property = $reflection->getProperty($name);
    $property->setAccessible(true);

    return $property->getValue($object);
  }

  protected function callProtectedMethod($object, $name, $args = []) {
    $reflection = new \ReflectionClass($object);
    $method = $reflection->getMethod($name);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $args);
  }
}

?>
