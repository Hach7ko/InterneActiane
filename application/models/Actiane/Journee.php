<?php

class Actiane_Journee extends Actiane_Db_Table
{
	protected $_table = 'journeecollab';
	protected $_name = 'journeecollab';
	protected $_colonne = array('idCollaboration', 'jour', 'matin', 'apresMidi', 'validation');
    protected $_primary = 'id';


	public function getJourneesTravaillees($idUser, $date)
	{
	    $select = $this->_db->select()
	        ->from(array('a' => $this->_table))
	        ->join(array('b' => 'collaboration'), 'a.idCollaboration = b.id', array())
	        ->join(array('c' => 'identite'), 'b.idIdentite = c.id', array())
	        ->join(array('v' => 'view_collaborationclient'), 'v.idCollaboration = b.id', array('nomClient'))
	        ->where('c.idUser = ?', $idUser)
	        ->where('b.dateFin IS NULL OR b.dateFin >= ADDDATE(?, 30)', $date);
        return $this->_db->fetchAll($select);
	}


   /* public function insertRows($rows)
	{
	    try {
	        $this->_db->beginTransaction();

	        foreach ($rows as $aRow) {
	            if ($aRow['validation'] > 0 || $aRow['projet'] === '') {
	                continue;
	            }

	            $fMatin = str_replace(',', '.', $aRow['matin']);
	            $fAprem = str_replace(',', '.', $aRow['apresMidi']);
	            $jour = Actiane_Utils_Date::getParsedDate($aRow['jour']);

	            if ($id = $this->findByIdCollabJour($aRow['projet'], $jour)) {
                    $row = $this->find($this->getId())->current();
	            } else {
	                $row = $this->createRow();
	            }

	            $row['idCollaboration'] = $aRow['projet'];
	            $row['jour'] = Actiane_Utils_Date::getParsedDate($aRow['jour']);
	            $row['matin'] = $fMatin * 60;
	            $row['apresMidi'] = $fAprem * 60;
	            $row['validation'] = $aRow['newValidation'];
	      		$row->save();
	      	}
	        $this->_db->commit();
	        return true;
	    }
	    catch (Exception $e) {
	        $this->_db->rollback();
	        echo $e->getMessage();
	        return false;
	    }
	}*/

	public function findByIdCollabJour($idCollab, $jour)
	{
	    $select = $this->_db->select()
	        ->from($this->_table, array('id'))
	        ->where('idCollaboration = ?', $idCollab)
	        ->where('jour = ?', $jour);
	    return $this->_db->fetchOne($select);
	}
}