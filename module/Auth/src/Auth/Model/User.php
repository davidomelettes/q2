<?php

namespace Auth\Model;

use Omelettes\Quantum\Model\AbstractModel;

class User extends AbstractModel
{
	protected $password;
	protected $rememberMe;
	
	public function getInputFilter()
	{
		$inputFilter = parent::getInputFilter();
		$factory = $inputFilter->getFactory();
		
		/*
		$inputFilter->add($factory->createInput(array(
			'name'			=> 'name',
			'required'		=> 'true',
			'filters'		=> array(
				array('name' => 'StripTags'),
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
				array('name' => 'EmailAddress',),
			),
		)));
		*/
		
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
		
		return $this->inputFilter;
	}
	
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
		$this->password = isset($data['password']) ? $data['password'] : null;
		$this->rememberMe = isset($data['rememberMe']) ? $data['rememberMe'] : null;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
			'password'			=> $this->rememberMe,
			'rememberMe'		=> $this->password,
		));
	}
	
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setRememberMe($rememberMe)
	{
		$this->rememberMe = $rememberMe;
		
		return $this;
	}
	
	public function getRememberMe()
	{
		return $this->rememberMe;
	}
	
	
}
