<?php

namespace Omelettes\Quantum\Validator\Model;

use Omelettes\Quantum\Model\AbstractMapper;

class AbstractModel extends AbstractValidator
{
	/**
	 * Error constants
	 */
	const ERROR_MODEL_EXISTS = 'modelExists';
	const ERROR_MODEL_DOES_NOT_EXIST = 'modelDoesNotExist';
	
	/**
	 * @var array Message templates
	 */
	protected $messageTemplates = array(
		self::ERROR_MODEL_EXISTS			=> 'A matching record was found',
		self::ERROR_MODEL_DOES_NOT_EXIST	=> 'No matching record was found',
	);
	
	/**
	 * @var AbstractMapper
	 */
	protected $mapper;
	
	public function __construct($options = null)
	{
		parent::__construct($options);
		
	}
	
	public function setMapper(AbstractMapper $mapper)
	{
		$this->mapper = $mapper;
	}
	
	public function getMapper()
	{
		if (!$this->mapper) {
			throw new \Exception('No mapper set');
		}
		
		return $this->mapper;
	}
	
}
