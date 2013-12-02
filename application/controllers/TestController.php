	<?php

class TestController extends Zend_Controller_Action
{
	public function testAction() {
		$client = new Actiane_Responsable();
		$client->selectById(3);
		/*$row = array(
			'nom' => 'Actiane',
			'couleur' => 'bleu',
			'interne' => 1);

		$table = 'client';

		$data = array(
			'nom' => 'HSBC',
			'couleur' => 'bleu');

		$where = array(
			'id = ?' => 2);
		$id = 1;

		$ligne = $client->insertInto($table, $row);
		$update = $client->updateIn($table, $data, $where);
		$delete = $client->deleteById($table, $id);
		$truncate = $client->truncateTable($table);	

		insertInto();*/
	}
}