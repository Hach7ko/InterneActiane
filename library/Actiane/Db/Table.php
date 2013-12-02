<?php

class Actiane_Db_Table extends Zend_Db_Table_Abstract {

    protected $_db = null;

    public function __construct() {
    	$bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$this->_db = $bootstrap->getResource('db');
		parent::__construct();
    }

    //sélectionner par Id
    public function selectById($id) {
		$db = $this->_db;
		$select = $db->select()
        	->from($this->_table, $this->_colonne)
        	->where('id = ?', $id);

        $row = $db->fetchRow($select);

        return $row;
	}

	//Séléctionner par idUtilisateur
	/*Ici j'ai un problème, je récupère bien correctement les jours où l'utilisateur
	à travailler, mais dans un tripe tableau*/
	public function selectByIdUtilisateur($id, $day, $all) {
		$db = $this->_db;
		$allSelect = array();
		
		for($i = 0, $nb = count($day); $i < $nb; $i++) {
			$date = $all;
			$date .= $day[$i];
			
			$select = $db->select()
        	->from($this->_table, $this->_colonne)
        	->where('idUtilisateur = ?', $id)
        	->where('jour = ?', $date);
        	
        	$row = $db->fetchAll($select);
        	
        	if(count($row != 0)) {
        		for($j = 0, $number = count($row); $j < $number; $j++) {
        			array_push($allSelect, $row[$j]);
        		}

        	}
    	
		}

        return $allSelect;
	}

	//Select
	public function selectAll() {
		$db = $this->_db;
		$select = $db->select()
        	->from($this->_table);

        $row = $db->fetchAll($select);

        return $row;
	}

	//Inserer dans...
    public function insertInto($row) {
		$db = $this->_db;
		$test = $db->insert($this->_table, $row);
	}

	//Mise à jour
	public function updateIn($data, $where) {
		$db = $this->_db;
		$test = $db->update($this->_table, $data, $where);

	}

	//Vider la table
	public function truncateTable() {
		$db = $this->_db;
		$truncate = $db->query('TRUNCATE '.$this->_table);
	}

	//Supprimer par ID
	public function deleteById($id) {
		$db = $this->_db;
		$delete = $db->delete($this->_table, 'id='.$id);
	}

	//Récupérer l'id en fonction du prénom
	public function getId($name) {
		$db = $this->_db;
		$select = $db->select()
			->from($this->_table,'id')
			->where('login = ?', $name);
		$row = $db->fetchRow($select);

		return $row;
	}

	//Récupérer l'id concerné en fonction des données du CRA
	public function getIdByAllCra($idUtilisateur, $jour, $AM, $PM, $projet) {
		$db = $this->_db;
		$select = $db->select()
			->from($this->_table,'craId')
			->where('idUtilisateur = ?', $idUtilisateur)
			->where('jour = ?', $jour)
			->where('AM = ?', $AM)
			->where('PM = ?', $PM)
			->where('projet = ?', $projet);

		$row = $db->fetchRow($select);

		return $row;
	}

	//Récupérer l'id en fonction de l'email confirm
	public function getIdByEmail($emailConfirm) {
		$db = $this->_db;
		$select = $db->select()
			->from($this->_table,'id')
			->where('emailConfirm = ?', $emailConfirm);
		$row = $db->fetchRow($select);

		return $row;
	}

	//Récupérer l'id en fonction du mdp
	public function getIdByPassword($password) {
		$db = $this->_db;
		$select = $db->select()
			->from($this->_table,'id')
			->where('password = ?', $password);
		$row = $db->fetchRow($select);

		return $row;
	}
}
