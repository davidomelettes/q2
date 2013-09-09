<?php

namespace User\Form;

use Omelettes\Quantum\Form\AbstractForm;

class ChangePasswordForm extends AbstractForm
{
	public function __construct()
	{
		parent::__construct('form-change-password');
		
		$this->add(array(
			'name'		=> 'password_old',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'Current password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'OldPassword',
			),
		));
		$this->add(array(
			'name'		=> 'password_new',
			'type'		=> 'Password',
			'options'	=> array(
				'label'		=> 'New Password',
			),
			'attributes'=> array(
				'id'			=> $this->getName() . 'NewPassword',
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
			),
		));
		
		$this->addSubmitElement('Change Password');
	}
	
}
