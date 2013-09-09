<?php

namespace Signup\Form;

use Omelettes\Quantum\Form\AbstractForm;

class SignupForm extends AbstractForm
{
	public function __construct($name = null)
	{
		parent::__construct('form-signup');
		
		$this->addNameElement('Email Address');
		$this->get('name')->setAttribute('placeholder', 'Email Address');
		
		$this->add(array(
			'name'		=> 'full_name',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Full Name',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'FullName',
				'autocomplete'	=> 'off',
				'placeholder'	=> 'Full Name',
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
				'placeholder'	=> 'Password',
			),
		));
		
		$this->addSubmitElement('Sign up for free');
	}
	
}