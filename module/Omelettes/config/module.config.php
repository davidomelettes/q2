<?php

return array(
	'service_manager' => array(
	),
	'view_manager' => array(
		'display_not_found_reason'	=> true,
		'display_exceptions'		=> true,
		'doctype'					=> 'HTML5',
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	'view_helpers'	=> array(
		'invokables'	=> array(
			'tabulate'		=> 'Omelettes\Quantum\View\Helper\Tabulate',
			'prettyBoolean'	=> 'Omelettes\Quantum\View\Helper\PrettyBoolean',
		),
	),
);
