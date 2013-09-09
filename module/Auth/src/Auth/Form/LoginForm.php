<?php

namespace Auth\Form;

use Omelettes\Quantum\Form\AbstractForm;

class LoginForm extends AbstractForm
{
	public function __construct()
	{
		parent::__construct('form-login');
		
		$this->addNameElement('Email Address');
		$this->get('name')->setAttribute('placeholder', 'Email Address');
		
		$this->add(array(
			'name'		=> 'password',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Password',
				'placeholder'	=> 'Password',
			),
		));
		$this->add(array(
			'name'		=> 'remember_me',
			'type'		=> 'Checkbox',
			'options'	=> array(
				'label'		=> 'Keep me signed in?',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'RememberMe',
			),
		));
		
		$this->addSubmitElement('Sign in');
	}
	
}