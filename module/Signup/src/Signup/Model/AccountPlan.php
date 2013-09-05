<?php

namespace Signup\Model;

use Omelettes\Quantum\Model\AbstractModel;

class AccountPlan extends AbstractModel
{
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
	
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
		));
	}
	
}
