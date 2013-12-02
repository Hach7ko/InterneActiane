<?php

class AuthController extends Zend_Controller_Action {
	
	function loginAction() {
		$this->view->message = '';

		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$f = new Zend_Filter_StripTags();
			$username = $f->filter($this->_request->getPost('username'));
			$password = $f->filter($this->_request->getPost('password'));

			if (empty($username) || empty($password))
				$this->view->message = 'Merci de remplir tous les champs.';
			else {

				$utilisateur = new Actiane_Utilisateurs();
		        $recup= $utilisateur->getId($username);
		        $id = $recup['id'];
		        
		        if($recup) {
		        	$passwordHasher = $utilisateur->selectById($id);
			        $passwordHasher = $passwordHasher['passwordHasher'];

					$password = Actiane_Utils_String::cryptMdp($password, $passwordHasher);

					$authAdapter = new Zend_Auth_Adapter_DbTable();
					$authAdapter->setTableName('utilisateur');
					$authAdapter->setIdentityColumn('login');
					$authAdapter->setCredentialColumn('password');


					$authAdapter->setIdentity($username);
					$authAdapter->setCredential($password);


					$auth = Zend_Auth::getInstance();
					$result = $auth->authenticate($authAdapter);

					if ($result->isValid()) {
						$data = $authAdapter->getResultRowObject(null, 'password');
						$auth->getStorage()->write($data);

				        $session = new Zend_Session_Namespace('identity');
				        $session->username = $username;
				        $session->id = $id;

				        $identite = new Actiane_Identite();
				        $fiche = $identite->selectByIdUser($session->id);

				       	$session->idIdentite = $fiche['id'];
				        $session->nom = $fiche['nom'];
				       	$session->prenom = $fiche['prenom'];
				       	$session->idProfil = $fiche['idProfil'];
				       	$session->acronyme = $fiche['acronyme'];

						$this->_redirect('/');
					}
					else
						$this->view->message = 'Mauvais login ou mauvais mot de passe.';
				}
				else
					$this->view->message = 'Mauvais login ou mauvais mot de passe.';
			}
			
		}

		$this->view->title = "Se connecter";
	}

	function logoutAction() {
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect('/');
	}
}