<?php

namespace Auth\Model;

use Omelettes\Quantum\Model\AbstractModel;

class User extends AbstractModel
{
	protected $fullName;
	protected $admin;
	
	protected $aclRole;
	
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
		$this->setFullName(isset($data['full_name']) ? $data['full_name'] : null);
		$this->setAdmin(isset($data['admin']) ? $data['admin'] : null);
		$this->setAclRole(isset($data['acl_role']) ? $data['acl_role'] : null);
		$this->setCreated(isset($data['created']) ? $data['created'] : null);
		$this->setUpdated(isset($data['updated']) ? $data['updated'] : null);
		
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
			'full_name'			=> $this->fullName,
			'admin'				=> $this->admin,
			'acl_role'			=> $this->aclRole,
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
	
	public function setAdmin($admin)
	{
		$this->admin = (boolean)$admin;
		
		return $this;
	}
	
	public function getAdmin()
	{
		return $this->admin;
	}
	
	public function setAclRole($role)
	{
		$this->aclRole = $role;
		
		return $this;
	}
	
	public function getAclRole()
	{
		return $this->aclRole;
	}
	
}
