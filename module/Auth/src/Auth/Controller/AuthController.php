<?php

namespace Auth\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Auth\Form\LoginForm;
use Auth\Model\AuthStorage;
use Auth\Model\User;

class AuthController extends AbstractActionController
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
	/**
	 * @var AuthStorage
	 */
	protected $authStorage;
	
	protected $loginForm;
	protected $loginFilter;
	
	public function getAuthService()
	{
		if (!$this->authService) {
			$authService = $this->getServiceLocator()->get('AuthService');
			$this->authService = $authService;
		}
		
		return $this->authService;
	}
	
	public function getAuthStorage()
	{
		if (!$this->authStorage) {
			$this->authStorage = $this->getServiceLocator()->get('Auth\Model\AuthStorage');
		}
		
		return $this->authStorage;
	}
	
	public function getLoginForm()
	{
		if (!$this->loginForm) {
			$this->loginForm = new LoginForm();
		}
		
		return $this->loginForm;
	}
	
	public function getLoginFilter()
	{
		if (!$this->loginFilter) {
			$loginFilter = $this->getServiceLocator()->get('Auth\Form\LoginFilter');
			$this->loginFilter = $loginFilter;
		}
	
		return $this->loginFilter;
	}
	
	public function loginAction()
	{
		if ($this->getAuthService()->hasIdentity()) {
			// Already logged in
			$this->flashMessenger()->addSuccessMessage('You are already logged in');
			return $this->redirect()->toRoute('home');
		}
		$form = $this->getLoginForm();
		
		$request = $this->getRequest();
		$user = new User();
		$form->bind($user);
		
		if ($request->isPost()) {
			$form->setInputFilter($this->getLoginFilter()->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$this->getAuthService()->getAdapter()
					->setIdentity($form->getInputFilter()->getValue('name'))
					->setCredential($form->getInputFilter()->getValue('password'));
				
				$result = $this->getAuthService()->authenticate();
				if ($result->isValid()) {
					if ($request->getPost('remember_me')) {
						$this->getAuthStorage()->rememberMe();
					}
					$userIdentity = new User((array)$this->getAuthService()->getAdapter()->getResultRowObject());
					$this->getAuthStorage()->write($userIdentity);
					$this->flashMessenger()->addSuccessMessage('Login successful');
					return $this->redirect()->toRoute('home');
				} else {
					$this->flashMessenger()->addErrorMessage('No user was found matching that email address and/or password');
				}
			}
		}
		
		return array(
			'form'      => $form,
		);
	}
	
	public function logoutAction()
	{
		$this->getAuthStorage()->forgetMe();
		$this->getAuthService()->clearIdentity();
		 
		$this->flashMessenger()->addSuccessMessage('Goodbye');
		return $this->redirect()->toRoute('login');
	}
	
}
