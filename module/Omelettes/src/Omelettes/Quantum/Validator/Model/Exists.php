<?php

namespace Omelettes\Quantum\Validator\Model;

use Zend\Validator\Exception;

class Exists extends AbstractModel
{
	public function isValid($value)
	{
		if (!$this->mapper) {
			throw new Exception\RuntimeException('No mapper present');
		}
		
		$this->setValue($value);
		$valid = true;
		
		$result = $this->mapper->{$this->mapperMethod}($value);
		if (empty($result)) {
			$valid = false;
			$this->error(self::ERROR_MODEL_DOES_NOT_EXIST);
		}
		
		return $valid;
	}
	
}
