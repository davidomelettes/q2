<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Auth\Form\LoginForm;
use Auth\Model\User;

class AuthController extends AbstractActionController
{
	protected $authService;
	protected $authStorage;
	protected $loginForm;
	
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
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$this->getAuthService()->getAdapter()
					->setIdentity($form->getInputFilter()->getValue('name'))
					->setCredential($form->getInputFilter()->getValue('password'));
				
				$result = $this->getAuthService()->authenticate();
				foreach ($result->getMessages() as $message) {
					$this->flashMessenger()->addErrorMessage($message);
				}
				if ($result->isValid()) {
					if ($request->getPost('rememberMe')) {
						$this->getAuthStorage()->setRememberMe(1);
						// $this->getAuthService()->setStorage($this->getAuthStorage());
					}
					$this->getAuthService()->getStorage()->write($form->getData());
					$this->flashMessenger()->addSuccessMessage('Login successful');
					
					return $this->redirect()->toRoute('home');
				} else {
					$this->flashMessenger()->addErrorMessage('Invalid login details');
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
