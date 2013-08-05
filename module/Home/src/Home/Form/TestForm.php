<?php

namespace Home\Form;

use Zend\Form\Form;

class TestForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('test');
		$this->setAttribute('method', 'post');
		$this->add(array(
			'name'		=> 'id',
			'type'		=> 'Hidden',
		));
		$this->add(array(
			'name'		=> 'name',
			'type'		=> 'Text',
			'options'	=> array(
				'label'		=> 'Name',
			),
		));
		$this->add(array(
			'name'		=> 'submit',
			'type'		=> 'Submit',
			'attributes'=> array(
				'value'		=> 'Save',
			),
		));
	}
	
}
