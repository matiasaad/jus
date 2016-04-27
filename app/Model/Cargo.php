<?php

App::import('Validation');

class Cargo extends AppModel {
	var $name='Cargo';
	
	public $useTable = 'cargos'; // This model uses a database table 'cargos'

	public $hasOne = array(
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'cargo_id',
			'dependent' => true
		)
    );
}

?>
