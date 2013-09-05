<?php

namespace Auth\Model;

use Omelettes\Quantum\Model\AbstractMapper;
use Omelettes\Quantum\Uuid\V4 as Uuid;
use Auth\Model\Account;

class AccountsMapper extends AbstractMapper
{
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		
		return $resultSet;
	}
	
	public function createAccount(Account $account)
	{
		$config = $this->getServiceLocator()->get('config');
		$data = array(
			'name'				=> $account->name,
			'updated'			=> 'now()',
			'created_by'		=> $config['keys']['SYSTEM_SIGNUP'],
			'updated_by'		=> $config['keys']['SYSTEM_SIGNUP'],
			'account_plan_key'	=> $account->accountPlan,
		);
		//var_dump($data);die();
		
		$key = $account->key;
		if (empty($key)) {
			$data['key'] = new Uuid();
			$this->tableGateway->insert($data);
			$account->key = $data['key'];
		} else {
			if (!$this->find($key)) {
				throw new \Exception('Account with key ' . $key . ' does not exist');
			}
			$this->tableGateway->update($data, array('key' => $key));
		}
	}
	
}
