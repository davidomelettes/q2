<?php

namespace Omelettes\Quantum\View\Helper;

use Iterator;
use Zend\Db\ResultSet\ResultSet;
use Zend\View\Helper\AbstractHelper;
use Omelettes\Quantum\TabulatableInterface;

class Tabulate extends AbstractHelper
{
	public function __invoke($data, $class = null)
	{
		if ($data instanceof ResultSet) {
			// For some stupid reason you can't iterate over a ResultSet more than once without buffering
			$data->buffer();
			$mock = $data->getArrayObjectPrototype();
		} else {
			$mock = new $class();
		}
		if (!$mock instanceof TabulatableInterface) {
			throw new \Exception('Expected TabulatableInterface');
		}
		$class = get_class($mock);
		
		if (!is_array($data) && !$data instanceof Iterator) {
			throw new \Exception('Expected an array or an Iterator: ' . get_class($data));
		}
		foreach ($data as $datum) {
			if (!$datum instanceof $class) {
				throw new \Exeption('Expected ' . $class);
			}
		}
		
		$partialHelper = $this->view->plugin('partial');
		return $partialHelper('partial/tabulate.phtml', array(
			'data' => $data,
			'mock' => $mock,
		));
	}
	
}
