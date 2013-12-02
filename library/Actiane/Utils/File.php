<?php
class Actiane_Utils_File {

    public static function createFolder($filename, $chmod = 0755) {
        if (!is_dir(dirname($filename))) {
            return mkdir(dirname($filename), $chmod, true);
        }
        return true;
    }
}