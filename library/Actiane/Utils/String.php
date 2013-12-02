<?php
class Actiane_Utils_String
{

    public static function cryptMdp($password, $passwordHasher)
    {
    	$mdp = sha1('Actiane_' . $password . $passwordHasher);
    	return $mdp;
    }
}