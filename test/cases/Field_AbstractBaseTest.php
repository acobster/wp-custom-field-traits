<?php

namespace CftTest\TestCase;

use CftTest\Traits\HasMockValidators;

require_once 'lib/Cft/Field/AbstractBase.php';
require_once 'lib/Cft/ValidatorBuilder.php';
require_once 'lib/Cft/Validator/AbstractBase.php';
require_once 'lib/Cft/Validator/Required.php';
require_once 'lib/Cft/Validator/Regex.php';
require_once 'lib/Cft/Validator/AlphaNumeric.php';
require_once 'lib/Cft/Validator/MaxLength.php';
require_once 'lib/Cft/Exception.php';

use \WP_Mock as WP;
use \Cft\Field\AbstractBase;
use \Cft\Validator;

class Field_AbstractBaseTest extends Base {
	protected $subject;

	protected $postId = 123;
	protected $name = 'my_field';

	protected $config = [
		'type' => 'some_type',
		'attributes' => [
			'class' => 'foo'
		]
	];

	protected $value = 'my value';

	public function setUp() {
		WP::setUp();
		$this->subject = $this->getMockBuilder('\Cft\Field\AbstractBase')
			->setConstructorArgs([$this->postId, $this->name, $this->config, $this->value])
			->getMockForAbstractClass();
	}

	public function tearDown() {
		WP::tearDown();
	}



	public function testConstructorWithArrayConfig() {
		$this->assertEquals( $this->subject->getType(), 'some_type' );
	}

	/**
	 * @expectedException Cft\Exception
	 * @expectedExceptionMessage invalid config: no type specified
	 */
	public function testConstructorWithBadConfigArray() {
		$this->getMockBuilder('\Cft\Field\AbstractBase')
			->setConstructorArgs([345, 'whatevs', ['no' => 'type']])
			->getMockForAbstractClass();
	}

	public function testConstructorWithStringConfig() {
		$ab = $this->getMockBuilder('\Cft\Field\AbstractBase')
			->setConstructorArgs([345, 'whatevs', 'some_type'])
			->getMockForAbstractClass();

		$this->assertEquals( $ab->getType(), 'some_type' );
	}


	public function testSave() {
		$this->subject->setValue('foo');

		WP::wpFunction( 'update_post_meta', [
			'args' => [$this->postId, $this->name, 'foo'],
			'times' => 1,
			'return' => 12345
		]);

		$result = $this->subject->save();

		$this->assertEquals( $result, 12345 );
	}


	public function testGetConfig() {
		$reflection = new \ReflectionClass('\Cft\Field\AbstractBase');
		$getConfig = $reflection->getMethod('getConfig');
		$getConfig->setAccessible(true);

		$this->assertEquals( $getConfig->invoke($this->subject, 'attributes'), ['class' => 'foo'] );
		$this->assertNull( $getConfig->invoke($this->subject, 'asdf') );
	}


	public function testAttachValidator() {
		$validator = new Validator\Required([]);
		$this->subject->attachValidator($validator);

		$validatorList = $this->getProtectedProperty($this->subject, 'validators');
		$this->assertEquals ( [$validator], $validatorList );
	}

	public function testValidateWithValidField() {
		$validator = new Validator\Required([]);

		$this->subject->attachValidator($validator);
		$this->assertTrue($this->subject->validate());
	}

	public function testValidateWithInvalidFields() {
		$validatorValid = new Validator\Required(['message' => 'this error message should never appear']);
		$validatorFoo = new Validator\AlphaNumeric(['message' => 'foo']);
		$validatorBar = new Validator\MaxLength(['message' => 'bar', 'max' => 3]);

		$this->subject->attachValidator($validatorValid);
		$this->subject->attachValidator($validatorFoo);
		$this->subject->attachValidator($validatorBar);

		$this->subject->validate();
		$this->assertEquals(['foo', 'bar'], $this->subject->getErrors());
	}
}