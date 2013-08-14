<?php

namespace Auth\Model;

use Omelettes\Quantum\Model\AbstractMapper;
use Omelettes\Quantum\Uuid\V4 as Uuid;
use Omelettes\Quantum\Validator\Uuid\V4 as UuidValidator;
use Auth\Model\User;

class UsersMapper extends AbstractMapper
{
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		
		return $resultSet;
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
	
	public function saveUser(User $user)
	{
		$data = array(
			'username'			=> $user->name,
			'full_name'			=> $user->fullName,
			'admin'				=> $user->admin ? 'true' : 'false',
			'updated'			=> 'now()',
		);
		
		$key = $user->key;
		if (empty($key)) {
			$data['key'] = new Uuid();
			$data['salt'] = new Uuid();
			$data['password_hash'] = hash('sha256', $data['salt']);
			$this->tableGateway->insert($data);
			$user->key = $data['key'];
		} else {
			if (!$this->find($key)) {
				throw new \Exception('User with key ' . $key . ' does not exist');
			}
			$this->tableGateway->update($data, array('key' => $key));
		}
	}
	
	public function updateUserPassword(User $user, $passwordPlaintext)
	{
		if (!$this->find($user->key)) {
			throw new \Exception('User with key ' . $user->key . ' does not exist');
		}
		$salt = new Uuid();
		$data = array(
			'salt'				=> $salt,
			'password_hash'		=> hash('sha256', $passwordPlaintext . $salt),
		);
		$this->tableGateway->update($data, array('key' => $user->key));
	}
	
}
