<?php
    App::uses('AppHelper', 'View/Helper');
	App::import('Router');
        
	class MiscHelper extends AppHelper
	{
		var $helpers = array('Html');

		public function initialize(Controller $controller) {
		}

		function drawPopup($div_id=false,$link=false,$msg=false)
		{
		
			if($div_id && $link && $msg){
				echo '<div id="'.$div_id.'-message-popup" class="box-popup">
						<div>
							<h3>Atencion!.</h3>
							<p id="'.$div_id.'-msg-popup" >'.$msg.'</p>
							<a href="'.$link.'" id='.$div_id.'"button-popup-ok" class="btn btn-primary">Confirmar</a>
							<a href="#" id="'.$div_id.'button-popup-cancel" class="btn btn-danger">Cancelar</a>
						</div>
					 </div>';

				echo '<script language="javascript">
						 $("#'.$div_id.'button-popup-ok").on("click",function(){
							$("#'.$div_id.'-message-popup").addClass("box-popup-open");
						 });
					
						 $("#'.$div_id.'button-popup-cancel").on("click",function(){
							$("#'.$div_id.'-message-popup").removeClass("box-popup-open");
						 });
					  </script>';
			}
		}

		function drawPopupGeneric($div_id=false,$msg=false)
		{
			if($div_id && $msg){
				echo '<div id="'.$div_id.'-message-popup" class="box-popup">
						<div>
							<h3>Atencion!.</h3>
							<p id='.$div_id.'msg-popup" >'.$msg.'</p>
							<a href="#" id="button-popup-ok" class="btn btn-primary">Confirmar</a>
							<a href="#" id="button-popup-cancel" class="btn btn-danger">Cancelar</a>
						</div>
					 </div>';

				echo '<script language="javascript">
						 $("#button-popup-ok").on("click",function(){
							$("#'.$div_id.'-message-popup").removeClass("box-popup-open");
						 });
					
						 $("#button-popup-cancel").on("click",function(){
							$("#'.$div_id.'-message-popup").removeClass("box-popup-open");
						 });
					  </script>';
			}
		}

		function drawPopupJS($div_id=false,$msg=false)
		{
			if($div_id && $msg){
				echo '<div id="'.$div_id.'-message-popup" class="box-popup">
						<div>
							<h3>Atencion!.</h3>
							<p id="msg-popup" >'.$msg.'</p>
							<a href="#" id="button-popup-ok-'.$div_id.'" class="btn btn-primary">Confirmar</a>
							<a href="#" id="button-popup-cancel-'.$div_id.'" class="btn btn-danger">Cancelar</a>
						</div>
					 </div>';

				echo '<script language="javascript">
						 $("#button-popup-ok-'.$div_id.'").on("click",function(){
							$("#'.$div_id.'-message-popup").removeClass("box-popup-open");
							return true;
						 });
					
						 $("#button-popup-cancel-'.$div_id.'").on("click",function(){
							$("#'.$div_id.'-message-popup").removeClass("box-popup-open");
							return false;
						 });
					  </script>';
			}
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


	}


?>
