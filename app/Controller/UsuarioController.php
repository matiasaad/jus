<?php

App::uses('Sanitize', 'Utility');
App::uses('Validation','Utility');

class UsuarioController extends AppController
{
	public $name = 'Usuario';
	public $layout = 'bootstrap';
	public $components = array('UserSession', 'Session', 'Misc');
	public $uses = array('Usuario');

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

// -------------------------------------------------------------------------------------------------------------
// 												User Administration 
// -------------------------------------------------------------------------------------------------------------
	/**
	 * Esta funcion es la encargada cargar la vista donde se muestran los distintos usuarios.
	 * debe tener privilegios de Administrador del sistema para poder acceder.	 
	 */
	function adminUsuarios(){
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		}

		$this->Usuario->unBindModel(array('hasMany'=>array('Movimientos')));
		$users = $this->Usuario->find('all',array('conditions'=>array('NOT'=>array('Usuario.id'=>$user['Usuario']['id'], 'Usuario.type'=>2))));

		$this->set('flexibleMode', $this->Misc->flexibleMode());
		$this->set('permissions',$this->permissions_inverso);
		$this->set('users', $users);
		$this->set('user', $user);
	}

	/**
	 * Esta funcion es la encargada cargar la vista de dashboard para los usuarios del sistema.
	 * El usuario debe estar logueado en el sistema.
	 */
	function dashboard(){
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		}
	
		$this->set('user', $user);
	}

	function systemChargeMode($mode = false){
		// Check if user has logged.
		$user = $this->UserSession->get();

		if(!$mode){$this->redirect(array('controller'=>'Usuario', 'action'=>'adminUsuarios'));exit;}
		
		if($mode == 'strict'){
			$this->Misc->setFlexibleMode(false);
		}else{
			$this->Misc->setFlexibleMode(true);
		}
		
		$this->redirect(array('controller'=>'Usuario', 'action'=>'adminUsuarios'));exit;
	}

	/**
	 * Esta funcion permite agregar un usuario en el sistema y brindarle los permisos necesarios de acceso.
	 * debe tener privilegios de Administrador del sistema para poder acceder.
	 */	
	function addUser()
	{
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		}

		// Set default values.
		$values = $default_values = array('Usuario' =>array('nombre'=> '', 'apellido'=>'', 'email'=> '', 'password'=> ''));
		
		// Get errors from save user.
		if($this->Session->check('usuario_errors')){
			$this->Usuario->validationErrors = $this->Session->read('usuario_errors');
			$this->Session->delete('usuario_errors');
		}

		//merge inserted data with defaults to show on form
		if($this->Session->check('data')){
			$values = $this->Session->read('data');
			$values['Usuario'] = array_merge($default_values['Usuario'], $values['Usuario']);

			$this->Session->delete('data');
		}

		$this->set('permissions',$this->permissions_inverso);
		$this->set('data', $values);
		$this->set('user', $user);

		// TODO: Ver este campo en Layout, debe marcar como seleccionado el dashboard del usuario
		$this->set('page','registro');	
	}

	/**
	 * Esta funcion permite edit un usuario del sistema, como tambien los permisos del mismo.
	 * debe tener privilegios de Administrador del sistema para poder acceder.
	 */	
	function editUser($user_id = null)
	{
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'general_error'), 'general_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		}

		// Obtain the user to edit.
		$user_a = $this->Usuario->find('first', array('conditions'=>array('Usuario.id'=>$user_id)));
		
		if(!$user_a){
			$this->Session->setFlash('No se encontro el usuario que se desea editar.', 'default', array('class' => 'general_error'), 'general_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'dashboard'));exit;
		}

		// Set default values.
		$values = $default_values = array('Usuario' =>array('nombre'=> '', 'apellido'=>'', 'email'=> '', 'password'=> ''));

		// Get errors from save user.
		if($this->Session->check('usuario_errors')){
			$this->Usuario->validationErrors = $this->Session->read('usuario_errors');
			$this->Session->delete('usuario_errors');
		}

		//merge inserted data with defaults to show on form.
		if($this->Session->check('data')){
			$values = $this->Session->read('data');
			$values['Usuario'] = array_merge($default_values['Usuario'], $values['Usuario']);

			$this->Session->delete('data');
		}

		// Set variable to function view.
		$this->set('permissions',$this->permissions_inverso);
		$this->set('data', $values);
		$this->set('user', $user);
		$this->set('user_a', $user_a);

		// TODO: Ver este campo en Layout, debe marcar como seleccionado el dashboard del usuario
		$this->set('page','registro');	
	}


	/**
	 * Esta funcion guarda el nuevo usuario en el sistema.
	 * debe tener privilegios de Administrador del sistema para poder acceder.
	 */	
	function save_user()
	{
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'general_error'), 'general_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		}
		
		// Obtain data seted on View.
		$data = $this->data;
		
		// Set default timezone to Buenos Aires.
		date_default_timezone_set('America/Buenos_Aires');

		$datetime = date('Y-m-d H:i:s');

		// Set data received from view.
		$usuario['Usuario'] = $data['Usuario'];

		// Set another user fields.

		$usuario['Usuario']['blocked'] = 0;
		$usuario['Usuario']['created'] = $datetime;
		
		
		
		// Pass user to model for save.
		if(!$this->Usuario->add($usuario)){
			$this->Session->write('usuario_errors', $this->Usuario->validationErrors);
			$this->Session->write('data', $this->data);

			// In case of error, redirect to addUser
			$this->redirect(array('controller'=>'Usuario' ,'action'=>'addUser'));exit;
		}

		// In case of success, redirect to dashboard
		$this->redirect(array('controller'=>'Usuario', 'action'=>'adminUsuarios'));exit;
	}

	/**
	 * Esta funcion guarda los datos de un usuario en el caso de la edicion del mismo.
	 * Puede ser llamada desde la cuenta del usuario o desde la edicion del usuario en modo Administrador
	 */	
	function UptateUser($user_id = false)
	{
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'general_error'), 'general_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		}
		
		$this->Usuario->unBindModel(array('hasMany'=>array('Movimientos')));
		$user_a = $this->Usuario->find('first', array('conditions'=>array('Usuario.id' => $user_id)));


		$data = $this->data;


		if(isset($this->data['Usuario']['email']) && !empty($this->data['Usuario']['email'])){
			//what to validate
			$field = 'email';
			$validate = array('fieldList' => array('email'));
		}elseif(isset($this->data['Usuario']['password']) && !empty($this->data['Usuario']['password'])){
			$data['Usuario']['password'] = md5($this->data['Usuario']['password']);
			$data['Usuario']['pass_confirm'] = md5($this->data['Usuario']['pass_confirm']);

			//what to validate
			$field = 'password';
			$validate = array('fieldList' => array('password'));
		}elseif (isset($this->data['Usuario']['type']) && !empty($this->data['Usuario']['type'])){
			//what to validate
			$field = 'type';
			$validate = array('fieldList' => array('type'));
		}else{
			// Set message
			$this->Session->setFlash('Ocurrio un error el intentar guardar los datos del usuario '.$user_a['Usuario']['username'].'.', 'default', array('class' => 'general_error'), 'general_message');
			
			// then redirect
			$this->redirect(array('controller'=>'Usuario', 'action'=>'adminUsuarios'));exit;			
		}

		//validate
		$this->Usuario->set($data); // this set its only for validate.
		if(!$this->Usuario->validates($validate) ) // now validate data
		{
			$this->Session->write('usuario_errors', $this->Usuario->validationErrors);
			$this->redirect(array('action'=>$redirect_to));exit;
		}
		$this->Usuario->set(null); // unset data

		$user_a['Usuario'][$field] = $data['Usuario'][$field];
