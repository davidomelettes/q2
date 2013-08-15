<?php

namespace Signup\Form;

use Omelettes\Quantum\Form\AbstractModelFilter;
use Auth\Model\UsersMapper;

class SignupFilter extends AbstractModelFilter
{
	protected $usersMapper;
	
	public function __construct(UsersMapper $usersMapper)
	{
		$this->usersMapper = $usersMapper;
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = parent::getInputFilter();
			$factory = $inputFilter->getFactory();
			
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'fullName',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array(
							'encoding'	=> 'UTF-8',
							'min'		=> 1,
							'max'		=> 255,
						),
					),
				),
			)));
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'name',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'StringTrim'),
				),
				'validators'	=> array(
					array(
						'name'		=> 'EmailAddress',
					),
					array(
						'name'		=> 'Omelettes\Quantum\Validator\Model\DoesNotExist',
						'options'	=> array(
							'table'		=> 'users',
							'field'		=> 'name',
							'mapper'	=> $this->usersMapper,
							'method'	=> 'fetchByName',
						),
					),
				),
			)));
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'password',
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
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
}
