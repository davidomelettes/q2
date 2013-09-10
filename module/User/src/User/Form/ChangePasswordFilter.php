<?php

namespace User\Form;

use Zend\InputFilter\InputFilter;
use Omelettes\Quantum\Form\AbstractModelFilter;
use Zend\Authentication\AuthenticationService;

class ChangePasswordFilter extends AbstractModelFilter
{
	protected $authService;
	
	public function __construct(AuthenticationService $authService)
	{
		$this->authService = $authService;
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'password_old',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array(
							'encoding'	=> 'UTF-8',
							'min'		=> 6,
							'max'		=> 255,
						),
					),
					array(
						'name'		=> 'Omelettes\Quantum\Validator\Password',
						'options'	=> array(
							'authService'	=> $this->authService,
						),
					),
				),
			)));
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'password_new',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array(
							'encoding'	=> 'UTF-8',
							'min'		=> 6,
							'max'		=> 255,
						),
					),
				),
			)));
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'password_verify',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'Identical',
						'options'	=> array(
							'token'	=> 'password_new',
						),
					),
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
