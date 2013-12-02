<?php
class Actiane_Utils_Date
{

    public static function getParsedDate($input)
    {
		$preg = preg_match('#^([0-9]{2,4})[./* -]([0-9]{2})[./* -]([0-9]{2,4})$#', $input, $matches);

		if ($preg === 0) {
			echo 'Error1';
			return false;
		}

		$year = $month = $day = null;
		if (strlen($matches[1]) === 4) {
			$year = $matches[1];
		}
		elseif (strlen($matches[1]) === 2) {
			$day = $matches[1];
		}
		else {
			echo 'Error2';
			return false;
		}

		$month = $matches[2];

		if (strlen($matches[3]) === 4 && $year === null) {
			$year = $matches[3];
		}
		elseif (strlen($matches[3]) === 2 && $day === null) {
			$day = $matches[3];
		}
		else {
			echo 'Error3';
			return false;
		}

		if (checkdate($month, $day, $year)) {
			return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
		}
		else {
			echo 'Error4';
			return false;
		}
	}


	public static function getAllDaysMonth($year, $month)
	{
	    $nbDays = date('t', strtotime($year . '-' . $month . '-01'));

	    $aDays = array();
	    foreach (range(1, $nbDays) as $numDay) {
	        $date = $year . '-' . $month . '-' . str_pad($numDay, 2, '0', STR_PAD_LEFT);
	        $timestamp = strtotime($date);
	        $aDays[$date] = array(
	            'date' => $date,
	            'numDay' => str_pad($numDay, 2, '0', STR_PAD_LEFT),
	            'weekend' => (date('N', $timestamp) > 5),
	            'publicHoliday' => self::isPublicHolidays($date),
	        );
	    }

	    return $aDays;
	}

	public static function isPublicHolidays($date)
	{
        //Common public holidays
        $aCommon = array(
            '01-01', //New year
            '05-01', //Fête du Travail
            '05-08', //WWII ended
            '07-14', //National day
            '08-15', //Assomption
            '11-01', //Toussaint
            '11-11', //WWI ended
            '12-25', //Christmas
        );
        if (in_array(date('m-d', strtotime($date)), $aCommon)) {
            return true;
        }

        $easterDay = self::getEasterDay($date);

        $aRelatedEaster = array(
            date('m-d', strtotime($easterDay . ' +1 day')), //Easter Monday
            date('m-d', strtotime($easterDay . ' +39 days')), //Ascension
            date('m-d', strtotime($easterDay . ' +50 days')), //Pentecôte
        );
	    if (in_array(date('m-d', strtotime($date)), $aRelatedEaster)) {
            return true;
        }
        return false;

	}

	public static function getEasterDay($date)
	{
        $y = date('Y', strtotime($date));
        $c = floor($y / 100);
        $n = $y % 19;
        $k = floor(($c - 17) / 25);
        $b = floor($c / 4);
        $e = floor(($c - $k) / 3);
        $f = $c - $b - $e + (19 * $n) + 15;
        $h = $f % 30;
        $p = floor($h / 28);
        $q = floor(29 / ($h + 1));
        $r = floor((21 - $n) / 11);
        $i = $h - ($p * (1 - ($p * $q * $r)));
        $s = floor($y / 4);
        $t = floor($c / 4);
        $u = $y + $s + $i + 2 - $c + $t;
        $j = $u % 7;
        $w = floor(($i - $j + 40) / 44);
        $m = 3 + $w;
        $x = floor($m / 4);
        $d = $i - $j + 28 - (31 * $x);

        $easterDay = $y . '-' . str_pad($m, 2, '0', STR_PAD_LEFT) . '-' . str_pad($d, 2, '0', STR_PAD_LEFT);
        return $easterDay;
	}

	public static function getLitteralMonth($month)
	{
	    $aMonth = array(
            1 => 'janvier',
            2 => 'février',
            3 => 'mars',
            4 => 'avril',
            5 => 'mai',
            6 => 'juin',
            7 => 'juillet',
            8 => 'août',
            9 => 'septembre',
            10 => 'octobre',
            11 => 'novembre',
            12 => 'décembre',
	    );

	    $month = intval($month);
	    if (isset($aMonth[$month])) {
	        return $aMonth[$month];
	    }
	    return null;
	}
}