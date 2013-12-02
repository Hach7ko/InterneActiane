<?php

class CollaborateurController extends Zend_Controller_Action
{

    public function init() {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function ajoutAction() {
        $this->view->title = 'Ajout Collaborateur';
        $this->view->message = '';

        $profil = new Actiane_Profil();
        $results = $profil->selectAll();
        $this->view->allProfil = $results;

        if ($this->_request->isPost())  {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            //Récupération de toutes les données en post
            $nom = $f->filter($this->_request->getPost('nom'));
            $prenom = $f->filter($this->_request->getPost('prenom'));
            $acronyme = $f->filter($this->_request->getPost('acronyme'));
            
            $mail = $f->filter($this->_request->getPost('mail'));
            $adresse = $f->filter($this->_request->getPost('adresse'));
            $telephone = $f->filter($this->_request->getPost('tel'));
            
            $dateNaissance = $f->filter($this->_request->getPost('naissance'));
            $lieuNaissance = $f->filter($this->_request->getPost('lieu'));
            

            $idProfil = $f->filter($this->_request->getPost('droits'));
            
            $dateEntree = $f->filter($this->_request->getPost('entree'));
           
            $intitule = $f->filter($this->_request->getPost('intitule'));
            $statut = $f->filter($this->_request->getPost('statut'));
            $position = $f->filter($this->_request->getPost('position'));
            $coefficient = $f->filter($this->_request->getPost('coefficient'));
            
            $compétencesf = $f->filter($this->_request->getPost('compétencesF'));
            $compétencest = $f->filter($this->_request->getPost('compétencesT'));
           
            $equipe = $f->filter($this->_request->getPost('equipe'));
            $responsable = $f->filter($this->_request->getPost('responsable'));
            $tjm = $f->filter($this->_request->getPost('tjm'));

            $identite = new Actiane_Identite();
            $row = array(
                'nom' => $nom,
                'prenom' => $prenom,
                'acronyme' => $acronyme,
                'mail' => $mail,
                'adresse' => $adresse,
                'dateNaissance' => $dateNaissance,
                'lieuNaissance' => $lieuNaissance,
                'telephone' => $telephone,
                'idProfil' => $idProfil,
                'dateEntree' => $dateEntree,
                'intitule' => $intitule,
                'statut' => $statut,
                'position' => $position,
                'coefficient' => $coefficient,
                'competencesf' => $compétencesf,
                'competencest' => $compétencest,
                'equipe' => $equipe,
                'responsable' => $responsable,
                'tjm' => $tjm);

            //Enregistrement dans la bdd
            $insert = $identite->insertInto($row);
            $this->view->message = 'Le collaborateur '.$prenom.' '.$nom.' a été rajouté !';
        }
    }
    //Lister tout les collaborateurs
    public function listAction() {
        $this->view->message = '';
        $this->view->title = 'Lister Collaborateur';

        $collaborateur = new Actiane_Identite();
        $results = $collaborateur->selectAll();
        $this->view->allCollaborateur = $results;
    }
    //Supprimer un collaborateur
    public function supprAction() {
        $this->view->message = '';
        $this->view->title = 'Supprimer Collaborateur';

        $collaborateur = new Actiane_Identite();
        $results = $collaborateur->selectAll();
        $this->view->allCollaborateur = $results;

        if ($this->_request->isPost())
        {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $id = $f->filter($this->_request->getPost('id'));

            $delete = $collaborateur->deleteById($id);

            $this->view->message = 'Le collaborateur a bien été supprimé.';

            $this->_redirect('/collaborateur/suppr');
        }
    }
    //Update des collaborateurs si il y a modification
    public function updateAction()  {
        if ($this->_request->isPost())
        {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $id = $f->filter($this->_request->getPost('id'));            
            $nom = $f->filter($this->_request->getPost('nom'));
            $prenom = $f->filter($this->_request->getPost('prenom'));
            $acronyme = $f->filter($this->_request->getPost('acronyme'));
            $mail = $f->filter($this->_request->getPost('mail'));
            $adresse = $f->filter($this->_request->getPost('adresse'));
            $dateNaissance = $f->filter($this->_request->getPost('dateNaissance'));
            $lieuNaissance = $f->filter($this->_request->getPost('lieuNaissance'));
            $telephone = $f->filter($this->_request->getPost('telephone'));
            $dateEntree = $f->filter($this->_request->getPost('dateEntree'));
            $intitule = $f->filter($this->_request->getPost('intitule'));
            $statut = $f->filter($this->_request->getPost('statut'));
            $position = $f->filter($this->_request->getPost('position'));
            $coefficient = $f->filter($this->_request->getPost('coefficient'));
            $competencesf = $f->filter($this->_request->getPost('competencesf'));
            $competencest = $f->filter($this->_request->getPost('competencest'));
            $equipe = $f->filter($this->_request->getPost('equipe'));
            $responsable = $f->filter($this->_request->getPost('responsable'));
            $tjm = $f->filter($this->_request->getPost('tjm'));

            $row = array(
                'nom' => $nom,
                'prenom' => $prenom,
                'acronyme' => $acronyme,
                'mail' => $mail,
                'adresse' => $adresse,
                'dateNaissance' => $dateNaissance,
                'lieuNaissance' => $lieuNaissance,
                'telephone' => $telephone,
                'dateEntree' => $dateEntree,
                'intitule' => $intitule,
                'statut' => $statut,
                'position' => $position,
                'coefficient' => $coefficient,
                'competencesf' => $competencesf,
                'competencest' => $competencest,
                'equipe' => $equipe,
                'responsable' => $responsable,
                'tjm' => $tjm);

            $where = array(
            'id = ?' => $id);

            $collaborateur = new Actiane_Identite();
            $insert = $collaborateur->updateIn($row, $where);
            $this->view->message = 'Le collaborateur '.$nom.' a été modifié !';

            $this->_redirect('/collaborateur/list');
        }
    }

    public function modifAction() {
        $this->view->message = '';
        $this->view->title = 'Modifier Collaborateur';

        $collaborateur = new Actiane_Identite();
        $results = $collaborateur->selectAll();
        $this->view->allCollaborateurs = $results;

        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $id = $f->filter($this->_request->getPost('id'));
            $results = $collaborateur->selectById($id);
            $this->view->oneCollaborateurs = $results;
            $this->view->id = $id;
        }
    }

    public function relierAction() 
        $this->view->title = 'Relier Collaborateur';
        $this->view->message = '';

        $collaborateur = new Actiane_Identite();
        $results = $collaborateur->selectAll();
        $this->view->allCollaborateur = $results;

        $client = new Actiane_Client();
        $results = $client->selectAll();
        $this->view->allClient = $results;

        $collaboration = new Actiane_Collaboration();

         if ($this->_request->isPost())
        {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $idClient = $f->filter($this->_request->getPost('idClient'));
            $idIdentite = $f->filter($this->_request->getPost('idIdentite'));
            $dateDebut = $f->filter($this->_request->getPost('dateDebut'));
            $dateFin = $f->filter($this->_request->getPost('dateFin'));

            $row = array(
                'idClient' => $idClient,
                'idIdentite' => $idIdentite,
                'dateDebut' => $dateDebut,
                'dateFin' => $dateFin
                );

            $insert = $collaboration->insertInto($row);

            $this->view->message = 'La collaboration a bien été mise en place.';
            $this->_redirect('collaborateur/relier');
        }
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance();

        if (!$auth->hasIdentity())
            $this->_redirect('auth/login');
    }
}