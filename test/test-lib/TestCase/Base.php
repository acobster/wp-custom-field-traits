<?php

namespace CftTest\TestCase;

use \WP_Mock as WP;
use \Cft\Plugin;

/**
 * Base test class for the plugin. Declared abstract so that PHPUnit doesn't
 * complain about a lack of tests defined here.
 */
abstract class Base extends \PHPUnit_Framework_TestCase {
  public function setUp() {
    WP::setUp();
  }

  public function tearDown() {
    WP::tearDown();
  }


  protected function getProtectedProperty($object, $name) {
    $reflection = new \ReflectionClass($object);
    $property = $reflection->getProperty($name);
    $property->setAccessible(true);

    return $property->getValue($object);
  }
}

?>