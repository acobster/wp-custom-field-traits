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

    Plugin::getInstance()->set('request', [
      'cft_nonce' => 'asdf'
    ]);

    WP::wpFunction( 'wp_verify_nonce', [
      'args' => ['asdf', 'cft_save_meta'],
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
      'args' => ['nonce value', 'cft_save_meta'],
      'times' => 1,
      'return' => 1
    ]);

    Plugin::getInstance()->set('request', [
      'cft_nonce' => 'nonce value',
      'foo' => 'I am FOO',
      'bar' => 'I am BAR',
      'baz' => 'I am BAZ',
      'qux' => 'I am QUX',
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

    $builder = $this->getMockBuilder('\Cft\FieldBuilder')
      ->setMethods(['build'])
      ->getMock();

    $builder->method( 'build' )
      ->will( $this->returnValueMap($map) );

    Plugin::getInstance()->set('fieldBuilder', $builder);

    $instance->save();
  }


  protected function getInstanceWithTrait( $config ) {
    $instance = $this->getMockForTrait('\Cft\Traits\HasCustomFields');
    $instance->expects( $this->any() )
      ->method( 'getFieldConfigs' )
      ->will( $this->returnValue($config) );

    $reflection = new \ReflectionClass( $instance );
    $id = $reflection->getProperty( 'postId' );
    $id->setAccessible( true );
    $id->setValue( $instance, $this->postId );

    return $instance;
  }
}