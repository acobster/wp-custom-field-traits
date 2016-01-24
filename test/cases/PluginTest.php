<?php

namespace CftTest\TestCase;

use \Cft\Plugin;

class PluginTest extends Base {
  protected $plugin;

  public function setUp() {
    parent::setUp();
    $this->plugin = \Cft\Plugin::getInstance();
  }

  public function tearDown() {
    parent::tearDown();
    unset($this->plugin);
  }

  public function testGetInstance() {
    $plugin1 = Plugin::getInstance();
    $class = get_class( $plugin1 );
    $this->assertEquals( $class, 'Cft\Plugin' );

    // make sure it's a true singleton
    $this->assertEquals( spl_object_hash($plugin1), spl_object_hash(Plugin::getInstance()) );
  }

  public function testSetAndGet() {
    $this->plugin->set('foo', 'bar');
    $this->assertEquals( $this->plugin->get('foo'), 'bar' );

    $func = function() {
      return 'I am a function.';
    };

    $this->plugin->set('func', $func);
    $this->assertEquals( $this->plugin->get('func'), 'I am a function.');
  }
}

?>