<?php

namespace Home\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Home\Model\Test;
use Home\Form\TestForm;

class DashController extends AbstractActionController
{
	protected $_testMapper;
	
	public function getTestMapper()
	{
		if (!$this->_testMapper) {
			$sm = $this->getServiceLocator();
			$this->_testMapper = $sm->get('Home\Model\TestMapper');
		}
		
		return $this->_testMapper;
	}
	
	public function indexAction()
	{
		return new ViewModel(array(
			'tests'	=> $this->getTestMapper()->fetchAll(),
		));
	}
	
	public function addAction()
	{
		$form = new TestForm();
		$form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$test = new Test();
			$form->setInputFilter($test->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$test->exchangeArray($form->getData());
				$this->getTestMapper()->saveTest($test);
				
				return $this->redirect()->toRoute('home');
			}
		}
		
		return array('form' => $form);
	}
	
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('edit', array(
				'action' => 'add'
			));
		}
		try {
			$album = $this->getAlbumTable()->getAlbum($id);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('test', array(
				'action' => 'index'
			));
		}
		
		$form  = new AlbumForm();
		$form->bind($album);
		$form->get('submit')->setAttribute('value', 'Edit');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($album->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$this->getAlbumTable()->saveAlbum($form->getData());
		
				// Redirect to list of albums
				return $this->redirect()->toRoute('dash');
			}
		}
		
		return array(
			'id' => $id,
			'form' => $form,
		);
	}
	
}