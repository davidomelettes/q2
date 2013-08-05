<?php

namespace Omelettes\Quantum\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

abstract class AbstractModel implements InputFilterAwareInterface
{
	protected $inputFilter;
	
	protected $key;
	protected $name;
	protected $created;
	protected $updated;
	protected $createdBy;
	protected $updatedBy;
	
	public function __get($name)
	{
		$method = 'get' . $name;
		if (!method_exists($this, $method)) {
			throw new Exception('Invalid model property: ' . $param);
		}
		return $this->$method();
	}
	
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if ('mapper' == $name || !method_exists($this, $method)) {
			throw new Exception('Invalid model property: ' . $name);
		}
		$this->$method($value);
	}
	
	public function setInputFilter(InputFilterInterface $intputFilter)
	{
		throw new \Exception('Not used');
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();

			/*
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'key',
				//'validators'	=> array(
					//array('name' => 'Omelettes\Quantum\Validator\Uuid\V4'),
				//),
			)));
			*/
			
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
				),
			)));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	
	public function exchangeArray($data)
	{
		$this->key = isset($data['key']) ? $data['key'] : null;
		$this->name = isset($data['name']) ? $data['name'] : null;
	}
	
	public function getArrayCopy()
	{
		return array(
			'key'		=> $this->key,
			'name'		=> $this->name,
		);
	}
	
	public function setKey($key)
	{
		$this->key = $key;
		
		return $this;
	}
	
	public function getKey()
	{
		return $this->key;
	}
	
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
	
	public function getName()
	{
		return $this->name;
	}
}
