<?php

namespace Auth\Form;

use Omelettes\Quantum\Form\AbstractForm;

class LoginForm extends AbstractForm
{
	public function __construct($name = null)
	{
		parent::__construct('login');
		
		$this->get('name')->setLabel('Username');
		$this->add(array(
			'name'		=> 'password',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Password',
			),
		));
		$this->add(array(
			'name'		=> 'rememberMe',
			'type'		=> 'Checkbox',
			'options'	=> array(
				'label'		=> 'Keep me logged in?',
			),
		));
		
		$this->addSubmit('Login');
	}
	
}