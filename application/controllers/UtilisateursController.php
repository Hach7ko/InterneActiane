<?php

class UtilisateursController extends Zend_Controller_Action {

    public function init() {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function ajoutAction() {
        $this->view->message = '';
        $this->view->title = 'Ajout Utilisateurs';

        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $login = $f->filter($this->_request->getPost('login'));
            $mail = $f->filter($this->_request->getPost('mail'));

            //Création du mdpHasher, mdp et de l'email confirm
            $passwordHasher = str_pad(base_convert(mt_rand(0,PHP_INT_MAX), 10, 36), 6, '0', STR_PAD_LEFT);
            $password = str_pad(base_convert(mt_rand(0,PHP_INT_MAX), 10, 36), 6, '0', STR_PAD_LEFT);;
            $emailConfirm = str_pad(base_convert(mt_rand(0,PHP_INT_MAX), 10, 36), 6, '0', STR_PAD_LEFT);;

            //Cryptage du mdp
            $password = Actiane_Utils_String::cryptMdp($password, $passwordHasher);

            //Enregistrement des données dans un array
            $utilisateurs = new Actiane_Utilisateurs();
            $row = array(
                'login' => $login,
                'password' => $password,
                'passwordHasher' => $passwordHasher,
                'emailConfirm' => $emailConfirm);

            //Création du mail
            $mail = new Zend_Mail();
            $mail->setBodyText('Bonjour, <br> Vous recevez ce mail suite à votre inscrption à l\intranet d\'Actiane. <br/>
            Vous devez valider votre compte et changer votre mot de passe. </br>
            Voici vos identifiants: <br/>
            login:'.$login.'<br/>
            mot de passe: '.$password.'<br/>
            Pensez à changer votre mot de passe! <br/> <br/>
            Afin de valider votre inscription, merci de bien vouloir cliquer sur ce lien: <br/>
            <a>localhost/utilisateurs/ajout/'.$emailConfirm.'</a>
            Merci de ne pas répondre à ce mail.')
                ->setFrom('khemri.samya.isart@gmail.com', 'no-reply')
                ->addTo($mail, $login)
                ->setSubject('Inscription Intranet Actiane')
                ->send();

            //Envoie du mail et insertion dans la bdd
            //domain.fr/(module/)controller/action/param1/value1/param2/value2...
            $this->view->message = 'L\'utilisateur '.$login.' va recevoir un mail!';
            $insert = $utilisateurs->insertInto($row);
        }            
    }

    public function validationAction() {
        $this->view->message = '';
        $this->view->title = 'Validation Inscription ';
        $this->view->headScript()->appendFile('/js/Utilisateurs/validation.js');

        if ($this->_request->isGet()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            //Récupération de l'emailConfirm dans l'URL
            $emailConfirm = $f->filter($this->_request->getParam('token'));

            $utilisateurs = new Actiane_Utilisateurs();
            $results = $utilisateurs->getIdByEmail($emailConfirm);
            $id = $results['id'];

            $row = array(
                'emailConfirm' => 0);

            $where = array(
            'id = ?' => $id);

            $utilisateur = $utilisateurs->updateIn($row, $where);
        }
        else if($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();

            $ancienMdp = $f->filter($this->_request->getPost('ancienMdp')); 
            $nouveauMdp = $f->filter($this->_request->getPost('nouveauMdp')); 
            $confirmMdp = $f->filter($this->_request->getPost('confirmMdp'));

            //Enregistrement du nouveau mdp
            if($nouveauMdp === $confirmMdp) {
                $utilisateurs = new Actiane_Utilisateurs();
                $results = $utilisateurs->getIdByPassword($ancienMdp);
                $id = $results['id'];
                $all = $utilisateurs->selectById($id);
                $passwordHasher = $all['passwordHasher'];

                $password = Actiane_Utils_String::cryptMdp($nouveauMdp, $passwordHasher);

                $row = array(
                    'password' => $password);

                $where = array(
                'id = ?' => $id);

                $utilisateur = $utilisateurs->updateIn($row, $where);
                $this->_redirect('auth/login');
            }
            else {
                $this->view->message = 'Erreur, les deux mots de passes sont différents.';
                return false;
            }          
        }
    }
}