<?php

App::import('Validation');

class Audiencia extends AppModel {
	var $name='Audiencia';
	
	public $useTable = 'audiencias'; // This model uses a database table 'audiencias'

	public $belongsTo = array(
		'Sala' => array(
			'className' => 'Sala',
			'foreignKey' => 'sala_id',
			'dependent' => true
		)
    );
    
	var $validate = array(
		'expediente' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Debe ingresar un numero de expediente.'
			),
			'type' => array(
				'rule'    => array('custom', "/^[0-9]+-[a-zA-Z]+-[0-9]{4}$/"),
				'message' => 'Ingrese [Numero]-[Iniciador]-[Año 4 digitos]',
			)
		),
		'sala_id' => array(
			'check' => array(
				'rule' => 'chequearDisponibilidadSala',
				'message' => 'La sala seleccionada se encuentra reservada en ese horario para otra Audiencia.'
			)
		),
		'fecha' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Por favor seleccione una fecha.'
			),
			'type' => array(
				'rule' => 'date',
				'message' => 'debe ingresar una fecha valida.'
			)
		),
		'hora_ini' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'No selecciono una fecha de finalización.'
			),
			'type' => array(
				'rule'    => 'datetime',
				'message' => 'No se ingreso una hora valida',
			)
		),
		'hora_fin' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'No selecciono una fecha de finalización.'
			),
			'type' => array(
				'rule'    => 'datetime',
				'message' => 'No se ingreso una hora valida',
			)
		)
	);
	
	// ##############################
	// ######### FUNCTIONS ##########
	// ##############################
	
	public function add($data){

		// Set default timezone to Buenos Aires.
		date_default_timezone_set('America/Buenos_Aires');
		// Set datetime 
		$data['Audiencia']['created'] = date('Y-m-d H:i:s');
		$data['Audiencia']['hora_ini']  =  $data['Audiencia']['fecha'].' '.$data['Audiencia']['hora_ini'];
		$data['Audiencia']['hora_fin']  =  $data['Audiencia']['fecha'].' '.$data['Audiencia']['hora_fin'];

		return $this->save($data);
	}
	
	private function chequearDisponibilidadSala($data=false){
		if($data == false){
			return false;
		}
			//Busco dentro de las Audiencias de la persona una situacion no compatible.
		$aud = $this->query(" SELECT Audiencia.id FROM audiencias AS Audiencia 
													WHERE (
															Audiencia.sala_id = '{$data['Audiencia']['sala_id']}' AND
															((
															Audiencia.hora_ini > '{$data['Audiencia']['hora_ini']}'
																AND
															Audiencia.hora_ini < '{$data['Audiencia']['hora_fin']}'
															) OR (
															Audiencia.hora_fin > '{$data['Audiencia']['hora_ini']}'
																AND 
															Audiencia.hora_fin < '{$data['Audiencia']['hora_fin']}'
															))
														)
												");
		// Si encontre una Audiencia que coincide con la sala y horario de la audiencia retorno false.
		if($aud){ return false;}					

		// Si no encontre coincidencia de horarios retorno true.
		return true;
	}
}

?>
