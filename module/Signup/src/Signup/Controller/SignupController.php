<?php

namespace Signup\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Auth\Form\UserFilter;
use Auth\Model\Account;
use Auth\Model\AccountsMapper;
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
	 * @var AccountsMapper
	 */
	protected $accountsMapper;
	
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
	
	public function getAccountsMapper()
	{
		if (!$this->accountsMapper) {
			$mapper = $this->getServiceLocator()->get('Auth\Model\AccountsMapper');
			$this->accountsMapper = $mapper;
		}
		
		return $this->accountsMapper;
	}
	
	public function aboutAction()
	{
		return array();
	}
	
	public function frontAction()
	{
		return array();
	}
	
	public function termsAction()
	{
		return array();
	}
	
	public function tourAction()
	{
		return array();
	}
	
	public function plansAction()
	{
		$plans = $this->getAccountPlansMapper()->fetchAll();
	
		return array();
	}
	
	public function privacyAction()
	{
		return array();
	}
	
	public function signupAction()
	{
		// Check plan
		$plans = $this->getAccountPlansMapper()->fetchByName($this->params('plans'));
		if (count($plans) !== 1) {
			$this->flashMessenger()->addErrorMessage('No plan was found with that name');
			return $this->redirect()->toRoute('front');
		}
		$plan = $plans->current();
		
		$form = $this->getSignupForm();
		
		$request = $this->getRequest();
		$user = new User();
		$form->bind($user);
		$account = new Account();
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getSignupFilter()->getInputFilter());
			$form->setData($request->getPost());
				
			if ($form->isValid()) {
				// Create account
				$account->name = $user->name;
				$account->accountPlan = $plan->key;
				$this->getAccountsMapper()->createAccount($account);
				// Create user
				$user->aclRole = 'user';
				$user->account = $account->key;
				$this->getUsersMapper()->signupUser($user);
				// Set user password
				$this->getUsersMapper()->updateUserPassword($user, $request->getPost('password'));
				// Log in
				$this->getAuthService()->getStorage()->write($user);
				
				return $this->redirect()->toRoute('home');
			}
		}
		
		return array(
			'form'      => $form,
		);
	}
	
}
