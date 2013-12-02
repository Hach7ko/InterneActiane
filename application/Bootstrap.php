<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initView()
	{
		$view = new Zend_View();
		$view->doctype('HTML5');
		$view->headTitle()->setSeparator(' - ')->append('Actiane');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
		$view->headLink()->appendStylesheet('/css/main.css');
		$view->headLink()->appendStylesheet('/css/print.css', 'print');

		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
	}
}