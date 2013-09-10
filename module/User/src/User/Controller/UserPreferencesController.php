<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\ChangePasswordForm;
use User\Form\ChangePasswordFilter;

class UserPreferencesController extends AbstractActionController
{
	protected $changePasswordForm;
	
	protected $changePasswordFilter;
	
	protected $usersMapper;
	
	public function getChangePasswordForm()
	{
		if (!$this->changePasswordForm) {
			$this->changePasswordForm = new ChangePasswordForm();
		}
		
		return $this->changePasswordForm;
	}
	
	public function getChangePasswordFilter()
	{
		if (!$this->changePasswordFilter) {
			$this->changePasswordFilter = new ChangePasswordFilter($this->getServiceLocator()->get('AuthService'));
		}
	
		return $this->changePasswordFilter;
	}
	
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
		$changePasswordForm = $this->getChangePasswordForm();
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$changePasswordForm->setInputFilter($this->getChangePasswordFilter()->getInputFilter());
			$changePasswordForm->setData($request->getPost());
			if ($changePasswordForm->isValid()) {
		
			}
		}
		
		return array(
			'changePasswordForm'      => $changePasswordForm,
		);
	}
	
	public function changePasswordAction()
	{
		$changePasswordForm = $this->getChangePasswordForm();
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$changePasswordForm->setInputFilter($this->getChangePasswordFilter()->getInputFilter());
			$changePasswordForm->setData($request->getPost());
			if ($changePasswordForm->isValid()) {
				
			}
		}
		
		return array(
			'changePasswordForm'      => $changePasswordForm,
		);
	}
	
}
