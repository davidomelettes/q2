<?php

namespace Home;

use Home\Model\Test;
use Home\Model\TestMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
				'Home\Model\TestMapper' => function($sm) {
					$gateway = $sm->get('TestTableGateway');
					$mapper = new TestMapper($gateway);
					return $mapper;
				},
				'TestTableGateway'		=> function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Test());
					return new TableGateway('test', $dbAdapter, null, $resultSetPrototype);
				},
			),
		);
	}
	
}
