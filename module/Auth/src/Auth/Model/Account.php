<?php

namespace Auth\Model;

use Omelettes\Quantum\Model\AbstractModel;

class Account extends AbstractModel
{
	protected $accountPlan;
	
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
		$this->setAccountPlan(isset($data['account_plan_key']) ? $data['account_plan_key'] : null);
		
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
			'account_plan_key' => $this->accountPlan,
		));
	}
	
	public function setAccountPlan($key)
	{
		$this->accountPlan = $key;
		
		return $this;
	}
	
	public function getAccountPlan()
	{
		return $this->accountPlan;
	}
	
}
