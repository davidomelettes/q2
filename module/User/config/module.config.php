<?php

return array(
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
			'User\Controller\Preferences' => 'User\Controller\UserPreferencesController',
		),
	),
	'router' => array(
		'routes' => array(
			'preferences' => array(
				'type'			=> 'Literal',
				'options'		=> array(
					'route'			=> '/preferences',
					'defaults'		=> array(
						'controller'	=> 'User\Controller\Preferences',
						'action'		=> 'index',
					),
				),
			),
		),
	),
);
