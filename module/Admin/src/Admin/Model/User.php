<?php

namespace Admin\Model;

use Auth\Model\User as AuthUser;
use Omelettes\Quantum\TabulatableInterface;

class User extends AuthUser implements TabulatableInterface
{
	public function getTableHeadings()
	{
		return array(
			'Username'		=> 'name',
			'Full Name'		=> 'fullName',
			'Admin?'		=> 'admin',
			'Enabled?'		=> 'enabled',
		);
	}
	
	public function getTableRowTemplate()
	{
		return 'tabulate/user';
	}
	
}
