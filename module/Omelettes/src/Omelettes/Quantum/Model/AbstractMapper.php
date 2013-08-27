<?php

namespace Omelettes\Quantum\Model;

use Zend\Db\TableGateway\TableGateway;
use Omelettes\Quantum\Model\AbstractModel;
use Omelettes\Quantum\Validator\Uuid\V4 as UuidValidator;

abstract class AbstractMapper
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function find($key)
	{
		$validator = new UuidValidator();
		if (!$validator->isValid($key)) {
			return false;
		}
		
		$rowset = $this->tableGateway->select(array('key' => $key));
		$row = $rowset->current();
		if (!$row) {
			return false;
		}
		
		return $row;
	}
	
	public function fetchByName($name)
	{
		$resultSet = $this->tableGateway->select(array('name' => $name));
		
		return $resultSet;
	}
	
	abstract public function fetchAll();
	
}
