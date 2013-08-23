<?php

namespace Auth\Model;

use Zend\Authentication\Storage;

class AuthStorage extends Storage\Session
{
	//const TWO_WEEKS = 1209600;
	const STORAGE_NAMESPACE = 'Omelettes_AuthStorage';
	
	public function getSessionManager()
	{
		return $this->session->getManager();
	}
	
	public function rememberMe()
	{
		$this->session->getManager()->rememberMe();
	}
	
	public function forgetMe()
	{
		$this->session->getManager()->forgetMe();
	}
	
}
