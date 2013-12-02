<?php

class Actiane_Conges extends Actiane_Db_Table
{
	protected $_table = 'conges';
	protected $_colonne = array('idType', 'idIdentite', 'debut', 'fin', 'journee', 'validation');

	public function selectByValid()
	{
		$db = $this->_db;
		$select = $db->select()
			->from($this->_table, $this->_colonne)
			->where('validation = ?', 0);
		$row = $db->fetchAll($select);

		return $row;
	}

	public function getCongesFromMonth($idUser, $date)
	{
	    $select = $this->_db->select()
	        ->from(
                array('a' => $this->_table),
                array('jour', 'matinConges' => 'matin', 'apresMidiConges' => 'apresMidi')
            )
	        ->join(array('b' => 'identite'), 'a.idIdentite = b.id', array())
	        ->join(array('c' => 'typeconges'), 'a.idType = c.id', array('code', 'libelle'))
	        ->where('b.idUser = ?', $idUser)
	        ->where('DATE_FORMAT(a.jour, "%Y-%m") = ?', date('Y-m', strtotime($date)))
	        ->where('a.validation != ?', 0);
        return $this->_db->fetchAll($select);
	}
}
