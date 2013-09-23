<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Model\UsersMapper;

class UsersController extends AbstractActionController
{
	/**
	 * @var UsersMapper
	 */
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
		$users = $this->getUsersMapper()->fetchAll();
		
		return array(
			'users'		=> $users,
		);
	}
	
	public function viewAction()
	{
		
	}
	
}
