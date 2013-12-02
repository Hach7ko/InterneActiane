<?php

class ClientController extends Zend_Controller_Action {

    public function init() {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function ajoutAction()  {
        $this->view->message = '';
        $this->view->title = 'Ajout Client';

        if ($this->_request->isPost())
        {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            //Récupération de toutes les données en post
            $nom = $f->filter($this->_request->getPost('societe'));
            $couleur = $f->filter($this->_request->getPost('couleur'));
            $interne = $f->filter($this->_request->getPost('interne'));
            $secteur = $f->filter($this->_request->getPost('secteur'));
            $siret = $f->filter($this->_request->getPost('siret'));
            $tva = $f->filter($this->_request->getPost('tva'));
            $entite = $f->filter($this->_request->getPost('entite'));
            $siege = $f->filter($this->_request->getPost('siege'));
            $facturation = $f->filter($this->_request->getPost('facturation'));
            $principal = $f->filter($this->_request->getPost('principal'));
            $telp = $f->filter($this->_request->getPost('telp'));
            $mailp = $f->filter($this->_request->getPost('mailp'));
            $secondaire = $f->filter($this->_request->getPost('secondaire'));
            $tels = $f->filter($this->_request->getPost('tels'));
            $mails = $f->filter($this->_request->getPost('mails'));
            $compta = $f->filter($this->_request->getPost('compta'));
            $telc = $f->filter($this->_request->getPost('telc'));
            $mailc = $f->filter($this->_request->getPost('mailc'));

            $client = new Actiane_Client();
            $row = array(
                'nom' => $nom,
                'couleur' => $couleur,
                'interne' => $interne,
                'secteur' => $secteur,
                'siret' => $siret,
                'tva' => $tva,
                'entite' => $entite,
                'siege' => $siege,
                'facturation' => $facturation,
                'contactp' => $principal,
                'telp' => $telp,
                'mailp' => $mailp,
                'contacts' => $secondaire,
                'tels' => $tels,
                'mails' => $mails,
                'contactc' => $compta,
                'telc' => $telc,
                'mailc' => $mailc);

            //Insertion dans la bdd
            $insert = $client->insertInto($row);
            $this->view->message = 'Le client '.$nom.' a été rajouté !';
        }
    }
    //Update si il y a modification
    public function updateAction() {
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $id = $f->filter($this->_request->getPost('id'));            
            $nom = $f->filter($this->_request->getPost('nom'));
            $couleur = $f->filter($this->_request->getPost('couleur'));
            $interne = $f->filter($this->_request->getPost('interne'));
            $secteur = $f->filter($this->_request->getPost('secteur'));
            $siret = $f->filter($this->_request->getPost('siret'));
            $tva = $f->filter($this->_request->getPost('tva'));
            $entite = $f->filter($this->_request->getPost('entite'));
            $siege = $f->filter($this->_request->getPost('siege'));
            $facturation = $f->filter($this->_request->getPost('facturation'));
            $principal = $f->filter($this->_request->getPost('contactp'));
            $telp = $f->filter($this->_request->getPost('telp'));
            $mailp = $f->filter($this->_request->getPost('mailp'));
            $secondaire = $f->filter($this->_request->getPost('contacts'));
            $tels = $f->filter($this->_request->getPost('tels'));
            $mails = $f->filter($this->_request->getPost('mails'));
            $compta = $f->filter($this->_request->getPost('contactc'));
            $telc = $f->filter($this->_request->getPost('telc'));
            $mailc = $f->filter($this->_request->getPost('mailc'));

            $row = array(
                'nom' => $nom,
                'couleur' => $couleur,
                'interne' => $interne,
                'secteur' => $secteur,
                'siret' => $siret,
                'tva' => $tva,
                'entite' => $entite,
                'siege' => $siege,
                'facturation' => $facturation,
                'contactp' => $principal,
                'telp' => $telp,
                'mailp' => $mailp,
                'contacts' => $secondaire,
                'tels' => $tels,
                'mails' => $mails,
                'contactc' => $compta,
                'telc' => $telc,
                'mailc' => $mailc);

            $where = array(
            'id = ?' => $id);

            $client = new Actiane_Client();
            $insert = $client->updateIn($row, $where);
            $this->view->message = 'Le client '.$nom.' a été modifié !';

            $this->_redirect('/client/list');
        }
    }
    //Modification
    public function modifAction() {
        $this->view->message = '';
        $this->view->title = 'Modifier Client';

        $client = new Actiane_Client();
        $results = $client->selectAll();
        $this->view->allClients = $results;

        if ($this->_request->isPost())
        {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $id = $f->filter($this->_request->getPost('id'));
            $results = $client->selectById($id);
            $this->view->oneClients = $results;
            $this->view->id = $id;
        }
    }
    //Lister les clients
    public function listAction() {
        $this->view->message = '';
        $this->view->title = 'Lister Client';

        $client = new Actiane_Client();
        $results = $client->selectAll();
        $this->view->allClients = $results;
    }
    //Suppression ds clients
    public function supprAction() {
        $this->view->message = '';
        $this->view->title = 'Supprimer Client';

        $client = new Actiane_Client();
        $results = $client->selectAll();
        $this->view->allClients = $results;

        if ($this->_request->isPost())
        {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $id = $f->filter($this->_request->getPost('id'));

            $delete = $client->deleteById($id);

            $this->view->message = 'Le client a bien été supprimé.';

            $this->_redirect('/client/suppr');
        }
    }

    function preDispatch()  {
        $auth = Zend_Auth::getInstance();

        if (!$auth->hasIdentity())
            $this->_redirect('auth/login');
    }

}

