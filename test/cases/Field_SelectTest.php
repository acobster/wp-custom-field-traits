<?php

namespace CftTest\TestCase;

require_once 'lib/Cft/Plugin.php';
require_once 'lib/Cft/View/AbstractBase.php';
require_once 'lib/Cft/View/DustView.php';
require_once 'lib/Cft/View/DustFilter.php';
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
	  $plugin = \Cft\Plugin::getInstance();
	  $plugin->set('viewDirs', [CFT_PLUGIN_DIR . 'views/']);
	  $plugin->set('view', function() {
	    $dust = new \Dust\Dust();

	    $dust->filters['atts'] = new \Cft\View\DustFilter( function( array $atts ) {
	      $htmlAtts = [];
	      foreach( $atts as $key => $value ) {
	        // allow for specifying value-less attributes such as "disabled"
	        // by passing literal true
	        $htmlAtts[] = $value === true
	          ? $key
	          : "{$key}=\"{$value}\"";
	      }

	      return implode( ' ', $htmlAtts );
	    });

	    return new \Cft\View\DustView( $dust );
	  });

	  $this->subject->setValue('2');

		$rendered = $this->getRendered(function() {
			$this->subject->render();
		});

		$expected = <<<_SELECT_
<select name="my_select" class="foo">
	<option value="1">one</option>
	<option value="2" selected>two</option>
	<option value="3">three</option>
</select>
_SELECT_;

		$this->assertHtmlEquals( $expected, $rendered );
	}
}
