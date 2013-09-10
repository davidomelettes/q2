<?php

namespace User;

use User\Form\ChangePasswordFilter;

class Module
{
	public function getAutoloaderConfig()
	{
		return array(
			/*'Zend\Loader\ClassMapAutoLoader' => array(
			 __DIR__ . '/autoload_classmap.php',
			),*/
			'Zend\Loader\StandardAutoLoader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
	
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig()
	{
		return array(
			'factories'		=> array(
				'User\Form\ChangePasswordFilter' => function ($sm) {
					$filter = new ChangePasswordFilter($sm->get('AuthService'));
					
					return $filter;
				},
			),
		);
	}
	
}
