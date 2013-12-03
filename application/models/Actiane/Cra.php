<?php

class Actiane_Cra extends Actiane_Db_Table
{
	protected $_table = 'actiane_cra';
	protected $_colonne = array('craId', 'idUtilisateur', 'jour', 'AM', 'PM', 'projet');

    //Insertion des données CRA
	public function insertRows($postData)
	{    //On récupère les données de session, plus particulièrement l'ID
		$session = new Zend_Session_Namespace('identity');
        $idUtilisateur = $session->idProfil;

		try  {    //Grâce aux boucles for on récupère les données postées
	        $this->_db->beginTransaction();
			for($i = 0, $nb = count($postData); $i < $nb; $i++)
            {
                for($j = 0, $nb = count($postData[$i]); $j < $nb; $j++)
                {   //Si elles existent
                    if(isset($postData[$i]['jour']) && isset($postData[$i]['projet']) && isset($postData[$i]['matin']) && isset($postData[$i]['apresMidi'])) {
                        $jour = $postData[$i]['jour'];              //la data
                        $projet = $postData[$i]['projet'];          //le nom du projet
                        $matin =$postData[$i]['matin'];             //si travaillé le matin
                        $apresMidi = $postData[$i]['apresMidi'];    //si travaillé l'aprem

                        if($matin == 'on')  //Si coché on valide
                            $matin = 1;

                        if($apresMidi == 'on')
                            $apresMidi = 1;

                        //On récupère l'idCra pour savoir si ils existent grâce aux données postées
                        $oCra = new Actiane_Cra();
                        $result = $oCra->getIdByAllCra($idUtilisateur, $jour, $matin, $apresMidi, $projet);
                        $idCra = $result['craId'];

                        //Si il n'existe pas création et insertion des données
                        if($idCra === false) {
                            $row = $this->createRow();
                            $row['jour'] = $jour;
                            $row['AM'] =$matin;
                            $row['PM'] = $apresMidi;
                            $row['projet'] = $projet;
                            $row['idUtilisateur'] = $id;
                            $row->save();

                        } else {    //Si il existe on le récupère et s'update
                            $row = $this->find($idCra)->current();
                            $row->save();
                        }       
                    }  
                }
            } 
            $this->_db->commit();
	        return true;
        }
        catch (Exception $e) {
	        $this->_db->rollback();
	        echo $e->getMessage();
	        return false;
	    }
	}
}
