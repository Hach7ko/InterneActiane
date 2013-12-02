<?php

class Actiane_Projet extends Actiane_Db_Table
{
	protected $_table = 'projet';
	protected $_colonne = array('idClient', 'nomProjet', 'referent', 'format', 'numContrat', 'duree', 'debut', 'fin', 'responsable', 'collaborateurs', 'budget', 'delai');

	public function getCurrentProjectByUser($idUser, $date)
	{
	    $select = $this->_db->select()
	        ->from(array('a' => $this->_table), array('idProjet'))
	        ->columns(array('fullProjectName' => new Zend_Db_Expr('CONCAT(a.nomProjet, " [", c.nom, "]")')))
	        ->join(array('b' => 'collaboration'), 'a.idProjet = b.idProjet', array('idCollaboration' => 'id'))
	        ->join(array('c' => 'client'), 'a.idClient = c.id', array())
	        ->join(array('d' => 'identite'), 'b.idIdentite = d.id', array())
	        ->where('d.idUser = ?', $idUser)
	        ->where('b.dateFin IS NULL OR b.dateFin >= ADDDATE(?, 30)', $date);
        return $this->_db->fetchAll($select);
	}

}
