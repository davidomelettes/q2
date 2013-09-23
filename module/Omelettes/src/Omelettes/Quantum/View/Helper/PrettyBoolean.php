<?php

namespace Omelettes\Quantum\View\Helper;

use Zend\View\Helper\AbstractHelper;

class PrettyBoolean extends AbstractHelper
{
	protected $template = '<span class="glyphicon glyphicon-%s"></span>';
	
	public function __invoke($boolean)
	{
		$boolean = (boolean)$boolean;
		
		echo sprintf($this->template, $boolean ? 'ok' : 'remove');
	}
	
}
