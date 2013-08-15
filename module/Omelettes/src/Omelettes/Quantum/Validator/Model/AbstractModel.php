<?php

namespace Omelettes\Quantum\Validator\Model;

use Omelettes\Quantum\Model\AbstractMapper;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

abstract class AbstractModel extends AbstractValidator
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
	
	/**
	 * @var string
	 */
	protected $mapperMethod = 'find';
	
	public function __construct($options = null)
	{
		parent::__construct($options);
		
		if ($options instanceof AbstractMapper) {
			$this->setMapper($options);
			return;
		}
		
		if (!array_key_exists('mapper', $options)) {
			throw new Exception\InvalidArgumentException('Mapper option missing!');
		}
		$this->setMapper($options['mapper']);
		
		if (array_key_exists('method', $options)) {
			$this->setMapperMethod($options['method']);
		}
	}
	
	public function setMapper(AbstractMapper $mapper)
	{
		$this->mapper = $mapper;
		
		return $this;
	}
	
	public function setMapperMethod($methodName)
	{
		if (!$this->mapper) {
			throw new Exception\RuntimeException('Mapper not set');
		}
		if (!method_exists($this->mapper, $methodName)) {
			throw new Exception\InvalidArgumentException('Invalid mapper method: ' . $methodName);
		}
		$this->mapperMethod = $methodName;
		
		return $this;
	}
	
}
