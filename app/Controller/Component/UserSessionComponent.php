<?php
App::import('Model', 'Usuario');


class UserSessionComponent extends Component{
		var $controller = null;
		var $Usuario = null;
		var $Movimiento = null;
		var $components = array('Session');

		var $redirect_urls = array(
			'index' => array('controller' => 'Audiencias', 'action' => 'dashboard'),
			'login' => array('controller' => 'Auth', 'action' => 'login')
		);

		var $session_messages = array (
			'expired' => 'Tu sesion ha expirado, por favor ingrese nuevamente.',
			'blocked' => 'Tu usuario ha sido bloqueado por el administrador, intentalo mas tarde.',
		);

		public function initialize(Controller $controller) {
			$this->controller =&$controller;
			$this->Usuario = new Usuario();
		}

		function checkSession($redirect=true){
			if (!$this->Session->check('User')){
				return $this->sessionError('expired', $redirect);
			}

			$user = $this->Session->read('User');


			$logged_user = $this->Usuario->find('first', array('conditions' => array('Usuario.id'=>$user['Usuario']['id'])));

			if($logged_user['Usuario']['blocked'] == 1) {
				return $this->sessionError('blocked', $redirect);
			}

			return true;
		}

		function sessionError ($type, $redirect) {

			if (in_array($type, array('expired'))){

				if ($redirect) {
					//set error message
					$this->Session->setFlash($this->session_messages[$type], 'default', array('class' => 'message_error'), 'message_error');

					//se guarda la url donde se redirigira luego de logear.
					$this->Session->write('solicited_page', str_replace('url=', '/', $_SERVER['REQUEST_URI'] ));
//print_r($_SERVER['REQUEST_URI']);exit;
					$this->controller->redirect($this->redirect_urls['login']); exit;
				}
				return false;
			}

			if ($type == 'blocked' && !in_array(strtolower(str_replace('url=', '/', $_SERVER['REQUEST_URI'])), $this->redirect_urls )) {

				if ($redirect) {
					//set error message
					$this->Session->setFlash($this->session_messages[$type], 'default', array('class' => 'message_error'), 'message_error');

					$this->controller->redirect($this->redirect_urls['dashboard']); exit();
				}

				return true;
			}

			return true;
		}



		function userLogued(){
			return $this->Session->check('User');
		}

		function reload()
		{
			$user =  $this->get();

			$user_mod = $this->Usuario->find('first', array('conditions' => array('Usuario.id'=>$user['Usuario']['id'])));
		
			$this->start($user_mod);
			return($user_mod);
		}

		function get($redirect = true)
		{
			if(!$this->checkSession($redirect)){
				return false;
			}
			return $this->Session->read('User');
		}

		function start($user){
			return $this->Session->write('User', $user);
		}

		function stop(){
			$this->Session->delete('User');
		}

}
?>
