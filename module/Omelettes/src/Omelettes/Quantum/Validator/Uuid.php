<?php

namespace Omelettes\Quantum\Validator;

use Zend\Validator\Regex;

class Uuid extends Regex
{
	public function __construct($pattern = '/[a-zA-Z0-9]{8}-?[a-zA-Z0-9]{4}-?[a-zA-Z0-9]{4}-?[a-zA-Z0-9]{4}-?[a-zA-Z0-9]{12}/')
	{
		parent::__construct($pattern);
	}
	
}
