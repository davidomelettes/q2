<?php

namespace Auth\Form;

use Omelettes\Quantum\Form\AbstractForm;

class ForgotPasswordForm extends AbstractForm
{
	public function __construct($name = null)
	{
		parent::__construct('form-forgot-password');
		
		$this->addNameElement('Email Address');
		$this->get('name')->setAttribute('placeholder', 'Email Address');
		
		$this->addSubmitElement('Reset password');
	}
	
}