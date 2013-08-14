<?php

namespace Signup\Form;

use Omelettes\Quantum\Form\AbstractForm;

class SignupForm extends AbstractForm
{
	public function __construct($name = null)
	{
		parent::__construct('signup');
		
		$this->get('name')->setLabel('Email Address');
		$this->add(array(
			'name'		=> 'fullName',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Full Name',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'FullName',
				'autocomplete'	=> 'off',
			),
		));
		$this->add(array(
			'name'		=> 'password',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'Password',
				'autocomplete'	=> 'off',
			),
		));
		
		$this->addSubmit('Sign Up');
	}
	
}