<?php

namespace Auth\Model;

use Omelettes\Quantum\Model\AbstractModel;

class User extends AbstractModel
{
	protected $fullName;
	protected $rememberMe;
	protected $admin;
	
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
		$this->setFullName(isset($data['fullName']) ? $data['fullName'] : null);
		$this->setRememberMe(isset($data['rememberMe']) ? $data['rememberMe'] : null);
		$this->setAdmin(isset($data['rememberMe']) ? $data['rememberMe'] : null);
		
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
			'fullName'			=> $this->fullName,
			'rememberMe'		=> $this->rememberMe,
			'admin'				=> $this->admin,
		));
	}
	
	public function setFullName($name)
	{
		$this->fullName = $name;
		
		return $this;
	}
	
	public function getFullName()
	{
		return $this->fullName;
	}
	
	public function setRememberMe($rememberMe)
	{
		$this->rememberMe = (boolean)$rememberMe;
		
		return $this;
	}
	
	public function getRememberMe()
	{
		return $this->rememberMe;
	}
	
	public function setAdmin($admin)
	{
		$this->admin = (boolean)$admin;
		
		return $this;
	}
	
	public function getAdmin()
	{
		return $this->admin;
	}
}
