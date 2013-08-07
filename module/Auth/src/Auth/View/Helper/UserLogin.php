<?php

namespace Auth\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class UserLogin extends AbstractHelper implements ServiceLocatorAwareInterface 
{
	protected $authService;
	protected $serviceLocator;
	
	public function __invoke()
	{
		return $this->getAuthService();
	}
	
	/**
	 * Set the service locator.
	 *
	 * @param  ServiceLocatorInterface $serviceLocator
	 * @return AbstractHelper
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		
		return $this;
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
