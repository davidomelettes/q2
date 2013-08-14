<?php

namespace Signup;

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
		return array();
	}
	
	public function onBootstrap($e)
	{
		$app = $e->getParam('application');
		$app->getEventManager()->attach('dispatch', array($this, 'setLayout'));
	}
	
	public function setLayout($e)
	{
		$matches = $e->getRouteMatch();
		$controller = $matches->getParam('controller');
		if (false === strpos($controller, __NAMESPACE__)) {
			return;
		}
		
		$viewModel = $e->getViewModel();
		$viewModel->setTemplate('layout/signup');
	}
	
}
