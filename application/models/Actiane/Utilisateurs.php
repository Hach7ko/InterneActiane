<?php

class Actiane_Utilisateurs extends Actiane_Db_Table
{
	protected $_table = 'utilisateur';
	protected $_colonne = array('login', 'password', 'dateLastConnect', 'dateConnect', 'emailConfirm', 'passwordHasher');
}
