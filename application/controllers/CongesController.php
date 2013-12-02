<?php

class CongesController extends Zend_Controller_Action
{
    public function init() {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function saisirAction() {
        $typesconges = new Actiane_Type();
        $results = $typesconges->selectAll();
        $this->view->allTypes = $results;

        $this->view->title = "Saisir Congés";
    	if ($this->_request->isPost())
        {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();

            $date1 = $f->filter($this->_request->getPost('date1'));
            $date2 = $f->filter($this->_request->getPost('date2'));
            $type = $f->filter($this->_request->getPost('type'));
            $journee = $f->filter($this->_request->getPost('journee'));

            if($type == "conges")
                $idType = 1;
            
            else if($type == "rtt")
                $idType = 2;

            $session = new Zend_Session_Namespace('identity');
            $idIdentite = $session->idProfil;
            
            $validation = 0;

            //Calculer le nombre de jours entre la premier et le dernier jour
            /*$s = strtotime($date2)-strtotime($date1); 
            $d = intval($s/86400)+1;   
            echo($d); */
            
           $conges = new Actiane_Conges();
            $row = array(
                'idType' => $idType,
                'idIdentite' => $idIdentite,
                'debut' => $date1,
                'fin' => $date2,
                'journee' => $journee,
                'validation' => $validation);

            $insert = $conges->insertInto($row);
            $this->view->message = 'La demande de votre congé du ' . $date1 . ' au ' . $date2 . 'a bien été prise en compte.';
        }
    }

    public function validerAction() {
        $conges = new Actiane_Conges();
        $results = $conges->selectByValid();
        $this->view->allConges = $results;
        
        for($i = 0; $i < count($results); $i++)
        {
            echo var_dump($results[$i]);
        }
    }

	function preDispatch() {
        $auth = Zend_Auth::getInstance();

        if (!$auth->hasIdentity()) {
            $this->_redirect('auth/login');
        }
    }
}