<?php

namespace Auth;

use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl;
use Auth\Form\LoginFilter;
use Auth\Model\AuthStorage;
use Auth\Model\User;
use Auth\Model\UsersMapper;

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
				'Auth\Model\AuthStorage'	=> function($sm) {
					return new AuthStorage(AuthStorage::STORAGE_NAMESPACE);
				},
				'AuthService'				=> function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$dbTableAuthAdapter = new DbTableAuthAdapter(
						$dbAdapter,
						'users',
						'name',
						'password_hash',
						'sha256(?||salt)'
					);
					
					$authService = new AuthenticationService();
					$authService->setAdapter($dbTableAuthAdapter);
					$authService->setStorage($sm->get('Auth\Model\AuthStorage'));
					
					return $authService;
				},
				'UsersTableGateway'			=> function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new User());
					return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
				},
				'Auth\Model\UsersMapper'	=> function($sm) {
					$gateway = $sm->get('UsersTableGateway');
					$mapper = new UsersMapper($gateway);
					return $mapper;
				},
				'Auth\Form\LoginFilter'		=> function($sm) {
					$filter = new LoginFilter();
					return $filter;
				},
				'AclService'				=> function($sm) {
					$acl = new Acl\Acl();
					$roles = include __DIR__ . '/config/module.acl.roles.php';
					foreach ($roles as $role => $roleParents) {
						$role = new Acl\Role\GenericRole($role);
						$acl->addRole($role, $roleParents);
					}
					
					$resources = include __DIR__ . '/config/module.acl.resources.php';
					foreach ($resources as $role => $roleResources) {
						foreach ($roleResources as $resource) {
							if (!$acl->hasResource($resource)) {
								$acl->addResource(new Acl\Resource\GenericResource($resource));
							}
							$acl->allow($role, $resource);
						}
					}
					
					return $acl;
				},
			),
		);
	}
	
	public function onBootstrap(MvcEvent $e)
	{
		$e->getApplication()->getEventManager()->attach('route', array($this, 'checkAcl'));
	}
	
	public function checkAcl(MvcEvent $e)
	{
		$app = $e->getApplication();
		$sm = $app->getServiceManager();
		$acl = $sm->get('AclService');
		$auth = $sm->get('AuthService');
		$resource = $e->getRouteMatch()->getMatchedRouteName();
		$role = $auth->hasIdentity() ? $auth->getIdentity()->aclRole : 'guest';
		
		if (!$acl->isAllowed($role, $resource)) {
			// Redirect to login page
			$response = $e->getResponse();
			$response->getHeaders()->addHeaderLine('Location', $e->getRequest()->getBaseUrl() . '/login');
			$response->setStatusCode('303');
		}
	}
	
}
