<?php

namespace CftTest\TestCase;

require_once 'lib/Cft/Validator/Required.php';

require_once 'lib/Cft/Field/Text.php';

use Cft\Validator;
use Cft\Field;

class ValidatorTest extends Base {
  protected $validator;

  public function testRequiredValidation() {
    $validator = new Validator\Required(['message' => 'my_field is required!']);
    $field = new Field\Text(1, 'my_field', 'text', $value = '');
    $field->attachValidator($validator);

    $this->assertFalse($field->validate());
    $this->assertEquals(['my_field is required!'], $field->getErrors());

    $field->setValue('foo');
    $field->clearErrors();
    $this->assertTrue($field->validate());
    $this->assertEquals([], $field->getErrors());
  }
}

?>