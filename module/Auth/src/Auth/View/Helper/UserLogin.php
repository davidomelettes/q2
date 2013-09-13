<?php

namespace Auth\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class UserLogin extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;
	
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;
	
	public function __invoke()
	{
		return $this->getAuthService();
	}
	
	/**
	 * Set the service locator.
	 *
	 * @param  ServiceLocatorInterface $serviceLocator
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
	/**
	 * Get the service locator.
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
	public function getApplicationServiceLocator()
	{
		// View helpers implementing ServiceLocatorAwareInterface are given Zend\View\HelperPluginManager!
		return $this->getServiceLocator()->getServiceLocator();
	}
	
	public function getAuthService()
	{
		if (!$this->authService) {
			$this->authService = $this->getApplicationServiceLocator()->get('AuthService');
		}
		
		return $this->authService;
	}
	
}
