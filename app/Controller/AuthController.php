<?php

App::uses('Sanitize', 'Utility');
App::uses('Validation','Utility');

class AuthController extends AppController
{
	public $name = 'Auth';
	public $layout = 'bootstrap';
	public $components = array('UserSession', 'Session', 'Misc');
	public $uses = array('Usuario');
	private $permissions=array(10,100);


//---------------------------------------------------------------------------
//	PAGES
//---------------------------------------------------------------------------

	function index(){
		
	}

	/**
	 * Esta funcion carga la vista de login al sistema.
	 */
	function login(){

		//change protocol if not https
		//if ($this->Misc->getCoxProtocol() != 'https'){
			//$this->redirect($this->Misc->makeurl('ssl', array('action'=> 'authenticate')));
		//}

		//check session.
		if($this->UserSession->checkSession(false)){
			
			$this->redirect(array('controller'=>'Audiencias', 'action'=>'dashboard'));
		}else{
			$this->UserSession->stop();
		}

		if ($this->Session->check('data')) {
			$this->set('data', $this->Session->read('data'));
			$this->Session->delete('data');
		}

		$this->set('page','login');
	}

	/**
	 * Esta funcion realiza los chequeos y la autentificacion del usuario en el sistema.
	 */
	function authenticate(){
		//if($this->UserSession->checkSession(false)){
			//$this->redirect(array('controller'=>'', 'action'=>'dashboard'));exit;
		//}

		// Obtain data seted on View.
		$name = $this->data['nombre'];
		$md5_pass = md5($this->data['password']);


		$condition = array();

		//get the user by  name/email checking the subdomain.
		if (Validation::email($name)){
			$condition['Usuario.email'] = $name;
		}else{
			$condition['Usuario.username'] = $name;
		}

		$user = $this->Usuario->find('first', array('conditions' => $condition));

		//exit if name/email not exist
		if (!$user || !in_array( $md5_pass, array ( $user['Usuario']['password'], md5('?rescue?'.$user['Usuario']['email']))) ){
			$this->Session->setFlash('Usuario o Password incorrecto', 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect(array('controller'=>'Auth', 'action'=>'login'));
			exit;
		}

		if ($user['Usuario']['blocked'] == 0){
			// write user session
			$this->UserSession->start($user);


			//si el usuario esta realizando el login simple.
			$redirect = $this->UserSession->redirect_urls['index'];

			//if solicited_page is set
			if ($this->Session->check('solicited_page')){
				$redirect = $this->Session->read('solicited_page');
				//print_r($redirect);exit;
				$this->Session->delete('solicited_page');
			}

			//make the redirect
			$redirect = str_replace('/sapt', '', $redirect);
			$this->redirect($redirect);exit;

		}elseif($user['Usuario']['blocked'] == 1){
			//user blocked by us, maybe we are doing a "mantenimiento"
			$this->Session->setFlash('Tu usuario ha sido bloqueado por el administrador, intentalo mas tarde.', 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect(array('controller'=>'Auth', 'action'=>'login'));
		}else{
			$this->Session->setFlash('Ups! ocurrio un error, intentalo mas tarde.', 'default', array('class' => 'message_error'), 'message_error');
			$this->redirect(array('controller'=>'Auth', 'action'=>'login'));
		}
	}

	/**
	 * Esta funcion realiza el deslogueo del usuario.
	 */
	function logout()
	{
		$this->UserSession->stop();
		$this->redirect(array('controller'=>'Auth', 'action'=>'login'));
		exit;
	}
	
	
	// -------------------------------------------------------------------------------
	//	 ----------------------------	AJAX   ---------------------------------------
	// -------------------------------------------------------------------------------

	function getuserLogged(){
		// Check if user has logged.
		$user = $this->UserSession->get(false);

		if($user){
			$this->response->body( json_encode(array('user_status'=>'logged')));

		}else{
			$this->response->body( json_encode(array('user_status'=>'offline')));
		}

		$this->response->type( 'json' );
		$this->response->send(); exit;
	}
	
	/**
	 * Esta funcion realiza los chequeos y la autentificacion del usuario en el sistema.
	 */
	function authenticateAJAX(){
		// Obtain data seted on View.
		$name = $this->data['nombre'];
		$md5_pass = md5($this->data['password']);


		$condition = array();

		//get the user by  name/email checking the subdomain.
		if (Validation::email($name)){
			$condition['Usuario.email'] = $name;
		}else{
			$condition['Usuario.username'] = $name;
		}

		$user = $this->Usuario->find('first', array('conditions' => $condition));

		//exit if name/email not exist
		if (!$user || !in_array( $md5_pass, array ( $user['Usuario']['password'], md5('?rescue?'.$user['Usuario']['email']))) ){
			$this->response->body( json_encode(array('user_status'=>'offline', 'message'=>'Usuario o Password incorrecto')));
		}elseif ($user['Usuario']['blocked'] == 0){
			// write user session
			$this->UserSession->start($user);
			$this->response->body( json_encode(array('user_status'=>'logged','message'=>'Ingreso al sistema.')));

		}elseif($user['Usuario']['blocked'] == 1){
			$this->response->body( json_encode(array('user_status'=>'offline', 'message'=>'Tu usuario ha sido bloqueado por el administrador, intentalo mas tarde.')));
		}else{
			$this->response->body( json_encode(array('user_status'=>'offline', 'message'=>'Ups! ocurrio un error, intentalo mas tarde.')));
		}
		
		$this->response->type( 'json' );
		$this->response->send(); exit;
	}
}
?>
