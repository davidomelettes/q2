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
	
	public function __construct($data = array())
	{
		$this->exchangeArray($data);
	}
	
	public function __get($name)
	{
		$method = 'get' . $name;
		if (!method_exists($this, $method)) {
			throw new Exception('Invalid model property: ' . $name);
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
		$this->setCreated(isset($data['created']) ? $data['created'] : null);
		$this->setUpdated(isset($data['updated']) ? $data['updated'] : null);
		$this->setCreatedBy(isset($data['created_by']) ? $data['created_by'] : null);
		$this->setUpdatedBy(isset($data['updated_by']) ? $data['updated_by'] : null);
		
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array(
			'key'		=> $this->key,
			'name'		=> $this->name,
			'created'	=> $this->created,
			'updated'	=> $this->updated,
			'created_by'=> $this->createdBy,
			'updated_by'=> $this->updatedBy,
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
	
	public function setCreated($ts)
	{
		$this->created = $ts;
		
		return $this;
	}
	
	public function getCreated()
	{
		return $this->created;
	}
	
	public function setUpdated($ts)
	{
		$this->updated = $ts;
		
		return $this;
	}
	
	public function getUpdated()
	{
		return $this->updated;
	}
	
	public function setCreatedBy($key)
	{
		$this->createdBy = $key;
	
		return $this;
	}
	
	public function getCreatedBy()
	{
		return $this->createdBy;
	}
	
	public function setUpdatedBy($key)
	{
		$this->updatedBy = $key;
	
		return $this;
	}
	
	public function getUpdatedBy()
	{
		return $this->updatedBy;
	}
	
}
