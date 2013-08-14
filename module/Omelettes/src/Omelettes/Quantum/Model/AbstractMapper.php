<?php

namespace Omelettes\Quantum\Model;

use Zend\Db\TableGateway\TableGateway;
use Omelettes\Quantum\Model\AbstractModel;
use Omelettes\Quantum\Validator\Uuid\V4 as UuidV4;

abstract class AbstractMapper
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	abstract public function fetchAll();
	
	abstract public function find($key);
	
	//abstract public function save();
	
}
