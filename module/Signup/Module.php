<?php

namespace Signup;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Signup\Form\SignupFilter;
use Signup\Model\AccountPlan;
use Signup\Model\AccountPlansMapper;

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
			'factories' => array(
				'Signup\Form\SignupFilter'			=> function($sm) {
					$filter = new SignupFilter($sm->get('Auth\Model\UsersMapper'));
					return $filter;
				},
				'AccountPlansTableGateway'			=> function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new AccountPlan());
					return new TableGateway('account_plans', $dbAdapter, null, $resultSetPrototype);
				},
				'Signup\Model\AccountPlansMapper'	=> function($sm) {
					$gateway = $sm->get('AccountPlansTableGateway');
					$mapper = new AccountPlansMapper($gateway);
					return $mapper;
				},
			),
		);
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
