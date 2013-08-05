<?php

namespace Auth\Model;

use Zend\Authentication\Storage;

class AuthStorage extends Storage\Session
{
	const TWO_WEEKS = 1209600;
	const STORAGE_NAMESPACE = 'Omelettes_AuthStorage';
	
	public function rememberMe($time = self::TWO_WEEKS)
	{
		$this->session->getManager()->rememberMe($time);
	}
	
	public function forgetMe()
	{
		$this->session->getManager()->forgetMe();
	}
	
}
