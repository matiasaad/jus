<?php

App::uses('Sanitize', 'Utility');
App::uses('Validation','Utility');

class AudienciasController extends AppController
{
	public $name = 'Audiencias';
	public $layout = 'bootstrap';
	public $components = array('UserSession', 'Session', 'Misc');
	public $uses = array('Usuario', 'Audiencia', 'Sala', 'Persona', 'Cargo', 'Citacion', 'Ocupacion');

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
	
	function dashboard($page = 1){
		//Check if user has logged.
		$user = $this->UserSession->get();
	
		// Check permissions.
		if (!in_array( $user['Usuario']['type'],array($this->permissions['sys_admin'],$this->permissions['administrativo']))){
			$this->Session->setFlash($this->msg_errors['permissions'], 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect($this->redirections['no_permissions']);exit;
		}
		
		//$audiencias = $this->Citacion->find("all");
		//print_r($audiencias);exit;
	}


	/**
	 **  Calcula y maneja los datos para pasarlos a la vista de nuevaAudiencia.
	 **/
	function nuevaAudiencia(){
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Set default timezone
		date_default_timezone_set('America/Buenos_Aires');		
		
		
		// Check permissions.
		if (!in_array( $user['Usuario']['type'],array($this->permissions['sys_admin'],$this->permissions['administrativo']))){
			$this->Session->setFlash($this->msg_errors['permissions'], 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect($this->redirections['no_permissions']);exit;
		}

		// Obtengo los horarios disponibles de las salas para luego pasarlos a la vista.
		$horarios_salas = $this->Sala->getHorarios();

		// Obtengo los horarios disponibles de las salas para luego pasarlos a la vista.
		$horarios_personas = $this->Persona->getHorarios();

		// obtengo las ocupaciones de las salas
		$salas = $this->getSalasInfoInDate(date('Y-m-d'),false);

		$jueces = $res = $this->Cargo->find("all", array('conditions'=>array('Cargo.cargo_nombre' => "Juez")));
		$defensores = $this->Cargo->find("all", array('conditions'=>array('Cargo.cargo_nombre' => "Defensor")));
		$fiscales = $this->Cargo->find("all", array('conditions'=>array('Cargo.cargo_nombre' => "Fiscal")));

		$personas = array('jueces' => $jueces, 'defensores' => $defensores, 'fiscales'=>$fiscales);


		// check for data
		if($this->Session->check('data')){
			$data = $this->Session->read('data');
			
			// Completo $data con los datos necesarios para la vista.
			
			if(isset($data['Audiencia']['sala_id']) && !empty($data['Audiencia']['sala_id'])){
				$this->Sala->unbindModel(array('hasMany'=>array('Audiencias')));
				$data['Audiencia']['Sala'] = $this->Sala->find("first", array('conditions'=>array('Sala.id'=>$data['Audiencia']['sala_id'])));
			}

			if(isset($data['Citacion']['juez_id']) && !empty($data['Citacion']['juez_id'])){
				$this->Persona->unbindModel(array('hasMany'=>array('Ocupaciones')));
				$data['Citacion']['juez'] = $this->Persona->find("first", array('conditions'=>array('Persona.id'=>$data['Citacion']['juez_id'])));
			}
			if(isset($data['Citacion']['juez_id']) && !empty($data['Citacion']['defensor_id'])){
				$this->Persona->unbindModel(array('hasMany'=>array('Ocupaciones')));
				$data['Citacion']['defensor'] = $this->Persona->find("first", array('conditions'=>array('Persona.id'=>$data['Citacion']['defensor_id'])));
			}
			if(isset($data['Citacion']['juez_id']) && !empty($data['Citacion']['fiscal_id'])){
				$this->Persona->unbindModel(array('hasMany'=>array('Ocupaciones')));
				$data['Citacion']['fiscal'] = $this->Persona->find("first", array('conditions'=>array('Persona.id'=>$data['Citacion']['fiscal_id'])));
			}

			$this->set('data',$data);
			$this->Session->delete('data');
		}

		// En caso de haber encontrado un error en los datos de la audiencia
		if($this->Session->check('audiencia_errors')){
			$this->Audiencia->validationErrors = $this->Session->read('audiencia_errors');
			$this->Session->delete('audiencia_errors');
		}
		
		// En caso de haber encontrado un error en las citaciones.
		if($this->Session->check('citacion_errors')){
			$this->Citacion->validationErrors = $this->Session->read('citacion_errors');
			$this->Session->delete('citacion_errors');
		}	

		// Enviando los datos a la vista.
		$this->set('personas',$personas);
		$this->set('horarios_salas',$horarios_salas);
		$this->set('horarios_personas',$horarios_personas);
		$this->set('salas', $salas);
	}
		
	
	// Funcion que obtiene los horarios ocupados de las salas.
	// Puede funcionar por Ajax o por un llamado interno.
	// por defecto en el caso de no especificar asume que es por Ajax
	public function getSalasInfoInDate($date = false, $ajax = true){

		// Check if user has logged.
		$user = $this->UserSession->get();

		if(!$date || (!in_array($user['Usuario']['type'], array($this->permissions['sys_admin'],$this->permissions['administrativo'])))){
			$this->response->statusCode('400');
			
			$this->response->type( 'json' );
			$this->response->body(json_encode('an unexpected error has occurred!'));
			$this->response->send(); exit;
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
				
				$audiencia['Audiencia']['hora_ini_ml'] = strtotime(date('Y-m-d').' '.date('H:i:s',strtotime($audiencia['Audiencia']['hora_ini'])));
				$audiencia['Audiencia']['hora_fin_ml'] = strtotime(date('Y-m-d').' '.date('H:i:s',strtotime($audiencia['Audiencia']['hora_fin'])));
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
	
	// Funcion que obtiene los horarios de una persona.
	// funciona mediante un llamado por ajax
	public function getPersonasTimetable($persona_id = false, $date = 'today'){

		// Check if user has logged.
		$user = $this->UserSession->get();

		// Chequeo permisos de ususario.
		if(!$date || (!in_array($user['Usuario']['type'], array($this->permissions['sys_admin'],$this->permissions['administrativo'])))){
			$this->response->statusCode('400');
			
			$this->response->type( 'json' );
			$this->response->body(json_encode('an unexpected error has occurred!'));
			$this->response->send(); exit;
		}

		// chequeo de datos.
		if(!$persona_id){
			$this->response->statusCode('400');
			$this->response->type( 'json' );
			$this->response->body(json_encode('Error en la conexion con el servidor!'));
			$this->response->send(); exit;
		}

		if($date == 'today'){ $date = date('Y-m-d');}
		$ocupaciones = $this->Ocupacion->query(" SELECT fecha, hora_desde as hora_ini, hora_hasta as hora_fin 
													FROM ocupaciones as Horarios
													WHERE Horarios.fecha = '{$date}' 
															AND 
														Horarios.persona_id = '{$persona_id}'
													ORDER BY Horarios.hora_desde ASC
											");

		$audiencias = $this->Audiencia->query(" SELECT Horarios.fecha, Horarios.hora_ini, Horarios.hora_fin 
												FROM citaciones as Citacion
												JOIN audiencias as Horarios on (Citacion.audiencia_id = Horarios.id)
													WHERE Horarios.fecha = '{$date}'
															AND
														  Citacion.persona_id = '{$persona_id}'
													ORDER BY Horarios.hora_ini ASC
											");

		// Tengo que unir las respuestas de ambas consultas
		$horarios = array_merge($ocupaciones,$audiencias);

		$response = array();
		foreach($horarios as $horario){
			$response[] = array(
				'fecha' => $horario['Horarios']['fecha'],
				'hora_ini' => strtotime(date('Y-m-d').' '.date('H:i:s',strtotime($horario['Horarios']['hora_ini']))),
				'hora_fin' => strtotime(date('Y-m-d').' '.date('H:i:s',strtotime($horario['Horarios']['hora_fin'])))
			);
		}

		// Formo la respuesta y la envio		
		$this->response->body( json_encode($response));
		$this->response->type( 'json' );
		$this->response->send(); exit;
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
		
		// Obtengo los datos que llegan de la vista.
		
		$data = $this->data;

		// ----------------------------------------------------------
		// --------------- VALIDATE DATA 'AUDIENCIA' ---------------- 
		// ----------------------------------------------------------

		/**
		 * Check Audiencia
		 */

		$this->Audiencia->set($data['Audiencia']);
		
		if(!$this->Audiencia->validates()){
			$this->Session->write('audiencia_errors', $this->Audiencia->validationErrors);
		}
		$this->Audiencia->set(null);
		
		// ----------------------------------------------------------
		// --------------- VALIDATE DATA 'CITACION' -----------------
		// ----------------------------------------------------------
		
		// CHEQUEO QUE SE HAYA CITADO A TODOS LOS PARTICIPANTES NECESARIOS

		if(!isset($data['Citacion']['juez_id']) || empty($data['Citacion']['juez_id'])){
			$this->Citacion->validationErrors['juez_in'] = array("Debe seleccionar un Juez");
		}

		if(!isset($data['Citacion']['fiscal_id']) || empty($data['Citacion']['fiscal_id'])){
			$this->Citacion->validationErrors['fiscal_in'] = array("Debe seleccionar un Fiscal");
		}		

		if(!isset($data['Citacion']['defensor_id']) || empty($data['Citacion']['defensor_id'])){
			$this->Citacion->validationErrors['defensor_in'] = array("Debe seleccionar un Defensor");
		}

		// CHEQUEO DE HORARIO DE LOS PARTICIPANTES DE LA AUDIENCIA.

		// Chequeo que Los participantes esten disponiblen para la sala y horarios seleccionado
		// JUEZ
		if($data['Citacion']['juez_id'] && !$this->isAvailable($data['Citacion']['juez_id'], $data['Audiencia'])){
			$this->Citacion->validationErrors['juez_id'] = "El Juez no se encuentra disponible en el horario seleccionado";
		}

		// FISCAL
		if($data['Citacion']['fiscal_id'] && !$this->isAvailable($data['Citacion']['fiscal_id'], $data['Audiencia'])){
			$this->Citacion->validationErrors['fiscal_id'] = array("El Fiscal no se encuentra disponible en el horario seleccionado");
		}

		// DEFENSOR
		if($data['Citacion']['defensor_id'] && !$this->isAvailable($data['Citacion']['defensor_id'], $data['Audiencia'])){
			$this->Citacion->validationErrors['defensor_id'] = array("El Defensor no se encuentra disponible en el horario seleccionado");
		}
		

		
		if(isset($this->Citacion->validationErrors) && !empty($this->Citacion->validationErrors)){
			$this->Session->write('citacion_errors', $this->Citacion->validationErrors);
			$this->Session->write('data', $data);
			$this->redirect(array('controller'=>'Audiencias', 'action'=>'nuevaAudiencia'));exit;
		}


		// ----------------------------------------------------------
		// ------------------------- SAVE DATA ---------------------- 
		// ----------------------------------------------------------

		$datasource = $this->Audiencia->getDataSource();

		// EN ESTE BLOQUE ME ENCARGO DE GUARDAR LOS DATOS UTILIZANDO LAS
		// TRANSACCIONES QUE PROVEE MYSQL, ASEGURANDO ACID.
		try {
			$datasource->begin();

			// Hago el save de la Audiencia
			$audiencia['Audiencia'] = $data['Audiencia'];
			if(!$this->Audiencia->add($audiencia)){
				$this->Session->setFlash('Ocurrio un error al intentar establecer la reserva', 'default', array('class' => 'message_error'), 'message_error');
				// ARROJO LA EXCEPCION
				throw new InternalErrorException('Error Interno: 500  - ');
			}
			$audiencia_id = $this->Audiencia->id;

			// Hago el save de la citacion al Juez
			$citacion_juez['Citacion'] = array(
								'persona_id' => $data['Citacion']['juez_id'],
								'audiencia_id'=> $audiencia_id
							);
			$this->Citacion->create();
			if(!$this->Citacion->save($citacion_juez)){
				// ARROJO LA EXCEPCION
				throw new InternalErrorException('Error Interno: 500');
			}
			
			// Hago el save de la citacion al fiscal
			$citacion_fiscal['Citacion'] = array(
								'persona_id' => $data['Citacion']['fiscal_id'],
								'audiencia_id'=> $audiencia_id
							);
			$this->Citacion->create();
			if(!$this->Citacion->save($citacion_fiscal)){
				// ARROJO LA EXCEPCION
				throw new InternalErrorException('Error Interno: 500');
			}

			// Hago el save de la citacion al defensor
			$citacion_defensor['Citacion'] = array(
								'persona_id' => $data['Citacion']['defensor_id'],
								'audiencia_id'=> $audiencia_id
							);
			$this->Citacion->create();
			if(!$this->Citacion->save($citacion_defensor)){
				// ARROJO LA EXCEPCION
				throw new InternalErrorException('Error Interno: 500');
			}
			
			// HAGO EL COMMIT
			$datasource->commit();
		} catch(Exception $e) {
			// Si ocurrio un error debo hacer el ROLLBACK.
			$datasource->rollback();
			
			$this->Session->setFlash('Ocurrio un error al intentar establecer la reserva. - '.$e, 'default', array('class' => 'message_error'), 'message_error');
			$this->Session->write('data', $data);
			$this->redirect(array('controller'=>'Audiencias', 'action'=>'nuevaAudiencia'));exit;
		}

		// Se guardaron correctamente los datos.
		$this->Session->setFlash('Se realizo correctamente la reserva de la sala y las correspondientes citaciones a los jueces.', 'default', array('class' => 'message_info'), 'message_info');
		$this->redirect(array('controller'=>'Audiencias', 'action'=>'dashboard'));exit;		
	}
	

	private function isAvailable($persona_id = false, $audiencia = false){	
		//Busco dentro de las ocupaciones de la persona una situacion no compatible.
		$ocupacion = $this->Ocupacion->query(" SELECT Ocupacion.id FROM ocupaciones AS Ocupacion
													WHERE (
															(
																Ocupacion.persona_id = '$persona_id'
															) AND (
																	(
																	Ocupacion.hora_desde > '{$audiencia['hora_ini']}'
																		AND
																	Ocupacion.hora_desde < '{$audiencia['hora_fin']}'
																	) OR (
																	Ocupacion.hora_hasta > '{$audiencia['hora_ini']}'
																		AND
																	Ocupacion.hora_hasta < '{$audiencia['hora_fin']}'
																)
															)
														)
												");

		// Si encontre una Ocupacion que coincide con el horario de la audiencia retorno false.
		if($ocupacion){ return false;}

		//Busco dentro de las Audiencias de la persona una situacion no compatible.
		$aud = $this->Audiencia->query(" SELECT Audiencia.id FROM citaciones as Citacion
													JOIN audiencias AS Audiencia ON ( Citacion.audiencia_id = Audiencia.id)
													WHERE (
															Citacion.persona_id = '{$persona_id}' AND
															((
															Audiencia.hora_ini > '{$audiencia['hora_ini']}'
																AND
															Audiencia.hora_ini < '{$audiencia['hora_fin']}'
															) OR (
															Audiencia.hora_fin > '{$audiencia['hora_ini']}'
																AND 
															Audiencia.hora_fin < '{$audiencia['hora_fin']}'
															))
														)
												");
		// Si encontre una Audiencia que coincide con el horario de la audiencia retorno false.
		if($aud){ return false;}					

		// Si no encontre coincidencia de horarios retorno true. - La operacion registro de la Audiencia es posible.
		return true;
	}
	
	private function chequearMargenHorario($persona_id = false, $audiencia = false){
		
		// Check if user has logged.
		$user = $this->UserSession->get();
		
		// Check permissions.
		if (!in_array( $user['Usuario']['type'],array($this->permissions['sys_admin'],$this->permissions['administrativo']))){
			$this->Session->setFlash($this->msg_errors['permissions'], 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect($this->redirections['no_permissions']);exit;
		}
		
		// Situation of scape
		if(!$persona_id || !$audiencia || !Validation::uuid($persona_id)){
			$this->Session->setFlash($this->msg_errors['uuid'], 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect($this->redirections['security']);exit;			
		}

		$audiencia_id = $this->Ocupacion->query(" SELECT Audiencia.id FROM citaciones AS Citacion
													JOIN audiencias AS Audiencia ON ( Citacion.audiencia_id = Audiencia.id)
													WHERE (
															Citacion.persona_id = '{$persona_id}' AND
															((
															 Audiencia.hora_hasta <= '{$audiencia['hora_ini']}'
																AND
															 (TIMESTAMPDIFF(MINUTE,Audiencia.hora_hasta,'{$audiencia['hora_ini']}') < 10)
															)OR(
															 '{$audiencia['hora_fin']}' <= Audiencia.hora_desde
																AND
															 (TIMESTAMPDIFF(MINUTE,'{$audiencia['hora_fin']}',Audiencia.hora_desde) < 10)
															))										
														)
												");												
		return $audiencia_id;
	}
	
}
?>
