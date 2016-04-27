<?php

App::import('Validation');

class Persona extends AppModel {
	var $name='Persona';
	
	public $useTable = 'personas'; // This model uses a database table 'personas'
	
	public $hasMany = array(
		'Ocupaciones' => array(
			'className' => 'Ocupacion',
			'foreignKey' => 'persona_id',
			'dependent' => true
		)
    );

}

?>
