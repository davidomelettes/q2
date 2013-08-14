<?php

namespace Omelettes\Quantum\Model;

abstract class AbstractModel
{
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
	
	public function exchangeArray($data)
	{
		$this->setKey(isset($data['key']) ? $data['key'] : null);
		$this->setName(isset($data['name']) ? $data['name'] : null);
		
		return $this;
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
		$this->key = (string)$key;
		
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