//print_r($user_a);exit;
		$this->Usuario->save($user_a, false);
		$this->redirect(array('controller'=>'Usuario', 'action'=>'editUser', $user_id));exit;
	}
	
	
	/**
	 * Esta funcion permite bloquear un usuario.
	 * debe tener privilegios de Administrador del sistema para poder llamarla	 
	 */
	function blockUser($user_id, $from = false)
	{
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'general_error'), 'general_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		}

		$this->Usuario->updateAll(
			array('Usuario.blocked'=>true),
			array('Usuario.id'=>$user_id)
		);

		if($from == 'from_inside'){
			$this->redirect(array('controller'=>'Usuario', 'action'=>'editUser', $user_id));exit;
		}
		$this->redirect(array('controller'=>'Usuario', 'action'=>'adminUsuarios'));exit;
	}
	
	/**
	 * Esta funcion permite desbloquear un usuario bloqueado anteriormente.
	 * debe tener privilegios de Administrador del sistema para poder llamarla.
	 */
	function unblockUser($user_id, $from = false)
	{
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'general_error'), 'general_error');
			$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		}
		
		$this->Usuario->updateAll(
			array('Usuario.blocked'=>false),
			array('Usuario.id'=>$user_id)
		);

		if($from == 'from_inside'){
			$this->redirect(array('controller'=>'Usuario', 'action'=>'editUser', $user_id));exit;
		}		
		$this->redirect(array('controller'=>'Usuario', 'action'=>'adminUsuarios'));exit;
	}

