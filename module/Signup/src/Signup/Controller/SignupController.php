<?php

namespace Signup\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Auth\Form\UserFilter;
use Auth\Model\User;
use Auth\Model\UsersMapper;
use Signup\Form\SignupFilter;
use Signup\Form\SignupForm;
use Signup\Model\AccountPlansMapper;

class SignupController extends AbstractActionController
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
	/**
	 * @var SignupForm
	 */
	protected $signupForm;
	
	/**
	 * @var SignupFilter
	 */
	protected $signupFilter;
	
	/**
	 * @var UsersMapper
	 */
	protected $usersMapper;
	
	/**
	 * @var AccountPlansMapper
	 */
	protected $accountPlansMapper;
	
	public function getAuthService()
	{
		if (!$this->authService) {
			$authService = $this->getServiceLocator()->get('AuthService');
			$this->authService = $authService;
		}
		
		return $this->authService;
	}
	
	public function getSignupForm()
	{
		if (!$this->signupForm) {
			$signupForm = new SignupForm();
			
			$this->signupForm = $signupForm;
		}
		
		return $this->signupForm;
	}
	
	public function getUsersMapper()
	{
		if (!$this->usersMapper) {
			$usersMapper = $this->getServiceLocator()->get('Auth\Model\UsersMapper');
			$this->usersMapper = $usersMapper;
		}
		
		return $this->usersMapper;
	}
	
	public function getSignupFilter()
	{
		if (!$this->signupFilter) {
			$userFilter = $this->getServiceLocator()->get('Signup\Form\SignupFilter');
			$this->signupFilter = $userFilter;
		}
		
		return $this->signupFilter;
	}
	
	public function getAccountPlansMapper()
	{
		if (!$this->accountPlansMapper) {
			$mapper = $this->getServiceLocator()->get('Signup\Model\AccountPlansMapper');
			$this->accountPlansMapper = $mapper;
		}
		
		return $this->accountPlansMapper;
	}
	
	public function signupAction()
	{
		$form = $this->getSignupForm();
		
		$request = $this->getRequest();
		$user = new User();
		$form->bind($user);
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getSignupFilter()->getInputFilter());
			$form->setData($request->getPost());
				
			if ($form->isValid()) {
				$this->getUsersMapper()->saveUser($user);
				$this->getUsersMapper()->updateUserPassword($user, $request->getPost('password'));
				$this->getAuthService()->getStorage()->write($form->getData());
				
				return $this->redirect()->toRoute('home');
			}
		}
		
		return array(
			'form'      => $form,
		);
	}
	
	public function plansAction()
	{
		$plans = $this->getAccountPlansMapper()->fetchAll();
		
		return array();
	}
	
}
