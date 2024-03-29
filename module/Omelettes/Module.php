<?php

namespace Omelettes;

use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Listener\OnBootstrapListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Session\SaveHandler\DbTableGatewayOptions;
use Zend\Session\SessionManager;
use Omelettes\Quantum\Session\SaveHandler\DbTableGateway as SessionSaveHandlerDb;
use Omelettes\Quantum\Mailer;

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
			'aliases'		=> array(
				'Mailer'		=> 'Omelettes\Quantum\Mailer',
			),
			'factories'		=> array(
				'SessionsTableGateway'			=> function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new TableGateway('sessions', $dbAdapter);
				},
				'Omelettes\Quantum\Session\SaveHandler\DbTableGateway'	=> function ($sm) {
					$config = $sm->get('config');
					if (isset($config['session'])) {
						$session = $config['session'];
						
						$tableGateway = $sm->get('SessionsTableGateway');
						$sessionSaveHandler = new SessionSaveHandlerDb($tableGateway, new DbTableGatewayOptions());
					} else {
						throw new \Exception('Missing session config');
					}
					return $sessionSaveHandler;
				},
				'Omelettes\Quantum\Mailer'		=> function ($sm) {
					$config = $sm->get('config');
					$mailer = new Mailer();
					$mailer->setTextLayout('mail/layout/text.phtml')
						->setHtmlLayout('mail/layout/html.phtml')
						->setFromAddress($config['email_addresses']['SYSTEM_NOREPLY'])
						->setFromName('Tactile CRM');
					return $mailer;
				},
				'Zend\Session\SessionManager'	=> function ($sm) {
					$config = $sm->get('config');
					if (isset($config['session'])) {
						$session = $config['session'];
						
						$sessionConfig = null;
						if (isset($session['config'])) {
							$class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                            $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                            $sessionConfig = new $class();
                            $sessionConfig->setOptions($options);
						}
						
						$sessionStorage = null;
						if (isset($session['storage'])) {
							$class = $session['storage'];
							$sessionStorage = new $class();
						}
						
						$sessionSaveHandler = null;
						if (isset($session['save_handler'])) {
							// class should be fetched from service manager since it will require constructor arguments
							$sessionSaveHandler = $sm->get($session['save_handler']);
						}
						
						$sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
						
						if (isset($session['validator'])) {
							$chain = $sessionManager->getValidatorChain();
							foreach ($session['validator'] as $validator) {
								$validator = new $validator();
								$chain->attach('session.validate', array($validator, 'isValid'));
						
							}
						}
					} else {
						$sessionManager = new SessionManager();
					}
					Container::setDefaultManager($sessionManager);
					return $sessionManager;
				},
			),
		);
	}
	
	public function OnBootstrap(MvcEvent $e)
	{
		$this->bootstrapSession($e);
	}
	
	public function bootstrapSession(MvcEvent $e)
	{
		$session = $e->getApplication()->getServiceManager()->get('Zend\Session\SessionManager');
		$session->start();
		
		$container = new Container('initialized');
		if (!isset($container->init)) {
			$session->regenerateId(true);
			$container->init = 1;
		}
	}
	
}
