<?php

namespace CftTest\Traits;

trait ParsesHtml {
  public function assertHtmlEquals( $expected, $actual ) {
    $expectedHtml = new \DOMDocument();
    $expectedHtml->loadHTML( $expected );

    $actualHtml = new \DOMDocument();
    $actualHtml->loadHTML( $actual );

    return $this->assertEquals( $expectedHtml, $actualHtml );
  }
}