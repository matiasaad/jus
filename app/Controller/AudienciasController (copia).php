<?php

App::uses('Sanitize', 'Utility');
App::uses('Validation','Utility');

class AudienciasController extends AppController
{
	public $name = 'Audiencias';
	public $layout = 'bootstrap';
	public $components = array('UserSession', 'Session', 'Misc');
	public $uses = array('Usuario', 'Audiencia', 'Sala');

	// se refiere a los sectores del sistema, no a los actores(tipo de usuarios).
	private $permissions=array('sys_admin'=>1000, 'administrativo'=>1, 'juez'=>100, 'fiscal'=>10);

	private $redirections = array(
								'no_permissions' => array('controller'=>'Audiencias', 'action'=>'dashboard'),
								'security' => array('controller'=>'Audiencias', 'action'=>'dashboard'),
								'audiencia_not_found' => array('controller'=>'Audiencias', 'action'=>'dashboard'),
								'audiencia' => array('controller'=>'Audiencias', 'action'=>'dashboard')
							);
							
	private $msg_errors = array(
							'uuid' => 'Se aborto por un error de proteccion del sistema.',
							'permissions' => 'Usted no tiene permiso para acceder a esta sección.',
							'audiencia_not_found' => 'No se encontro la audiencia. Se realizo la redireccion para resguardar la seguridad.'
						  );

//---------------------------------------------------------------------------
//	VISTAS
//---------------------------------------------------------------------------
	
	function dashboard(){
		
	}

	function nuevaAudiencia(){
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permissions.
		if (!in_array( $user['Usuario']['type'],array($this->permissions['sys_admin'],$this->permissions['administrativo']))){
			$this->Session->setFlash($this->msg_errors['permissions'], 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect($this->redirections['no_permissions']);exit;
		}

		//$horarios_salas = $this->getHorariosSalas("2016-04-22");//date('Y-m-d'));
		//$horarios_salas = $this->getHorariosSalas(date('Y-m-d'), false);
		
		//$salas = $this->getSalasInfoInDate('2016-04-22',false);//date('Y-m-d'),false);
		//$salas = $this->getSalasInfoInDate(date('Y-m-d'),false);

		// Obtengo las salas disponibles
		$this->Sala->unbindModel(array('hasMany'=>array('Audiencias')));
		$salas = $this->Sala->find('all', array('conditions'=>array(
													'Sala.oficina_judicial_id'=>$user['Usuario']['oficina_judicial_id']
											  ),'order'=>'Sala.numero ASC'));

		// Enviando los datos a la vista.
		$this->set('horarios_salas',$horarios_salas);
		$this->set('salas', $salas);
	}
	
	public function getHorariosSalas($date, $ajax = true){
		// Check if user has logged.
		$user = $this->UserSession->get();
		
		// Fraccionamiento de GRID para la seleccion horaria de las salas
		$fraccion = 15;

		if(!$date || (!in_array($user['Usuario']['type'], array($this->permissions['sys_admin'],$this->permissions['administrativo'])))){
			if($ajax){
				$this->response->statusCode('400');
				
				$this->response->type( 'json' );
				$this->response->body(json_encode('an unexpected error has occurred!'));
				$this->response->send(); exit;
			}
			return false;
		}
		
		// procesamiento de horarios disponibles de las salas.
		$hora_inicio = strtotime($date.' '.$this->Sala->disponibilidad_horaria['hora_inicio']);
		$hora_fin = strtotime($date.' '.$this->Sala->disponibilidad_horaria['hora_fin']);
	
		$horarios_salas = array();
		
		for($hora=$hora_inicio; $hora <= $hora_fin; $hora = strtotime('+'.$fraccion.' minutes', $hora)){
			
			$horarios_salas[] = array('hora'=>date("H:i",$hora), 'unix'=> $hora);
		}
		
		// Formo la respuesta y la envio
		if($ajax){
			$this->response->body( json_encode($horarios_salas));
			$this->response->type( 'json' );
			$this->response->send(); exit;
		}
		
		return $horarios_salas;
	}
	
	
	
	// Funcion que obtiene los horarios ocupados de las salas.
	// Puede funcionar por Ajax o por un llamado interno.
	// por defecto en el caso de no especificar asume que es por Ajax
	public function getSalasInfoInDate($date = false, $ajax = true){

		// Check if user has logged.
		$user = $this->UserSession->get();

		if(!$date || (!in_array($user['Usuario']['type'], array($this->permissions['sys_admin'],$this->permissions['administrativo'])))){
			if($ajax){
				$this->response->statusCode('400');
				
				$this->response->type( 'json' );
				$this->response->body(json_encode('an unexpected error has occurred!'));
				$this->response->send(); exit;
			}
			return false;
		}
		
		// Obtengo las salas disponibles
		$this->Sala->unbindModel(array('hasMany'=>array('Audiencias')));
		$salas = $this->Sala->find('all', array('conditions'=>array(
													'Sala.oficina_judicial_id'=>$user['Usuario']['oficina_judicial_id']
											  ),'order'=>'Sala.numero ASC'));
		
		$response = array();
		
		foreach($salas as $sala){
			
			$this->Audiencia->unbindModel(array('belongsTo'=>array('Sala')));
			$audiencias_a = $this->Audiencia->find('all', array('conditions'=>array('Audiencia.fecha'=>$date,
																				  'Audiencia.sala_id'=>$sala['Sala']['id']
																)));
			$audiencias = array();
			foreach($audiencias_a as $audiencia){
				$audiencia['Audiencia']['hora_ini_ml'] = strtotime($date." ".$audiencia['Audiencia']['hora_ini']);
				$audiencia['Audiencia']['hora_fin_ml'] = strtotime($date." ".$audiencia['Audiencia']['hora_fin']);
				$audiencias[] = $audiencia;
			}

			$response[] = array('Sala'=>$sala['Sala'], 'Audiencias'=>$audiencias);
		}
		
		// Formo la respuesta y la envio
		if($ajax){
			$this->response->body( json_encode($response));
			$this->response->type( 'json' );
			$this->response->send(); exit;
		}
		
		return $response;
		
	}
	
	
	/**
	 * ################### SAVE DATA ######################
	 */
	 public function saveAudiencia(){
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permissions.
		if (!in_array( $user['Usuario']['type'],array($this->permissions['sys_admin'],$this->permissions['administrativo']))){
			$this->Session->setFlash($this->msg_errors['permissions'], 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect($this->redirections['no_permissions']);exit;
		}
		
		
		$data = $this->data;
		print_r($data);exit;
	}
	
}
?>
