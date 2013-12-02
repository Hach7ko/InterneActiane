<?php
class Actiane_PhpExcel
{

    private $_oPhpExcel = null;

    protected $_aStyles = array(
        'blue' => array('font' => array('color' => array('rgb' => '434397'))),
        'bold' => array('font' => array('bold' => true)),
        'italic' => array('font' => array('italic' => true)),
        'border-top-medium' => array(
            'borders' => array(
                'top' => array('color' => array('rgb' => '000000'), 'style' => PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        ),
        'border-left-medium' => array(
            'borders' => array(
                'left' => array('color' => array('rgb' => '000000'), 'style' => PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        ),
        'border-top-thin' => array(
            'borders' => array(
                'top' => array('color' => array('rgb' => '000000'), 'style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ),
        'border-left-thin' => array(
            'borders' => array(
                'left' => array('color' => array('rgb' => '000000'), 'style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        ),
        'background-grey' => array(
            'fill' => array(
                 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'rotation' => 0, 'color' => array('rgb' => 'C0C0C0')
            )
        ),
        'center' => array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => true
            )
        ),
        'right' => array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => true
            )
        ),
        'dateFormat_dd/mm/yyyy' => array('numberformat' => array('code' => 'dd/mm/yyyy')),

    );

    public function __construct($filename = null)
    {
        PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());
        if ($filename == null) {
            $this->_oPhpExcel = new PHPExcel();
        } else {
            $this->_oPhpExcel = PHPExcel_IOFactory::load($filename);
        }
    }


    public function __call($name, $args)
    {
        return call_user_func_array(array($this->_oPhpExcel, $name), $args);
    }

    public function __get($name)
    {
        return $this->_oPhpExcel->$name;
    }

    public function __set($name, $value)
    {
        $this->_oPhpExcel->$name = $value;
        return $this;
    }

    public function __isset($name)
    {
        return isset($this->_oPhpExcel->$name);
    }

    public function __unset($name)
    {
        unset($this->_oPhpExcel->$name);
    }

    public function cMin($a, $b)
    {
        if (strlen($a) < strlen($b)) {
            return $a;
        }
        if (strlen($b) < strlen($a)) {
            return $b;
        }
        if ($a < $b) {
            return $a;
        }
        return $b;
    }

    public function cMax($a, $b)
    {
        if (strlen($a) > strlen($b)) {
            return $a;
        }
        if (strlen($b) > strlen($a)) {
            return $b;
        }
        if ($a > $b) {
            return $a;
        }
        return $b;
    }

    public function setCellValue($cellCoordinate = 'A1', $value = null)
    {
        return $this->_oPhpExcel->getActiveSheet()->getCell($cellCoordinate)->setValue($value);
    }

    public function getCellValue($cellCoordinate = 'A1', $bCalculated = false)
    {
        if ($bCalculated) {
            return $this->_oPhpExcel->getActiveSheet()->getCell($cellCoordinate)->getCalculatedValue();
        }
        return $this->_oPhpExcel->getActiveSheet()->getCell($cellCoordinate)->getValue();
    }

    public function getStyle($cellCoordinate = 'A1')
    {
        return $this->_oPhpExcel->getActiveSheet()->getStyle($cellCoordinate);
    }

    public function setStyle($cellCoordinate = 'A1', $arrayOfStyles = array())
    {
        if (is_array($arrayOfStyles)) {
            return $this->_oPhpExcel->getActiveSheet()->getStyle($cellCoordinate)->applyFromArray($arrayOfStyles);
        } elseif (is_string($arrayOfStyles) && isset($this->_aStyles[$arrayOfStyles])) {
            $arrayOfStyles = $this->_aStyles[$arrayOfStyles];
            return $this->_oPhpExcel->getActiveSheet()->getStyle($cellCoordinate)->applyFromArray($arrayOfStyles);
        } else {
            throw new Exception('Try to apply an undefined style');
        }

    }

    public function setStyles($cellCoordinate = 'A1', $arrayOfStyles = array())
    {
        foreach ($arrayOfStyles as $stylesNames) {
            if (isset($this->_aStyles[$stylesNames])) {
                $this->setStyle($cellCoordinate, $this->_aStyles[$stylesNames]);
            } else {
                throw new Exception('Try to apply an undefined style');
            }
        }
        return $this;
    }

    public function mergeCells($startCoord, $endCoord)
    {
        return $this->_oPhpExcel->getActiveSheet()->mergeCells($startCoord . ':' . $endCoord);
    }

    public function roundBorders($coord, $style = PHPExcel_Style_Border::BORDER_MEDIUM, $color = '000000')
    {
        $styleArray = array(
            'borders' => array('outline' => array('style' => $style, 'color' => array('rgb' => $color)))
        );
        $this->setStyle($coord, $styleArray);
    }

    public function coverageBorders($coord, $style = PHPExcel_Style_Border::BORDER_MEDIUM, $color = '000000')
    {
        $styleArray = array(
            'borders' => array(
                'inside' => array('style' => $style, 'color' => array('rgb' => $color)),
                'outline' => array('style' => $style, 'color' => array('rgb' => $color)),
            )
        );
        $this->setStyle($coord, $styleArray);
    }

    public function save($filename, $format = 'Excel5')
    {
        Actiane_Utils_File::createFolder($filename, 0755);

        $oPhpExcelWriter = PHPExcel_IOFactory::createWriter($this->_oPhpExcel, $format);
        return $oPhpExcelWriter->save($filename);
    }


    public function drawCra($aData, $date)
    {
        $session = new Zend_Session_Namespace('identity');

        $activeSheet = $this->_oPhpExcel->getActiveSheet();
        $sNom = $session->nom;
        $sPrenom = $session->prenom;

        $this->setCellValue('B3', $sNom);
        $this->setCellValue('B4', $sPrenom);

        list($year, $month, ) = explode('-', $date, 3);
        $monthName = ucfirst(Actiane_Utils_Date::getLitteralMonth($month));
        $this->setCellValue('A5', $monthName . ' - ' . $year);

        $this->setCellValue('B7', 'MATIN');
        $this->setStyles('B7', array('blue', 'bold', 'center'));
        $this->setCellValue('C7', 'APRÈS-MIDI');
        $this->setStyles('C7', array('blue', 'bold', 'center'));
        $this->setCellValue('D7', 'TOTAL H/JOUR');
        $this->setStyles('D7', array('blue', 'center'));
        $this->setCellValue('E7', 'AFFECTATION (CLIENT / CONGÉS)');
        $this->setStyles('E7', array('blue', 'italic', 'center'));

        $this->setStyles('A8:E8', 'border-top-medium');

        $row = '8';
        $sumWeekRow = array();
        $key = -1;
        $nbLinesWeek = 0;
        foreach ($aData as $v) {
            $key++;
            $date = date('d/m/Y', strtotime($v['date']));
            $noWork = ($v['weekend'] || $v['publicHoliday']);
            $numWeekDay = date('N', strtotime($v['date']));

            if ($numWeekDay < 6) {
                $this->setCellValue('A' . $row, $date);
                $this->setStyle('A' . $row, 'dateFormat_dd/mm/yyyy');
                $row = $this->_drawWorkRow($v, $row, $nbLinesWeek);
            }
            if ($numWeekDay == 6 && $key != 0) {
                $weekRow = $this->_drawSumRowWeek($row, $key);
                $rowBackValue = min($nbLinesWeek, $nbLinesWeek);
                $coordinates = 'A' . ($row-$rowBackValue) . ':E' . $row;
                $this->coverageBorders($coordinates, PHPExcel_Style_Border::BORDER_THIN);
                $sumWeekRow[] = $weekRow;
                $row++;
                $nbLinesWeek = 0;
            }
            if ($numWeekDay > 5) {
                $this->setCellValue('A' . $row, $date);
                $this->setStyle('A' . $row, 'dateFormat_dd/mm/yyyy');
                if (isset($v['matin'])) {
                   $this->setCellValue('B' . $row, $v['matin'] / 60);
                   $this->setCellValue('D' . $row, '=C' . $row . '+B' . $row);
                }
                if (isset($v['apresMidi'])) {
                   $this->setCellValue('C' . $row, $v['apresMidi'] / 60);
                   $this->setCellValue('D' . $row, '=C' . $row . '+B' . $row);
                }
                if (isset($v['nomClient'])) {
                    $this->setCellValue('E' . $row, $v['nomClient']);
                }

                $cellStyle = array('background-grey');
                if ($numWeekDay == 6) {
                    $cellStyle[] = 'border-top-medium';
                }
                $this->setStyles('A' . $row . ':E' . $row, $cellStyle);
                $row++;
            }
        }
        $lastData = end($aData);
        $numWeekDay = date('N', strtotime($lastData['date']));
        $rowBackValue = min(count($aData), $numWeekDay);

        $sumWeekRow[] = $this->_drawSumRowWeek($row, $rowBackValue);
        $coordinates = 'A' . ($row-$rowBackValue) . ':E' . $row;
        $this->coverageBorders($coordinates, PHPExcel_Style_Border::BORDER_THIN);
        $this->roundBorders('A7:E' . $row);
        $row++;

        $this->mergeCells('A' . $row, 'C' . $row);
        $this->setCellValue('A' . $row, 'TOTAL MOIS');
        $this->setStyles('A' . $row, array('blue', 'bold', 'right'));
        $formulaMonth = '=';
        foreach ($sumWeekRow as $numRow) {
            $formulaMonth .= 'D' . $numRow . '+';
        }
        $formulaMonth = substr($formulaMonth, 0, -1);
        $this->setCellValue('D' . $row, $formulaMonth);
        $this->setStyles('D' . $row, array('blue', 'bold', 'right'));
        $this->roundBorders('A' . $row . ':E' . $row);

        //Date :
        $row += 2;
        $this->setCellValue('A' . $row, 'Date');
        $this->setStyles('A' . $row, array('blue', 'bold'));
        $this->mergeCells('B' . $row, 'C' . $row);
        $this->setCellValue('B' . $row, date('d/m/Y'));
        $this->setStyle('B' . $row, 'dateFormat_dd/mm/yyyy');

        //Signature :
        $row += 2;
        $this->mergeCells('A' . $row, 'B' . $row);
        $this->setCellValue('A' . $row, 'Signature du salarié');
        $this->setStyles('A' . $row, array('blue', 'bold'));

        $this->formatDocument('A1:E' . ($row+1));

        $acronyme = $session->acronyme;
        return $year . '-' . $month . '/' . $acronyme . '.xlsx';


    }

    private function _drawWorkRow($v, $row, &$nbLinesWeek)
    {
        if (
            (isset($v['matinConges']) || isset($v['apresMidiConges'])) &&
            $v['matin'] == 0 &&
            $v['apresMidi'] == 0
        ) {
            $this->setCellValue('B' . $row, round($v['matinConges'] / 60, 2));
            $this->setCellValue('C' . $row, round($v['apresMidiConges'] / 60, 2));
            $this->setCellValue('D' . $row, '=C' . $row . '+B' . $row);
            $this->setCellValue('E' . $row, $v['libelle']);
            $color = substr($v['code'], 1);
            $this->setStyle(
                'A' . $row . ':E' . $row,
                array(
                    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => $color))
                )
            );
        } else {
            $this->setCellValue('B' . $row, round($v['matin'] / 60, 2));
            $this->setCellValue('C' . $row, round($v['apresMidi'] / 60, 2));
            $this->setCellValue('D' . $row, '=C' . $row . '+B' . $row);
            $this->setCellValue('E' . $row, $v['nomClient']);

            if (isset($v['matinConges']) || isset($v['apresMidiConges'])) {
                $row++;
                $nbLinesWeek++;
                $this->setCellValue('A' . $row, $v['date']);
                $this->setStyle('A' . $row, 'dateFormat_dd/mm/yyyy');
                $this->setCellValue('B' . $row, round($v['matinConges'] / 60, 2));
                $this->setCellValue('C' . $row, round($v['apresMidiConges'] / 60, 2));
                $this->setCellValue('D' . $row, '=C' . $row . '+B' . $row);
                $this->setCellValue('E' . $row, $v['libelle']);
                $color = substr($v['code'], 1);
                $this->setStyle(
                    'A' . $row . ':E' . $row,
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => $color)
                        )
                    )
                );
            }
        }
        $row++;
        $nbLinesWeek++;
        return $row;
    }

    private function _drawSumRowWeek($row, $key)
    {
        $this->mergeCells('A' . $row, 'C' . $row);
        $this->setCellValue('A' . $row, 'TOTAL SEMAINE');
        $this->setStyles('A' . $row, array('blue', 'bold', 'right'));
        $rowBackValue = min($key, 7);
        $this->setCellValue('D' . $row, '=SUM(D' . ($row-$rowBackValue) . ':D' . ($row-1) . ')');
        $this->setStyles('D' . $row, array('blue', 'bold', 'right'));

        return $row;
    }

    public function formatDocument($coord)
    {
        $this->_oPhpExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
    }
}
