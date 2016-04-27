<?php
class MiscComponent extends Component{
	var $controller = null;
	var $components = array('Session');

	public function initialize(Controller $controller) {
		$this->controller =&$controller;
	}

	/**
	 ** ******************** FUNCIONES PARA VISTAS **********************
	 **/


	/**
	 *  ------------------ NUMBER FORMAT ---------------
	 **/

	
	function floattostr($number){
		return number_format($number,2,',','.');

	}

	function strtofloat($number){
		$res = str_replace(',','.', $number);
		return number_format($res,2);
	}

	/**
	 **  ------------------ DATE FORMAT ----------------
	 **/ 
	function dateFormatToMYSQL($date)
	{
		if($date == ''){
			return "";
		}else{
			$fecha = date_create_from_format('d/m/Y', $date);
			if(!$fecha){
				return $date;
			}
			return date_format($fecha,'Y-m-d');
		}
	}
	
	function dateFormatfromMYSQL($date)
	{
		if($date == ''){
			return "";
		}else{
			$fecha = date_create_from_format('Y-m-d', $date);
			if(!$fecha){
				return $date;
			}
			return date_format($fecha,'d/m/Y');
		}
	}
	
	function datetimeFormatToMYSQL($date)
	{
		if($date == ''){
			return "";
		}else{
			$fecha = date_create_from_format('d/m/Y H:i:s', $date);
			if(!$fecha){
				return $date;
			}
			return date_format($fecha,'Y-m-d H:i:s');
		}
	}
	
	
	function datetimeFormatfromMYSQL($datetime)
	{
		if($date == ''){
			return "";
		}else{
			$fecha = date_create_from_format('Y-m-d H:i:s', $datetime);
			if(!$fecha){
				return $date;
			}
			return date_format($fecha,'d/m/Y H:i:s');
		}
	}
	
	function cleanData(&$str) {
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}
	
	
	/****************************************************************
	 ******************************* SSL ****************************
	 ****************************************************************/
	public function makeurl($type, $url)
	{
		$current_scheme = $this->getCoxProtocol();
		$full_url= Router::url($url, true);

		switch($type){
			case 'ssl':
				if($current_scheme != 'https'){
					$full_url = str_replace('http://', 'https://', $full_url);
				}
			break;

			case 'nossl':
				if($current_scheme != 'http'){
					$full_url = str_replace('https://', 'http://', $full_url);
				}
			break;
		}
		return $full_url;
	}

	public function getCoxProtocol() {
		$scheme = 'http';
		if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
			$scheme .= 's';
		}
		return $scheme;
	}

	public function getDomain ()
	{
		$domain='';
		$server_name =explode('.', str_replace("www.", "",strtolower($_SERVER['SERVER_NAME'])));
		if (count($server_name) > 2) {
			unset ($server_name[count($server_name)-1]);
			unset ($server_name[count($server_name)-1]);
			$domain =join('.', $server_name);
		}
		return $domain;
	}
	

}
?>
