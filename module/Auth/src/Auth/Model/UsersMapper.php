<?php

namespace Auth\Model;

use Omelettes\Quantum\Model\AbstractMapper;
use Omelettes\Quantum\Uuid\V4 as Uuid;
use Auth\Model\User;

class UsersMapper extends AbstractMapper
{
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		
		return $resultSet;
	}
	
	public function signupUser(User $user)
	{
		$config = $this->getServiceLocator()->get('config');
		$data = array(
			'name'				=> $user->name,
			'updated'			=> 'now()',
			'created_by'		=> $config['keys']['SYSTEM_SIGNUP'],
			'updated_by'		=> $config['keys']['SYSTEM_SIGNUP'],
			'full_name'			=> $user->fullName,
			'admin'				=> 'true',
			'acl_role'			=> 'user',
			'account_key'		=> $user->account,
		);
		
		$key = $user->key;
		if (empty($key)) {
			$data['key'] = new Uuid();
			$data['salt'] = new Uuid();
			$data['password_hash'] = hash('sha256', $data['salt']);
			$this->tableGateway->insert($data);
			
			// Load model with new values
			$user->exchangeArray($data);
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
