<?php

namespace Omelettes\Quantum\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator\StringLength;
use Omelettes\Quantum\Model\AbstractModel;
use Omelettes\Quantum\Validator\Uuid\V4 as UuidValidator;

abstract class AbstractMapper implements ServiceLocatorAwareInterface
{
	/**
	 * @var TableGateway
	 */
	protected $tableGateway;
	
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->serviceLocator;
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
	
	public function findByName($name)
	{
		$validator = new StringLength(array('min' => 1, 'encoding' => 'UTF-8'));
		if (!$validator->isValid($name)) {
			return false;
		}
		
		$resultSet = $this->tableGateway->select(array('name' => $name));
		if (count($resultSet) > 1) {
			throw new \Exception('Expected no more than 1 result');
		}
		$row = $resultSet->current();
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
