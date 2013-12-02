<?php

class Actiane_Responsable extends Actiane_Db_Table
{
	protected $_table = 'responsable';
	protected $_colonne = array('idParent', 'idEnfant');

	public function selectById($id)
	{
		$db = $this->_db;
		$select = $db->select()
			->from($this->_table, $this->_colonne);
		$row = $db->fetchRow($select);

		return $row;
	}
}