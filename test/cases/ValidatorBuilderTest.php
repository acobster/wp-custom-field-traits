<?php

namespace CftTest\TestCase;

require_once 'lib/Cft/FieldBuilder.php';
require_once 'lib/Cft/ValidatorBuilder.php';
require_once 'lib/Cft/Validator/Alpha.php';
require_once 'lib/Cft/Validator/AlphaNumeric.php';
require_once 'lib/Cft/Validator/Numeric.php';
require_once 'lib/Cft/Validator/MinLength.php';
require_once 'lib/Cft/Validator/MaxLength.php';
require_once 'lib/Cft/Validator/Email.php';
require_once 'lib/Cft/Validator/Callback.php';

require_once 'lib/Cft/Field/AbstractBase.php';
require_once 'lib/Cft/Traits/Field/InMetaBox.php';
require_once 'lib/Cft/Field/Text.php';
require_once 'lib/Cft/Field/Email.php';
require_once 'lib/Cft/Field/Number.php';
require_once 'lib/Cft/Field/Password.php';
require_once 'lib/Cft/Field/TextArea.php';
require_once 'lib/Cft/Field/Url.php';
require_once 'lib/Cft/Field/Wysiwyg.php';

use \Cft\ValidatorBuilder;
use \Cft\Plugin;

class ValidatorBuilderTest extends Base {
  protected $plugin;
  protected $builder;

  public function setUp() {
    $this->plugin = Plugin::getInstance();
    $this->builder = new ValidatorBuilder($this->plugin);
  }

  public function tearDown() {
    unset($this->builder);
  }

  public function testBuild() {
    $fn = function($input) { return $input; };

    $types = [
      'required' => ['class' => '\Cft\Validator\Required', 'config' => true],
      'regex' => ['class' => '\Cft\Validator\Regex', 'config' => '/^[a-z_0-9\s]+$/'],
      'alpha' => ['class' => '\Cft\Validator\Alpha', 'config' => true],
      'numeric' => ['class' => '\Cft\Validator\Numeric', 'config' => true],
      'alphanumeric' => ['class' => '\Cft\Validator\Alphanumeric', 'config' => true],
      'min_length' => ['class' => '\Cft\Validator\MinLength', 'config' => 25],
      'max_length' => ['class' => '\Cft\Validator\MaxLength', 'config' => 5],
      'email' => ['class' => '\Cft\Validator\Email', 'config' => true],
      'callback' => ['class' => '\Cft\Validator\Callback', 'config' => $fn],
    ];

    foreach( $types as $type => $validator ) {
      $this->assertInstanceOf(
        $validator['class'],
        $this->builder->build($type, $validator['config'])
      );
    }
  }

  public function testTransformConfig() {
    $fn = function($input) { return $input; };

    $cases = [
      [
        'inputArgs' =>  ['required', true],
        'output'    =>  []
      ],
      [
        'inputArgs' =>  ['alphanumeric', true],
        'output'    =>  []
      ],
      [
        'inputArgs' =>  ['email', true],
        'output'    =>  []
      ],
      [
        'inputArgs' =>  ['regex', '/abc/'],
        'output'    =>  ['pattern' => '/abc/']
      ],
      [
        'inputArgs' =>  ['max_length', 42],
        'output'    =>  ['max' => 42]
      ],
      [
        'inputArgs' =>  ['min_length', 3],
        'output'    =>  ['min' => 3]
      ],
      [
        'inputArgs' =>  ['callback', $fn],
        'output'    =>  ['callback' => $fn]
      ]
    ];

    foreach( $cases as $case ) {
      $this->assertEquals(
        $case['output'],
        $this->callProtectedMethod($this->builder, 'transformConfig', $case['inputArgs'])
      );
    }
  }

  public function testRegisterType() {
    $this->builder->registerType('foo', 'Foo');
    $this->builder->registerType('bar', '\Name\Space\Bar');

    $types = $this->getProtectedProperty($this->builder, 'types');

    $this->assertEquals( 'Foo', $types['foo'] );
    $this->assertEquals( '\Name\Space\Bar', $types['bar'] );
  }
}

