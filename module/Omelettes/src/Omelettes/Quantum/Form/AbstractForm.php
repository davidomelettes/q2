<?php

namespace Omelettes\Quantum\Form;

use Zend\Form\Form;

abstract class AbstractForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct($name);
		$this->setAttribute('method', 'post');
	}
	
	public function addKeyElement()
	{
		$this->add(array(
			'name'		=> 'key',
			'type'		=> 'Hidden',
		));
		
		return $this;
	}
	
	public function addNameElement($label = 'Name')
	{
		$this->add(array(
			'name'		=> 'name',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> $label,
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Name',
			),
		));
		
		return $this;
	}
	
	public function addSubmitElement($buttonText = 'Save')
	{
		$this->add(array(
			'name'		=> 'submit',
			'type'		=> 'Submit',
			'attributes'=> array(
				'value'		=> $buttonText,
			),
		));
		
		return $this;
	}
	
}