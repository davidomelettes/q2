<?php

namespace Omelettes\Quantum\Validator;

use Zend\Validator\Regex;

class Uuid extends Regex
{
	const UUID_REGEX_PATTERN = '[a-zA-Z0-9]{8}-?[a-zA-Z0-9]{4}-?[a-zA-Z0-9]{4}-?[a-zA-Z0-9]{4}-?[a-zA-Z0-9]{12}';
	
	public function __construct()
	{
		parent::__construct('/'.self::UUID_REGEX_PATTERN.'/');
	}
	
}
