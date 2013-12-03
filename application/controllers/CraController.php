<?php

class CraController extends Zend_Controller_Action {

    public $month = null;
    public $year = null;

    public function init() {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
        $this->month = $this->getRequest()->getParam('month');
        $this->year = $this->getRequest()->getParam('year');
    }

    public function saisirAction()  {
        if ($this->_request->isPost()) {
           
            $allParams = $this->getRequest()->getPost();
            $validation = 0;
            
            if (isset($allParams['control'])) {
                $validation = 1;
                unset($allParams['control']);
            } elseif (isset($allParams['send'])) {
                $validation = 0;
                unset($allParams['send']);
            }

            $allParams = array_merge(
                array('newValidation' => array_fill(0, count($allParams['jour']), $validation)), $allParams
            );
            
            //On modifie le tableau pour lui donner une forme facile à traiter
            $postData = Actiane_Utils_Array::array_switch_keys($allParams);
            
            $oCra = new Actiane_Cra();
            $insert = $oCra->insertRows($postData);
        }

        if ($this->month && $this->year) {
            //On vérifie quel mois nous sommes et on en déduis le nombre de jours
            switch ($this->month) {
                case '01':
                    $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30', '31');
                    break;
                case '02':
                    $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28');
                    break;
                case '03':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30', '31');
                break;
                case '04':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30');
                break;
                case '05':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30', '31');
                break;
                case '06':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30');
                break;
                case '07':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30', '31');
                break;
                case '08':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30', '31');
                break;
                case '09':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30');
                break;
                case '10':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30', '31');
                break;
                case '11':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30');
                break;
                case '12':
                $dayDb = array('01','02','03', '04','05','06', '07','08','09', '10','11','12', '13','14','15', '16','17','18', '19','20','21', '22','23','24', '25','26','27', '28','29','30', '31');
                break;

            }

            //Création du jour: "xxxx-xx-"
            $allDb = $this->year.'-'.$this->month.'-';

            //Récupération des données en session
            $session = new Zend_Session_Namespace('identity');
            $id = $session->idProfil;

            //Récupération du CRA en fonction de l'utilisateur et du mois
            $oCra = new Actiane_Cra();
            $get = $oCra->selectByIdUtilisateur($id, $dayDb, $allDb);

            //Tableau jours et projets ainsi que le CRA complet  pour le phtml
            $projets = array();
            $allData = array();

            for($i = 0, $nb = count($get); $i < $nb; $i++) {
                $projet = $get[$i]['projet'];

                if(!in_array($projet, $projets))
                    array_push($projets, $projet);
               
                if (!isset($allData[$projet]))
                    $allData[$projet] = array('projet' => $projet, 'lignes' => array($get[$i]));
                else
                    $allData[$projet]['lignes'][] = $get[$i];
            }

            $this->view->aData = $allData;
            $this->view->aProjets = $projets;

            $this->_prepareCra($this->year, $this->month);
            return;

        }

        //If no month or year selected, show selection.
        $this->view->aListeCra = $this->_getListMonth();
    }

    public function validerAction() {
    }

    public function exporterAction() {
        if ($this->month && $this->year) {
            $this->_exportCra($this->year, $this->month);
            return;
        }
        //If no month or year selected, show selection.
        $this->view->aListeCra = $this->_getListMonth();
    }

    private function _prepareCra($year, $month) {
        $aIdentity = Zend_Auth::getInstance()->getIdentity();
        $date = $year . '-' . $month . '-01';
        $projet = new Actiane_Projet();
        $results = $projet->getCurrentProjectByUser($aIdentity->id, $date);

        $aAllDays = Actiane_Utils_Date::getAllDaysMonth($year, $month);
        $oJournee = new Actiane_Journee();
        $journeesTravaillees = $oJournee->getJourneesTravaillees($aIdentity->id, $date);

        if (!empty($journeesTravaillees)) {
            foreach ($journeesTravaillees as $jour) {
                if (!isset($aAllDays[$jour['jour']])) {
                    continue;
                }
                $aAllDays[$jour['jour']] = array_merge($aAllDays[$jour['jour']], $jour);
            }
        }
        $this->view->allDays = $aAllDays;
        $this->view->period = $year . '-' . $month;
        $this->view->allProjets = $results;
    }

    private function _exportCra($year, $month) {
        $aIdentity = Zend_Auth::getInstance()->getIdentity();
        $date = $year . '-' . $month . '-01';
        $projet = new Actiane_Projet();

        $aAllDays = Actiane_Utils_Date::getAllDaysMonth($year, $month);

        $oJournee = new Actiane_Journee();
        $journeesTravaillees = $oJournee->getJourneesTravaillees($aIdentity->id, $date);
        if (!empty($journeesTravaillees)) {
            foreach ($journeesTravaillees as $jour) {
                if (!isset($aAllDays[$jour['jour']])) {
                    continue;
                }
                $aAllDays[$jour['jour']] = array_merge($aAllDays[$jour['jour']], $jour);
            }
        }

        $oConges = new Actiane_Conges();
        $aConges = $oConges->getCongesFromMonth($aIdentity->id, $date);
        if (!empty($aConges)) {
            foreach ($aConges as $conge) {
                if (!isset($aAllDays[$conge['jour']])) {
                    continue;
                }
                $aAllDays[$conge['jour']] = array_merge($aAllDays[$conge['jour']], $conge);
            }
        }

        $sPath = APPLICATION_PATH . '/../private/Cra/';
        //$o is a PhpExcelManager Class which get same properties and same method than the current PHPExcel element.
        //It can be considered as a bridge since there's no extends
        $o = new Actiane_PhpExcel($sPath . 'sample.xls');

        $outputFilepath = $o->drawCra($aAllDays, $date);
        $o->save($sPath . $outputFilepath, 'Excel2007');

        ob_clean();
        ob_end_clean();
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0, public');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=' . basename($outputFilepath));
        readfile($sPath . $outputFilepath);
        exit;
    }

    private function _getListMonth() {
        $oId = new Actiane_Identite();
        $startDate = '2013-09-01';
        $aListeCra = array();

        do {
            $time = strtotime($startDate);
            $aListeCra[] = array(
                'date' => date('Y-m', $time),
                'year' => date('Y', $time),
                'month' => date('m', $time),
            );

            $startDate = date('Y-m-d', strtotime($startDate . ' +1 month'));
        } while(strtotime($startDate) <= time());

        return $aListeCra;
    }

    function preDispatch()  {
        $auth = Zend_Auth::getInstance();

        if (!$auth->hasIdentity()) {
            $this->_redirect('auth/login');
        }
    }
}