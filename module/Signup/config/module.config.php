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
		'factories' => array(
			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
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
			'layout/front'				=> __DIR__ . '/../view/layout/front.phtml',
			'layout/signup'				=> __DIR__ . '/../view/layout/signup.phtml',
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Signup\Controller\Signup' => 'Signup\Controller\SignupController',
		),
	),
	/*
	'navigation' => array(
		'default' => array(
			array(
				'label'		=> 'Tour',
				'route'		=> 'tour',
			),
			array(
				'label'		=> 'Pricing & Plans',
				'route'		=> 'plans',
			),
		),
	),
	*/
	'router' => array(
		'routes' => array(
			'front' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'front',
					),
				),
			),
			'tour' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/tour',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'tour',
					),
				),
			),
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
			'plans' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/plans',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'plans',
					),
				),
				'may_terminate'	=> true,
				'child_routes'	=> array(
					'plan'		=> array(
						'type'				=> 'Segment',
						'options'			=> array(
							'route'			=> '[/:plan]',
							'constraints'	=> array(
								'plan'		=> '[a-z][a-z0-9_-]*',
							),
						),
					),
				),
			),
			'about' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/about',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'about',
					),
				),
			),
			'help' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/help',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'help',
					),
				),
			),
			'terms' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/terms',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'terms',
					),
				),
			),
			'privacy' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/privacy',
					'defaults'		=> array(
						'controller'	=> 'Signup\Controller\Signup',
						'action'		=> 'privacy',
					),
				),
			),
		),
	),
	'view_helpers'	=> array(
		'invokables'	=> array(),
	),
);
