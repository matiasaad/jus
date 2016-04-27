<?php

App::import('Validation');

class Sala extends AppModel {
	var $name='Sala';
	
	public $useTable = 'salas'; // This model uses a database table 'salas'

	public $hasMany = array(
		'Audiencias' => array(
			'className' => 'Audiencia',
			'foreignKey' => 'sala_id',
			'dependent' => true
		)
    );

	public $disponibilidad_horaria = array("hora_inicio"=>"8:00:00", "hora_fin"=>"20:00:00");

}

?>
