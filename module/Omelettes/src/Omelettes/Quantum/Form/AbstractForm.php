<?php

namespace Omelettes\Quantum\Form;

use Zend\Form\Form;

abstract class AbstractForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct($name);
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name'		=> 'key',
			'type'		=> 'Hidden',
		));
		$this->add(array(
			'name'		=> 'name',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Name',
			),
			'attributes'=> array(
				'id'		=> $this->getName() . 'Name',
			),
		));
	}
	
	public function addSubmit($buttonText = 'Save')
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