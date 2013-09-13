<?php

namespace Auth\Model;

use Omelettes\Quantum\Model\AbstractModel;

class User extends AbstractModel
{
	
	protected $fullName;
	
	protected $admin;
	
	protected $passwordResetKey;
	
	/**
	 * @var Account
	 */
	protected $account;
	
	protected $aclRole;
	
	public function exchangeArray($data)
	{
		parent::exchangeArray($data);
		$this->setFullName(isset($data['full_name']) ? $data['full_name'] : null);
		$this->setAdmin(isset($data['admin']) ? $data['admin'] : null);
		$this->setAclRole(isset($data['acl_role']) ? $data['acl_role'] : null);
		$this->setAccount(isset($data['account_key']) ? $data['account_key'] : null);
		
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array_merge(parent::getArrayCopy(), array(
			'full_name'			=> $this->fullName,
			'admin'				=> $this->admin,
			'acl_role'			=> $this->aclRole,
			'account_key'		=> $this->account,
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
	
	public function setAccount($key)
	{
		$this->account = $key;
	
		return $this;
	}
	
	public function getAccount()
	{
		return $this->account;
	}
	
}
