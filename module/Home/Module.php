<?php

namespace Home;

use Home\Model\Test;
use Home\Model\TestMapper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\MvcEvent;

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
	
	public function onBootstrap(MvcEvent $e)
	{
		$em = $e->getApplication()->getEventManager();
		$em->attach('dispatch', array($this, 'initLayout'));
	}
	
	public function initLayout(MvcEvent $e)
	{
		$viewHelperManager = $e->getApplication()->getServiceManager()->get('viewHelperManager');
		
		$translator = $viewHelperManager->get('translate');
		$basePath = $viewHelperManager->get('basePath')->__invoke();
		
		$headTitle = $viewHelperManager->get('headTitle');
		$headTitle->setSeparator(' - ')->setAutoEscape(false)->append($translator->__invoke('Quantum 2'));
		
		$headMeta = $viewHelperManager->get('headMeta');
		$headMeta->setCharset('utf-8')->appendName('viewport', 'width=device-width, initial-scale=1.0');
		
		$headLink = $viewHelperManager->get('headLink');
		$icoData = $headLink->createData(array('rel' => 'shortcut icon', 'type' => 'image/vnd.microsoft.icon', 'href' => $basePath . '/favicon.ico'));
		$headLink->append($icoData);
		$headLink->prependStylesheet($basePath . '/css/bootstrap.min.css')
        	->appendStylesheet($basePath . '/css/quantum.css');
		
		$headScript = $viewHelperManager->get('headScript');
		$headScript->prependFile($basePath . '/js/html5.js', 'text/javascript', array('conditional' => 'lt IE 9',))
			->prependFile($basePath . '/js/bootstrap.min.js')
			->prependFile($basePath . '/js/jquery.min.js')
			->appendFile($basePath . '/js/holder.js')
			->appendFile($basePath . '/js/quantum.js');
	}
	
}
