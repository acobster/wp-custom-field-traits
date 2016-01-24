<?php

namespace CftTest\TestCase;

require 'lib/Cft/Traits/HasCustomFields.php';

use \WP_Mock as WP;
use \Cft\Plugin;
use \Cft\Traits\HasCustomFields;

class Traits_HasCustomFieldsTest extends Base {
  use \CftTest\Traits\HasMockFields;

  protected $subject;

  protected $postId = 123;

  public function testSaveWithInvalidNonce() {
    $instance = $this->getMockForTrait('\Cft\Traits\HasCustomFields');
    $instance->expects( $this->never() )
      ->method( 'getFieldConfigs' );

    WP::wpFunction( 'wp_verify_nonce', [
      'args' => ['post/save', 'cft_nonce'],
      'times' => 1,
      'return' => false
    ]);

    $instance->save();
  }

  public function testSave() {
    $instance = $this->getInstanceWithTrait([
      'foo' => 'text',
      'bar' => ['type' => 'text'],
      'baz' => 'textarea',
      'qux' => 'wysiwyg',
    ]);

    WP::wpFunction( 'wp_verify_nonce', [
      'args' => ['post/save', 'cft_nonce'],
      'times' => 1,
      'return' => 1
    ]);

    // Mock Field instances
    $foo = $this->getField( $this->postId, 'foo', 'text', 'I am FOO' );
    $bar = $this->getField( $this->postId, 'bar', ['type' => 'text'], 'I am BAR' );
    $baz = $this->getField( $this->postId, 'baz', 'textarea', 'I am BAZ' );
    $qux = $this->getField( $this->postId, 'qux', 'wysiwyg', 'I am QUX' );

    // Map FieldBuilder::build parameters to specific mock instances
    $map = [
      [$this->postId, 'foo', 'text', 'I am FOO', $foo],
      [$this->postId, 'bar', ['type' => 'text'], 'I am BAR', $bar],
      [$this->postId, 'baz', 'textarea', 'I am BAZ', $baz],
      [$this->postId, 'qux', 'wysiwyg', 'I am QUX', $qux],
    ];

    $builder = $this->getMock('\Cft\FieldBuilder');
    $builder->expects( $this->exactly(4) )
      ->method( 'build' )
      ->with( $this->postId, 'foo', 'text', 'I am FOO' )
      ->will( $this->returnValueMap($map) );

    Plugin::getInstance()->set('fieldBuilder', $builder);

    $instance->save();
  }


  protected function getInstanceWithTrait( $config ) {
    $instance = $this->getMockForTrait('\Cft\Traits\HasCustomFields');
    $instance->expects( $this->any() )
      ->method( 'getFieldConfigs' )
      ->will( $this->returnValue($config) );

    return $instance;
  }
}