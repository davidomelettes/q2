<?php

namespace Auth\Model;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Auth\Model\User;
use Omelettes\Quantum\Model\AbstractMapper;
use Omelettes\Quantum\Uuid\V4 as Uuid;

class UsersMapper extends AbstractMapper implements ServiceLocatorAwareInterface
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
			'salt'						=> $salt,
			'password_hash'				=> hash('sha256', $passwordPlaintext . $salt),
			'password_reset_key'		=> null,
			'password_reset_requested'	=> null,
		);
		$this->tableGateway->update($data, array('key' => $user->key));
	}
	
	public function regeneratePasswordResetKey(User $user)
	{
		if (!$this->find($user->key)) {
			throw new \Exception('User with key ' . $user->key . ' does not exist');
		}
		
		$key = new Uuid();
		$data = array(
			'password_reset_key'		=> $key,
			'password_reset_requested'	=> 'now()',
		);
		$this->tableGateway->update($data, array('key' => $user->key));
		
		return (string)$key;
	}
	
}
