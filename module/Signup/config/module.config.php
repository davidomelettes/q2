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
		'template_map'				=> array(
			'layout/signup'				=> __DIR__ . '/../view/layout/layout.phtml',
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Signup\Controller\Signup' => 'Signup\Controller\SignupController',
		),
	),
	'router' => array(
		'routes' => array(
			'signup' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/signup',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'signup',
					),
				),
				'may_terminate'	=> true,
				'child_routes'	=> array(
					'plan'		=> array(
						'type'				=> 'Segment',
						'options'			=> array(
							'route'			=> '/for[/:plan]',
							'constraints'	=> array(
								'plan'		=> '[a-z][a-z0-9_-]*',
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
