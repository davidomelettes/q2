<?php

return array(
	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'aliases' => array(
			'translator' => 'MvcTranslator',
		),
	),
	'view_manager' => array(
		'display_not_found_reason'	=> true,
		'display_exceptions'		=> true,
		'doctype'					=> 'HTML5',
		'not_found_template'		=> 'error/404',
		'exception_template'		=> 'error/index',
		'template_path_stack'		=> array(
			__DIR__ . '/../view',
		),
	),
	'controllers' => array(
		'invokables' => array(
			//'Admin\Controller\Index' => 'Admin\Controller\IndexController',
			//'Admin\Controller\Users' => 'Admin\Controller\UsersController',
			'index' => 'Admin\Controller\IndexController',
			'users' => 'Admin\Controller\UsersController',
		),
	),
	'router' => array(
		'routes' => array(
			'admin' => array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/admin',
					'defaults'		=> array(
						'controller'	=> 'index',
						'action'		=> 'index',
					),
				),
				'child_routes'	=> array(
					'default'		=> array(
						'type'				=> 'Segment',
						'options'			=> array(
							'route'			=> '[/:controller][/:action][/:key]',
							'constraints'	=> array(
								'controller'	=> '[a-z][a-z0-9_-]*',
								'action'		=> '[a-z][a-z0-9_-]*',
								'key'			=> Omelettes\Quantum\Validator\Uuid::UUID_REGEX_PATTERN,
							),
						),
					),
				),
			),
		),
	),
	'view_helpers'	=> array(
		'invokables'	=> array(),
	),
);
