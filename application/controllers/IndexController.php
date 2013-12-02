<?php

class IndexController extends Zend_Controller_Action
{

    public function init() {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function indexAction()
    {

    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance();

        if (!$auth->hasIdentity())
            $this->_redirect('auth/login');
    }

}

