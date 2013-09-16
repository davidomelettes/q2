<?php

namespace Auth\Form;

use Omelettes\Quantum\Form\AbstractForm;

class ResetPasswordForm extends AbstractForm
{
	public function __construct($name = null)
	{
		parent::__construct('form-reset-password');
		
		$this->add(array(
			'name'		=> 'password_new',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'New Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'NewPassword',
				'placeholder'	=> 'New Password',
			),
		));
		$this->add(array(
			'name'		=> 'password_verify',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Verify Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'VerifyPassword',
				'placeholder'	=> 'Verify Password',
			),
		));
		
		$this->addSubmitElement('Change Password');
	}
	
}