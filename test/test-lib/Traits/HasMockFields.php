<?php

namespace CftTest\Traits;

trait HasMockFields {
  public function getField( $postId, $name, $config, $value = '' ) {
    $field = $this->getMockBuilder('Cft\Field\AbstractBase')
      ->setConstructorArgs( [$postId, $name, $config, $value] )
      ->getMockForAbstractClass();

    $field->expects( $this->once() )
      ->method( 'save' );

    return $field;
  }
}