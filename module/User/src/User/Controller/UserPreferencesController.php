<?php

namespace User\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Auth\Model\UsersMapper;
use User\Form\ChangePasswordForm;
use User\Form\ChangePasswordFilter;

class UserPreferencesController extends AbstractActionController
{
	/**
	 * @var ChangePasswordForm
	 */
	protected $changePasswordForm;
	
	/**
	 * @var ChangePasswordFilter
	 */
	protected $changePasswordFilter;
	
	/**
	 * @var UsersMapper
	 */
	protected $usersMapper;
	
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
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
			$usersMapper = $this->getServiceLocator()->get('Auth\Model\UsersMapper');
			$this->usersMapper = $usersMapper;
		}
	
		return $this->usersMapper;
	}
	
	public function getAuthService()
	{
		if (!$this->authService) {
			$authService = $this->getServiceLocator()->get('AuthService');
			$this->authService = $authService;
		}
		
		return $this->authService;
	}
	
	public function indexAction()
	{
		$changePasswordForm = $this->getChangePasswordForm();
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$changePasswordForm->setInputFilter($this->getChangePasswordFilter()->getInputFilter());
			$changePasswordForm->setData($request->getPost());
			if ($changePasswordForm->isValid()) {
				$this->getUsersMapper()->updateUserPassword($this->getAuthService()->getIdentity(), $changePasswordForm->getInputFilter()->getValue('password_new'));
				$this->flashMessenger()->addSuccessMessage('Your password has been updated');
			}
		}
		
		return array(
			'changePasswordForm'      => $changePasswordForm,
		);
	}
	
	public function changePasswordAction()
	{
		return array();
	}
	
}
