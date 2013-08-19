<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class UsersController extends AbstractActionController
{
	protected $usersMapper;
	
	public function getUsersMapper()
	{
		if (!$this->usersMapper) {
			$usersMapper = $this->getServiceLocator()->get('Admin\Model\UsersMapper');
			$this->usersMapper = $usersMapper;
		}
	
		return $this->usersMapper;
	}
	
	public function indexAction()
	{
		
	}
	
}
