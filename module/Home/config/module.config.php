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
	'translator' => array(
		'locale'					=> 'en_US',
		'translation_file_patterns' => array(
			array(
				'type'		=> 'gettext',
				'base_dir'	=> __DIR__ . '/../language',
				'pattern'	=> '%s.mo',
			),
		),
	),
	'view_manager' => array(
		'display_not_found_reason'	=> true,
		'display_exceptions'		=> true,
		'doctype'					=> 'HTML5',
		'not_found_template'		=> 'error/404',
		'exception_template'		=> 'error/index',
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Home\Controller\Dash' => 'Home\Controller\DashController',
		),
	),
	'router' => array(
		'routes' => array(
			'home' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/',
					'defaults'		=> array(
						'controller'	=> 'Home\Controller\Dash',
						'action'		=> 'index',
					),
				),
			),
			'add' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/add',
					'defaults'		=> array(
						'controller'	=> 'Home\Controller\Dash',
						'action'		=> 'add',
					),
				),
			),
			'edit' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/edit',
					'defaults'		=> array(
						'controller'	=> 'Home\Controller\Dash',
						'action'		=> 'edit',
					),
				),
			),
		),
	),
);
