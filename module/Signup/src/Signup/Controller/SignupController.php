<?php

namespace Signup\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Auth\Model\User;
use Signup\Form\SignupForm;

class SignupController extends AbstractActionController
{
	protected $authService;
	protected $signupForm;
	protected $usersMapper;
	
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
	
	public function signupAction()
	{
		$form = $this->getSignupForm();
		
		$request = $this->getRequest();
		$user = new User();
		$form->bind($user);
		
		if ($request->isPost()) {
			$form->setInputFilter($user->getInputFilter());
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
}
