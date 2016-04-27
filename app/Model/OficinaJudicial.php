<?php

class OficinaJudicial extends AppModel {
	var $name='OficinaJudicial';

	public $useTable = 'oficinas_judiciales'; // This model uses a database table 'oficinas_judiciales'
  
	public $hasMany = array(
		'Salas' => array(
			'className' => 'Sala',
			'foreignKey' => 'oficina_id',
			'dependent' => true
		)
    );
    
}

?>
