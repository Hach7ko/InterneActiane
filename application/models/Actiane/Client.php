<?php

class Actiane_Client extends Actiane_Db_Table
{
	protected $_table = 'client';
	protected $_colonne = array('nom', 'couleur', 'interne', 'secteur', 'siret', 'tva', 'entite', 'siege', 'facturation', 'contactp', 'telp', 'mailp', 'contacts', 'tels', 'mails','contactc', 'telc', 'mailc');
}
