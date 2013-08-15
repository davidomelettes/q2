<?php

namespace Auth\Form;

use Omelettes\Quantum\Form\AbstractForm;

class LoginForm extends AbstractForm
{
	public function __construct($name = null)
	{
		parent::__construct('login');
		
		$this->get('name')->setLabel('Email Address');
		$this->add(array(
			'name'		=> 'password',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Password',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Password',
			),
		));
		$this->add(array(
			'name'		=> 'rememberMe',
			'type'		=> 'Checkbox',
			'options'	=> array(
				'label'		=> 'Keep me logged in?',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'RememberMe',
			),
		));
		
		$this->addSubmit('Login');
	}
	
}