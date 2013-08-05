<?php

namespace Home\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Test implements InputFilterAwareInterface
{
	protected $_id;
	protected $_name;
	
	protected $_inputFilter;
	
	public function __get($param)
	{
		$method = 'get' . $param;
		if (!method_exists($this, $method)) {
			throw new Exception();
		}
		return $this->$method();
	}
	
	public function setInputFilter(InputFilterInterface $intputFilter)
	{
		throw new \Exception('Not used');
	}
	
	public function getInputFilter()
	{
		if (!$this->_inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
				
			$inputFilter->add($factory->createInput(array(
				'name'			=> 'id',
				'required'		=> 'true',
				'filters'		=> array(
					array('name' => 'Int'),
				),
			)));
			
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
			
			$this->_inputFilter = $inputFilter;
		}
		
		return $this->_inputFilter;
	}
	
	
	public function setId($id)
	{
		$this->_id = (int) $id;
		return $this;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setName($name)
	{
		$this->_name = $name;
		return $this;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function exchangeArray($data)
	{
		$this->_id = $data['id'];
		$this->_name = $data['name'];
	}
	
}
