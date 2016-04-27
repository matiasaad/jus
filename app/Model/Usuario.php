<?php

App::import('Validation');

class Usuario extends AppModel {
	var $name='Usuario';
	
	public $useTable = 'usuarios'; // This model uses a database table 'usuarios'

	var $types = array('admin'=>1000, 'adinistrativo'=>10);

}

?>
