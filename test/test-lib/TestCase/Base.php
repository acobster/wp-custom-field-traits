<?php

namespace CftTest\TestCase;

use \WP_Mock as WP;
use \Cft\Plugin;

/**
 * Base test class for the plugin. Declared abstract so that PHPUnit doesn't
 * complain about a lack of tests defined here.
 */
abstract class Base extends \PHPUnit_Framework_TestCase {
  protected $plugin;

  public function setUp() {
    WP::setUp();
    $this->plugin = $this->configureCft( \Cft\Plugin::getInstance() );
  }

  public function tearDown() {
    WP::tearDown();
    unset($this->plugin);
  }


  protected function configureCft( $plugin ) {
    return $plugin;
  }
}

?>