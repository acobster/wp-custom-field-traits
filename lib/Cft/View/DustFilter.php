<?php

namespace Cft\View;

use \Dust\Filter\Filter;

class DustFilter implements Filter {
	protected $closure;

	public function __construct( \Closure $closure ) {
		$this->closure = $closure;
	}

	public function apply($item) {
		return $this->closure->__invoke($item);
	}
}