<?php

namespace Home\Model;

use Zend\Db\TableGateway\TableGateway;

class TestMapper
{
	protected $_tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->_tableGateway = $tableGateway;
	}
	
	public function fetchAll()
	{
		$resultSet = $this->_tableGateway->select();
		
		return $resultSet;
	}
	
	public function find($id)
	{
		$id = (int) $id;
		$rowset = $this->_tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			return false;
		}
	}
	
	public function saveTest(Test $test)
	{
		$data = array(
			'name' => $test->name,
		);
		$id = (int)$test->id;
		if ($id === 0) {
			$this->_tableGateway->insert($data);
		} else {
			if (!$this->find($id)) {
				throw new \Exception('Test with id ' . $id . ' does not exist');
			}
			$this->_tableGateway->update($data, array('id' => $id));
		}
	}
	
}
