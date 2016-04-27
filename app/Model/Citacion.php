<?php

App::import('Validation');

class Citacion extends AppModel {
	var $name='Citacion';
	
	public $useTable = 'citaciones'; // This model uses a database table 'citaciones'
	
	public $hasOne = array(
		'Audiencia' => array(
			'className' => 'Audiencia',
			'foreignKey' => 'audiencia_id',
			'dependent' => true
		),
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'persona_id',
			'dependent' => true		
		)
    );	

	// ##############################
	// ######### FUNCTIONS ##########
	// ##############################
	
	public function add($data){

		// Set default timezone to Buenos Aires.
		date_default_timezone_set('America/Buenos_Aires');
		// Set datetime 
		$data['Citacion']['created'] = date('Y-m-d H:i:s');
		
		return $this->save($data);
	}
}

?>
