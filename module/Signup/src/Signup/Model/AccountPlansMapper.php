<?php

namespace Signup\Model;

use Omelettes\Quantum\Model\AbstractMapper;

class AccountPlansMapper extends AbstractMapper
{
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
	
		return $resultSet;
	}
	
}
