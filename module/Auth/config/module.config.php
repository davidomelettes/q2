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
		'template_map'				=> array(
			'layout/auth'				=> __DIR__ . '/../view/layout/layout.phtml',
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Auth\Controller\Auth' => 'Auth\Controller\AuthController',
		),
	),
	'router' => array(
		'routes' => array(
			'login' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/sign-in',
					'defaults'		=> array(
						'controller'	=> 'Auth\Controller\Auth',
						'action'		=> 'login',
					),
				),
			),
			'logout' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/sign-out',
					'defaults'		=> array(
						'controller'	=> 'Auth\Controller\Auth',
						'action'		=> 'logout',
					),
				),
			),
			'forgot-password' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Literal',
				'options'	=> array(
					'route'			=> '/forgot-password',
					'defaults'		=> array(
						'controller'	=> 'Auth\Controller\Auth',
						'action'		=> 'forgot-password',
					),
				),
			),
			'reset-password' => array(
				'type'		=> 'Zend\Mvc\Router\Http\Segment',
				'options'	=> array(
					'route'			=> '/reset-password/:user_key/:password_reset_key',
					'defaults'		=> array(
						'controller'	=> 'Auth\Controller\Auth',
						'action'		=> 'reset-password',
					),
					'constraints'	=> array(
						'user_key'				=> Omelettes\Quantum\Validator\Uuid::UUID_REGEX_PATTERN,
						'passsword_reset_key'	=> Omelettes\Quantum\Validator\Uuid::UUID_REGEX_PATTERN,
					),
				),
			),
		),
	),
	'view_helpers'	=> array(
		'invokables'	=> array(
			'userLogin'		=> 'Auth\View\Helper\UserLogin',
		),
	),
);
