<?php

class ProjetController extends Zend_Controller_Action
{

    public function init() {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function creationAction() {
        $this->view->message = '';
        $this->view->title = "Création d'un Projet";

        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $client = $f->filter($this->_request->getPost('client'));
            $nomProjet = $f->filter($this->_request->getPost('nomProjet'));
            $referent = $f->filter($this->_request->getPost('referent'));
            $format = $f->filter($this->_request->getPost('format'));
            $numContrat = $f->filter($this->_request->getPost('numContrat'));
            $duree = $f->filter($this->_request->getPost('duree'));
            $debut = $f->filter($this->_request->getPost('debut'));
            $fin = $f->filter($this->_request->getPost('fin'));
            $responsable = $f->filter($this->_request->getPost('responsable'));
            $collaborateurs = $f->filter($this->_request->getPost('collaborateurs'));
            $budget = $f->filter($this->_request->getPost('budget'));
            $delai = $f->filter($this->_request->getPost('delai'));

            $projet = new Actiane_Projet();
            $row = array(
                'client' => $client,
                'nomProjet' => $nomProjet,
                'referent' => $referent,
                'format' => $format,
                'numContrat' => $numContrat,
                'duree' => $duree,
                'debut' => $debut,
                'fin' => $fin,
                'responsable' => $responsable,
                'collaborateurs' => $collaborateurs,
                'budget' => $budget,
                'delai' => $delai);

            $insert = $projet->insertInto($row);
            $this->view->message = 'Le projet '.$client.' a été rajouté !';
        }
    }

    public function suiviAction() {
        $this->view->message = '';
        $this->view->title = "Suivi d'un Projet";

        $projet = new Actiane_Projet();
        $results = $projet->selectAll();
        $this->view->allProjets = $results;
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance();

        if (!$auth->hasIdentity())
            $this->_redirect('auth/login');
    }

}

