<?php

namespace Omelettes\Quantum\Validator\Model;

use Zend\Validator\Exception;
use Zend\Db\ResultSet\AbstractResultSet;

class DoesNotExist extends AbstractModel
{
	public function isValid($value)
	{
		if (!$this->mapper) {
			throw new Exception\RuntimeException('No mapper present');
		}
	
		$this->setValue($value);
		$valid = true;
	
		$result = $this->mapper->{$this->mapperMethod}($value);
		if ((!$result instanceof AbstractResultSet && $result !== false) || count($result) > 0) {
			$valid = false;
			$this->error(self::ERROR_MODEL_EXISTS);
		}
	
		return $valid;
	}
	
}
