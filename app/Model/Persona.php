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

	public $disponibilidad_horaria = array("hora_inicio"=>"8:00:00", "hora_fin"=>"20:00:00");

	// ######################################
	// ############ FUNCTIONS ###############
	// ######################################
	
	// Retorna un arreglo formateado con los horarios disponibles de las personas.	
	public function getHorarios(){

				
		// Fraccionamiento de GRID para la seleccion horaria de las salas
		$fraccion = 15;
		
		// procesamiento de horarios disponibles de las salas.
		$hora_inicio = strtotime($this->disponibilidad_horaria['hora_inicio']);
		
		$hora_fin = strtotime($this->disponibilidad_horaria['hora_fin']);
	
		$horarios_salas = array();
		
		for($hora=$hora_inicio; $hora <= $hora_fin; $hora = strtotime('+'.$fraccion.' minutes', $hora)){
			
			$horarios_salas[] = array('hora'=>date("H:i",$hora), 'unix'=> $hora);
		}
		
		return $horarios_salas;
	}

}

?>