/*
	function check_username(){
		$username = $_POST['data'][0];

		$user = $this->Usuario->find('first',array('conditions'=>array('Usuario.username'=>$username)));
		if($user){
			exit('fail');
		}else{
			exit('ok');
		}
	}
*/	


// -------------------------------------------------------------------------------------------------------------
//													User Account 
// -------------------------------------------------------------------------------------------------------------
	/**
	 * Redireccion al dashboard.
	 */
	function index ()
	{
		$this->redirect(array('controller'=>'Usuario', 'action'=>'cuenta'));
	}

	/**
	 * Esta funcion carga la vista de la cuenta del usuario. Donde se le permitira al usuario
	 * realizar cambios sobre sus datos personales y/o passwords
	 */
	function cuenta ($field = false)
	{
		//Chequeo de la sesion y obtengo el usuario en caso de que este logeado.
		$user = $this->UserSession->reload();

		//get errors from save user.
		if($this->Session->check('localidad_errors')){
			$this->Localidad->validationErrors = $this->Session->read('localidad_errors');
			$this->Session->delete('localidad_errors');
		}

		//get errors from save user.
		if($this->Session->check('usuario_errors')){
			$this->Usuario->validationErrors = $this->Session->read('usuario_errors');
			$this->Session->delete('usuario_errors');
		}

		if(isset($field)){
			$this->set('field',$field);
		}

		$this->set('user',$user);
		$this->set('page','cuenta');
	}


	/**
	 * Esta funcion guarda los datos de un usuario en el caso de la edicion del mismo.
	 * Puede ser llamada desde la cuenta del usuario o desde la edicion del usuario en modo Administrador
	 */	
	function editUserAccount($field)
	{
		// Check if user has logged.
		$user = $this->UserSession->get();

		// Check permitions.
		//if (!in_array($user['Usuario']['type'], array($this->permissions['admin'])) ){
			//$this->Session->setFlash('Usted no tiene permiso para acceder a esta pagina.', 'default', array('class' => 'general_error'), 'general_error');
			//$this->redirect(array('controller'=>'Usuario', 'action'=>'index'));
		//}

		// find the user.
		$this->Usuario->unBindModel(array('hasMany'=>array('Movimientos')));
		$user_a = $this->Usuario->find('first', array('conditions'=>array('Usuario.id' => $user['Usuario']['id'])));


		// Obtain data.
		$data = $this->data;

		// What to validate.
		switch ($field){
			case 'email': $validate = array('fieldList' => array('email')); break;
			case 'password': $validate = array('fieldList' => array('password')); break;
		}

		if(isset($this->data['Usuario']['password']) && !empty($this->data['Usuario']['password'])){
			$data['Usuario']['password'] = md5($this->data['Usuario']['password']);
			$data['Usuario']['pass_confirm'] = md5($this->data['Usuario']['pass_confirm']);
		}

		// Validate.
		$this->Usuario->set($data); // this set its only for validate.
		if(!$this->Usuario->validates($validate) ) // now validate data
		{
			$this->Session->write('usuario_errors', $this->Usuario->validationErrors);
			$this->redirect(array('controller'=>'Usuario', 'action'=>'cuenta', $field));exit;
		}
		$this->Usuario->set(null); // unset data

		$user_a['Usuario'][$field] = $data['Usuario'][$field];

		$this->Usuario->save($user_a, false);
		$this->redirect(array('controller'=>'Usuario', 'action'=>'cuenta'));exit;
	}

}
?>
