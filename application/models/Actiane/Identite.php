<?php

class Actiane_Identite extends Actiane_Db_Table
{
	protected $_table = 'identite';
	protected $_colonne = array('idUser','nom', 'prenom', 'acronyme', 'mail', 'adresse', 'dateNaissance', 'lieuNaissance', 'telephone', 'dateEntree', 'intitule', 'statut', 'position', 'idProfil', 'coefficient', 'competencesf', 'competencest', 'equipe', 'responsable', 'tjm');

	public function selectByIdUser($id)
	{
		$colonne = array('id','nom', 'prenom', 'acronyme', 'mail', 'adresse', 'dateNaissance', 'lieuNaissance', 'telephone', 'dateEntree', 'intitule', 'statut', 'position', 'idProfil', 'coefficient', 'competencesf', 'competencest', 'equipe', 'responsable', 'tjm');
		$db = $this->_db;
		$select = $db->select()
        	->from($this->_table, $colonne)
        	->where('idUser = ?', $id);

        $row = $db->fetchRow($select);

        return $row;
	}

	public function getCraForMonth($date, $idUser)
	{
	    $select = $this->_db->select()
	        ->from(array('a' => $this->_table))
	        ->joinLeft(array('b' => 'conges'), 'b.idIdentite = a.id')
	        ->joinLeft(array('c' => 'collaboration'), 'c.idIdentite = a.id')
	        ->joinLeft(array('d' => 'journeecollab'), 'd.idCollaboration = c.id')
	        ->where('c.dateDebut <= ?', $date)
	        ->where('DATE_FORMAT(b.jour, "%Y-%m") = ?', date('Y-m', strtotime($date)))
	        ->where('DATE_FORMAT(d.jour, "%Y-%m") = ?', date('Y-m', strtotime($date)));
	    return $this->_db->fetchAll($select);
	}

	public function getCongesForMonth($date, $idUser)
	{
	    $select = $this->_db->select()
	        ->from(array('a' => $this->_table))
	        ->joinLeft(array('b' => 'conges'), 'b.idIdentite = a.id')
	        ->where('DATE_FORMAT(b.jour, "%Y-%m") = ?', date('Y-m', strtotime($date)));
	    return $this->_db->fetchAll($select);
	}


}
