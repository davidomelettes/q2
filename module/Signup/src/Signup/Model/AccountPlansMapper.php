<?php

namespace Signup\Model;

use Omelettes\Quantum\Model\AbstractMapper;
use Zend\Db\Sql\Select;

class AccountPlansMapper extends AbstractMapper
{
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
	
		return $resultSet;
	}
	
	public function fetchByName($name)
	{
		$predicate = new Select();
		$predicate->where->like('name', ucwords($name));
		$resultSet = $this->tableGateway->select($predicate);
	
		return $resultSet;
	}
	
}
