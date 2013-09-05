<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db'				=> array(
		'driver'			=> 'Pdo',
		'dsn'				=> 'pgsql:host=localhost;port=5433;dbname=quantum2',
	),
	'session'			=> array(
		'config'			=> array(
			'class'				=> 'Zend\Session\Config\SessionConfig',
			'options'			=> array(
				//'name'					=> 'Omelettes',
				'use_cookies'			=> true,
				'cookie_httponly'		=> true,
				'gc_maxlifetime'		=> 1209600,
				'remember_me_seconds'	=> 1209600,
			),
		),
		'storage'			=> 'Zend\Session\Storage\SessionArrayStorage',
		'save_handler'		=> 'Omelettes\Quantum\Session\SaveHandler\DbTableGateway',
		'validators'		=> array(
			'Zend\Session\Validator\RemoteAddr',
			'Zend\Session\Validator\HttpUserAgent',
		),
	),
	'service_manager'	=> array(
		'factories'			=> array(
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
		),
	),
	'keys'				=> array(
		'SYSTEM_SYSTEM'		=> 'deadbeef-7a69-40e7-8984-8d3de3bedc0b',
		'SYSTEM_SIGNUP'		=> 'feedface-ad3e-4cc6-bd9c-501224e24359',
	),
);
