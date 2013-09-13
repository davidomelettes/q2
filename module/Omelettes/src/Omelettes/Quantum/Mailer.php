<?php

namespace Omelettes\Quantum;

use Zend\Mail as ZendMail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Mime as MimeType;
use Zend\Mime\Part as MimePart;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\Mime\Mime;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Mailer implements ServiceLocatorAwareInterface
{
	/**
	 * @var ZendMail\Message
	 */
	protected $lastMessage;
	
	/**
	 * @var PhpRenderer
	 */
	protected $view;
	
	/**
	 * @var ViewModel
	 */
	protected $htmlLayoutView;

	/**
	 * @var ViewModel
	 */
	protected $htmlTemplateView;
	
	/**
	 * @var ViewModel
	 */
	protected $textLayoutView;
	
	/**
	 * @var ViewModel
	 */
	protected $textTemplateView;
	
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;
	
	/**
	 * Message character encoding
	 * @var string
	 */
	protected $encoding = 'UTF-8';
	
	public function setEncoding($encoding)
	{
		$this->encoding = $encoding;
	}
	
	/**
	 * Set the service locator.
	 *
	 * @param  ServiceLocatorInterface $serviceLocator
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
	/**
	 * Get the service locator.
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
	public function getView()
	{
		if (!$this->view) {
			$view = new PhpRenderer();
			$resolver = $this->getServiceLocator()->get('ViewResolver');
			$view->setResolver($resolver);
			$this->view = $view;
		}
		
		return $this->view;
	}
	
	public function setHtmlLayout($layoutTemplate, array $variables = array())
	{
		$layoutModel = new ViewModel();
		$layoutModel->setTemplate($layoutTemplate)
			->setVariables($variables);
		$this->htmlLayoutView = $layoutModel;
		
		return $this;
	}
	
	public function getHtmlLayoutView()
	{
		return $this->htmlLayoutView;
	}
	
	public function setHtmlTemplate($htmlTemplate, array $variables = array())
	{
		$viewModel = new ViewModel();
		$viewModel->setTemplate($htmlTemplate)
			->setVariables($variables);
		$this->htmlTemplateView = $viewModel;
		
		return $this;
	}
	
	public function getHtmlTemplateView()
	{
		return $this->htmlTemplateView;
	}
	
	public function setTextLayout($layoutTemplate, array $variables = array())
	{
		$layoutModel = new ViewModel();
		$layoutModel->setTemplate($layoutTemplate)
			->setVariables($variables);
		$this->textLayoutView = $layoutModel;
	
		return $this;
	}
	
	public function getTextLayoutView()
	{
		return $this->textLayoutView;
	}
	
	public function setTextTemplate($textTemplate, array $variables = array())
	{
		$viewModel = new ViewModel();
		$viewModel->setTemplate($textTemplate)
			->setVariables($variables);
		$this->textTemplateView = $viewModel;
	
		return $this;
	}
	
	public function getTextTemplateView()
	{
		return $this->textTemplateView;
	}
	
	public function setLastMessage(ZendMail\Message $message)
	{
		$this->lastMessage = $message;
		
		return $this;
	}
	
	public function getLastMessage()
	{
		return $this->lastMessage;
	}
	
	public function send($subject, $to, $from)
	{
		if (!$this->getTextTemplateView()) {
			throw new \Exception('Missing text template');
		}
		
		$textBody = $this->getView()->render($this->getTextTemplateView());
		if ($this->getTextLayoutView()) {
			$textBody = $this->getView()->render($this->getTextLayoutView()->setVariables(array('content' => $textBody)));
		}
		$textPart = new MimePart($textBody);
		$textPart->type = MimeType::TYPE_TEXT;
		$parts = array($textPart);
		
		if ($this->getHtmlTemplateView()) {
			$htmlBody = $this->getView()->render($this->getHtmlTemplateView());
			if ($this->getHtmlLayoutView()) {
				$htmlBody = $this->getView()->render($this->getHtmlLayoutView()->setVariables(array('content' => $htmlBody)));
			}
			$htmlPart = new MimePart($htmlBody);
			$htmlPart->type = MimeType::TYPE_HTML;
			$parts[] = $htmlPart;
		}
		
		$body = new MimeMessage();
		$body->setParts($parts);
		
		$message = new ZendMail\Message();
		$message->setSubject($subject)
			->setTo($to)
			->setFrom($from)
			->setEncoding($this->encoding)
			->setBody($body);
		
		$transport = new ZendMail\Transport\Sendmail();
		$transport->send($message);
		
		$this->setLastMessage($message);
	}
	
}
