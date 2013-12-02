<?php
class Actiane_Utils_Array {
    public static function array_switch_keys($array) {
        $return = array();
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                  continue;
            }
            foreach (array_keys($value) as $index) {
                $return[$index][$key] = $value[$index];
            }
        }
        return $return;
    }
}