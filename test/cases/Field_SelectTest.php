<?php

namespace CftTest\TestCase;

require_once 'lib/Cft/Plugin.php';
require_once 'lib/Cft/View/AbstractBase.php';
require_once 'lib/Cft/View/TwigView.php';
require_once 'lib/Cft/Traits/Field/InMetaBox.php';
require_once 'lib/Cft/Field/Select.php';

use \WP_Mock as WP;
use \Cft\Field\AbstractBase;

class Field_SelectTest extends Base {
  use \CftTest\Traits\ParsesHtml;
  use \CftTest\Traits\RendersMetaBox;

  protected $subject;

  protected $postId = 123;
  protected $name = 'my_select';

  protected $config = [
    'type' => 'select',
    'options' => [
      '1' => 'one',
      '2' => 'two',
      '3' => 'three'
    ],
    'attributes' => [
      'class' => 'foo'
    ]
  ];

  protected $value = 'my value';

  public function setUp() {
    WP::setUp();

    $this->subject = new \Cft\Field\Select(
      $this->postId,
      $this->name,
      $this->config
    );
  }

  public function tearDown() {
    WP::tearDown();
  }



  /**
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage config must be an array for Select instances
   */
  public function testConstructorWithStringType() {
    new \Cft\Field\Select(
      456,
      'whatevs',
      'this should be an array and should cause an exception'
    );
  }

  /**
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Select instances require an options array in $config
   */
  public function testConstructorWithNoOptions() {
    new \Cft\Field\Select(
      456,
      'whatevs',
      ['type' => 'select']
    );
  }

  /**
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage Select instances require an options array in $config
   */
  public function testConstructorWithNonArrayOptions() {
    new \Cft\Field\Select(
      456,
      'whatevs',
      ['type' => 'select', 'options' => 'foo']
    );
  }

  public function testRender() {
    $expected = <<<_SELECT_
<select name="my_select" class="foo">
  <option value="1">one</option>
  <option value="2" selected>two</option>
  <option value="3">three</option>
</select>
_SELECT_;

    \Cft\Plugin::getInstance()->set('view', function() use($expected) {
      $twig = $this->getMockBuilder('\Twig_Environment')->getMock();

      $data           = $this->config;
      $data['name']   = $this->name;
      $data['value']  = '2';

      $twig->expects( $this->once() )
        ->method( 'render' )
        ->with( 'select.twig', $data )
        ->will( $this->returnValue($expected) );

      return new \Cft\View\TwigView( $twig );
    });

    $this->subject->setValue('2');

    $rendered = $this->getRendered(function() {
      $this->subject->render();
    });

    $this->assertHtmlEquals( $expected, $rendered );
  }
}
