<?php echo $this->Html->css(array('styles_added_bootstrap.css','jquery-ui/jquery-ui.css'));?>
<?php echo $this->Html->script(array('jquery-2.1.1.min.js','jquery-ui/jquery-ui.js'));?>  

<div class="row container">
	<div class="row">
		<?php echo $this->Session->flash('message_error');?>
		<?php echo $this->Session->flash('message_info');?>
	</div>
	<!-- BOX AUDIENCIAS -->
	<div class="col-md-5 box-default">
		<h3>Nueva Audiencia </h3>
		<h3><small>Para comenzar ingrese el expediente y luego reserve la sala y el horario haciendo click en el boton</small></h3>
			<?php echo $this->Form->create(null, array('url' => array('controller' => 'Audiencias', 'action' => 'saveAudiencia'))); ?>
				<input type="hidden" id="sala_in" name="data[Audiencia][sala_id]" value="<?php if(isset($data['Audiencia']['sala_id'])){ echo $data['Audiencia']['sala_id']; }?>">
				<input type="hidden" id="fecha_in" name="data[Audiencia][fecha]" value="<?php if(isset($data['Audiencia']['fecha'])){ echo $data['Audiencia']['fecha']; }?>">
				<input type="hidden" id="hora_ini_in" name="data[Audiencia][hora_ini]" value="<?php if(isset($data['Audiencia']['hora_ini'])){ echo $data['Audiencia']['hora_ini']; }?>">
				<input type="hidden" id="hora_fin_in" name="data[Audiencia][hora_fin]" value="<?php if(isset($data['Audiencia']['hora_fin'])){ echo $data['Audiencia']['hora_fin']; }?>">			
				<input type="hidden" id="juez_in" name="data[Citacion][juez_id]" value="<?php if(isset($data['Citacion']['juez_id'])){ echo $data['Citacion']['juez_id']; }?>">
				<input type="hidden" id="defensor_in" name="data[Citacion][defensor_id]" value="<?php if(isset($data['Citacion']['defensor_id'])){ echo $data['Citacion']['defensor_id']; }?>">
				<input type="hidden" id="fiscal_in" name="data[Citacion][fiscal_id]" value="<?php if(isset($data['Citacion']['fiscal_id'])){ echo $data['Citacion']['fiscal_id']; }?>">
			<!--EXPEDIENTE -->
			<div class="row"> <!-- CONTENEDOR DE LOS INPUT DE LA AUDIENCIA -->
				<div class="col-md-12">
					<label for="expediente_in" class="control-label">Expediente:</label>
					<input type="text" style="width:200px;" id="expediente_in" name="data[Audiencia][expediente]" value="<?php if(isset($data['Audiencia']['expediente'])){ echo $data['Audiencia']['expediente']; }?>"  placeholder="Expediente">
					<?php echo $this->Form->error('Audiencia.expediente', null, array('class'=>'message_error'));?>
				</div>
			</div>
			<!--SALA Y HORARIOS -->
			<h3><small><hr></small></h3>
			<div class="row">
				<div class="col-md-12" >
					<h4><small>Click sobre el boton para seleccionar Sala, fecha y hora de la audiencia</small></h4>
					<button type="button" id="open_pop-up-salas" class="btn btn-default btn-md" data-toggle="modal" data-target="#myModal">salas y horarios
					</button>
					<br>
					<label for="sala_select">Sala:&nbsp;</label>
					<span id="sala_select"><?php if(isset($data['Audiencia']['Sala'])){
													echo "{$data['Audiencia']['Sala']['Sala']['numero']}, {$data['Audiencia']['Sala']['Sala']['descripcion']}</span><br/>";
												 }else{
													echo "No se selecciono una sala</span><br/>";
												}
											?>
					<?php echo $this->Form->error('Audiencia.sala_id', null, array('class'=>'message_error'));?>
					<label for="fecha_select">Fecha:&nbsp;</label>
					<span id="fecha_select"><?php if(isset($data['Audiencia']['fecha'])){ echo $data['Audiencia']['fecha']; }else{ echo "No se selecciono una fecha"; }?></span><br/>
					<?php echo $this->Form->error('Audiencia.fecha', null, array('class'=>'message_error'));?>
					<label for="hora_ini_select">Hora Inicio:&nbsp;</label>
					<span id="hora_ini_select"><?php if(isset($data['Audiencia']['hora_ini'])){ echo $data['Audiencia']['hora_ini']; }else{ echo "Sin hora de inicio"; }?></span><br/>
					<label for="hora_fin_select">Hora Finalización:&nbsp;</label>
					<span id="hora_fin_select"><?php if(isset($data['Audiencia']['hora_fin'])){ echo $data['Audiencia']['hora_fin']; }else{ echo "Sin hora de finalización"; }?></span><br/>
					<?php echo $this->Form->error('Audiencia.horarios', null, array('class'=>'message_error'));?>
				</div>
			</div>
			<!--Jueces, fiscales y defensores -->
			<h3><small><hr></small></h3>
			<div class="row">
				<div class="col-md-12" >
					<h4><small>Defensores seleccionados para la audiencia</small></h4>
					<br>
					<label for="juez_select">Juez:&nbsp;</label>
					<span id="juez_select"><?php if(isset($data['Citacion']['juez'])){
													echo "{$data['Citacion']['juez']['Persona']['apellido']}, {$data['Citacion']['juez']['Persona']['nombres']}</span><br/>";
												 }else{
													echo "No se selecciono Juez</span><br/>";
												}
											?>
					<?php echo $this->Form->error('Citacion.juez_id', null, array('class'=>'message_error'));?>
					<?php echo $this->Form->error('Citacion.juez_in', null, array('class'=>'message_error'));?>
					<label for="fiscal_select">Fiscal:&nbsp;</label>
					<span id="fiscal_select"><?php if(isset($data['Citacion']['fiscal'])){
													echo "{$data['Citacion']['fiscal']['Persona']['apellido']}, {$data['Citacion']['fiscal']['Persona']['nombres']}</span><br/>";
												 }else{
													echo "No se selecciono Fiscal</span><br/>";
												}
											?>
					<?php echo $this->Form->error('Citacion.fiscal_in', null, array('class'=>'message_error'));?>
					<?php echo $this->Form->error('Citacion.fiscal_id', null, array('class'=>'message_error'));?>
					<label for="defensor_select">Defensor:&nbsp;</label>
					<span id="defensor_select"><?php if(isset($data['Citacion']['defensor'])){
													echo "{$data['Citacion']['defensor']['Persona']['apellido']}, {$data['Citacion']['defensor']['Persona']['nombres']}</span><br/>";
												 }else{
													echo "No se selecciono Defensor</span><br/>";
												}
											?>
					<?php echo $this->Form->error('Citacion.defensor_in', null, array('class'=>'message_error'));?>
					<?php echo $this->Form->error('Citacion.defensor_id', null, array('class'=>'message_error'));?>

				</div>
			</div>
	</div>
	<!-- BOX JUECES -->
	<div class="col-md-3 box-dashed "> <!-- box Jueces-->
		<div class="row">
  			<div class="col-md-12 ">
				<div class="modal-header">
				  <h3 class="modal-title">Jueces</h3>
				</div>  
			</div>
		</div>
		<div class="row box-select" >
   			<div class="col-md-12">
				<?php foreach($personas['jueces'] as $juez){?>
					<button class="btn btn-default button-juez" type="button"
					rel="<?php echo $juez['Persona']['id']."|".$juez['Persona']['apellido'].", ".$juez['Persona']['nombres'];?>" <?php if(isset($data['Citacion']['juez_id']) && ($data['Citacion']['juez_id'] == $juez['Persona']['id'])){ echo 'style="background-color: rgb(229, 229, 229);"'; }?>>
						<span class="juez-select">
								<?php echo $juez['Persona']['apellido'].", ".$juez['Persona']['nombres'];?>
						</span>
					</button>

					<span data-toggle="modal" data-target="#myModalPersonas" class="glyphicon glyphicon-calendar modal-calendar" rel="<?php echo $juez['Persona']['id'];?>" aria-hidden="true"></span>
					
				<?php }?>
			</div>
        </div>
	</div>
	<!-- BOX FISCALES -->
	<div class="col-md-3 box-dashed">
		<div class="modal-header">
          <h3 class="modal-title">Fiscales</h3>
        </div>
		<div class="row box-select" >
  			<div class="col-md-12">
				<?php foreach($personas['fiscales'] as $fiscal){?>
					<button class="btn btn-default button-fiscal" type="button"
					rel="<?php echo $fiscal['Persona']['id']."|".$fiscal['Persona']['apellido'].", ".$fiscal['Persona']['nombres'];?>" <?php if(isset($data['Citacion']['fiscal_id']) && ($data['Citacion']['fiscal_id'] == $fiscal['Persona']['id'])){ echo 'style="background-color: rgb(229, 229, 229);"'; }?> >
						<span class="fiscal-select">
								<?php echo $fiscal['Persona']['apellido'].", ".$fiscal['Persona']['nombres'];?>
						</span>
					</button>
					<span data-toggle="modal" data-target="#myModalPersonas" class="glyphicon glyphicon-calendar modal-calendar" rel="<?php echo $fiscal['Persona']['id'];?>" aria-hidden="true"></span>
				<?php }?>
			</div>

        </div>
	</div>
	<!-- BOX FISCALES -->
	<div class="col-md-3 box-dashed">
		<div class="modal-header">
          <h3 class="modal-title">Defensores</h3>
        </div>
		<div class="row box-select" >
   			<div class="col-md-12">
				<?php foreach($personas['defensores'] as $defensor){?>
					<button class="btn btn-default button-defensor" type="button" 
						rel="<?php echo $defensor['Persona']['id']."|".$defensor['Persona']['apellido'].", ".$defensor['Persona']['nombres'];?>"
						<?php if(isset($data['Citacion']['defensor_id']) && ($data['Citacion']['defensor_id'] == $defensor['Persona']['id'])){ echo 'style="background-color: rgb(229, 229, 229);"'; }?> >
						<span class="defensor-select">
								<?php echo $defensor['Persona']['apellido'].", ".$defensor['Persona']['nombres'];?>
						</span>
					</button>
					<span data-toggle="modal" data-target="#myModalPersonas" class="glyphicon glyphicon-calendar modal-calendar" rel="<?php echo $defensor['Persona']['id'];?>" aria-hidden="true"></span>
				<?php }?>
			</div>
        </div>
	</div>
			<div class="row">
				<div class="col-md-12">
					<div class="pull-right">
						<input class="btn btn-primary" id="submit_sol_oit" type="submit" value="Guardar" >  &nbsp; 
						<input class="btn btn-default"  id="close-sol_oit-box" type="reset" value="Cancelar" >
					</div>				
				</div>
			</div>

		</form>
</div> <!-- row container -->
	<!------------------------------------------------------------------------------------------------------------->
	<!------------------------------------------- POPUP ENVIROMENT ------------------------------------------------>
	<!------------------------------------------------------------------------------------------------------------->

  <!-- 
		##########################################
		###### PERSONS SCHEDULES TABLE MODAL #####
		##########################################
  -->
  <div class="modal fade" id="myModalPersonas" rel="" role="dialog">
		<div class="modal-dialog sm-modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content" >
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Horarios de  - <span id="tabla_horarios_persona"></span></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div id="in_fecha_personas"></div>				
					</div>
					<div class="col-md-4">
						<div class="table-responsive">
						  <table class="table table-striped table-bordered table-hover table-condensed table-fixed header-fixed " style="text-align: center;">
							<thead>
								<tr>
									<th>Horarios</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>
								
								<?php 
									$fila =10;
									foreach($horarios_personas as $hora){
								?>
									<tr> 
										<td><?php echo $hora['hora']; ?></td>
										<?php
											echo "<td class='persona_fraction_hour' id='persona_{$fila}' ref='{$hora['unix']}'> --- </td>";
										?>
									</tr>
								<?php 	
										$fila++;
									}
								?>
							</tbody>
						  </table>
						</div>				
					</div>
				</div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		  </div>
		  
		</div>
  </div>

  <!-- 
		##########################################
		####### ROMS SCHEDULE TABLE MODAL ########
		##########################################
  -->

  <div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog md-modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content" >
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Reserva de Sala y horarios - <span id="fecha_seleccionada"><?php echo $this->Misc->dateFormatfromMYSQL(date('Y-m-d'));?></span></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3">
						<div id="in_fecha"></div>				
					</div>
					<div class="col-md-9">
						<div class="table-responsive">
						  <table class="table table-striped table-bordered table-hover table-condensed table-fixed header-fixed " style="text-align: center;">
							<thead>
								<tr>
									<th>Horarios</th>
									<?php foreach($salas as $sala){
										echo "<th>Sala {$sala['Sala']['numero']} - {$sala['Sala']['descripcion']}</th>";
									}?>
								</tr>
							</thead>
							<tbody>
								
								<?php 
									$fila =10;
									foreach($horarios_salas as $hora){
								?>
									<tr> 
										<td><?php echo $hora['hora']; ?></td>
										<?php
											$columna = 0;
											foreach($salas as $sala){
												echo "<td class='fraction_hour' id='cell".$fila."_".$columna."' ref='".$hora['unix']."|".$sala['Sala']['id']."'> --- </td>";
												$columna++;
											}
										?>
									</tr>
								<?php 	
										$fila++;
									}
								?>
							</tbody>
						  </table>
						</div>				
					</div>
				</div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		  </div>
		  
		</div>
  </div>


	<!------------------------------------------------------------------------------------------------------------->
	<!-------------------------------------------- JS ENVIROMENT -------------------------------------------------->
	<!------------------------------------------------------------------------------------------------------------->

<script language='javascript'>
	$(document).ready( function () {

		var Cell_clean_color = "rgb(255, 255, 255)";
		var Cell_clean_text = "---";
		var Cell_clean_text_color = "rgb(0, 0, 0)";
		var Seleccion_color = "rgb(229, 229, 229)";
		var Seleccion_text = "SELECCION";
		var Ocupado_color = "rgb(217, 83, 79)";
		var Ocupado_text = "OCUPADO";
		var Ocupado_text_color = "rgb(255, 255, 255)";

		// #### DATE PICKER FUNCTIONS ####
		
		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '<Ant',
			nextText: 'Sig>',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			weekHeader: 'Sm',
			dateFormat: 'yy-mm-dd',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			minDate: 0,
			yearSuffix: ''
		};
		$.datepicker.setDefaults($.datepicker.regional['es']);
		
		$("#in_fecha").datepicker({
						
				onSelect: function (date) {
					drawTable(date);
				},	
				changeMonth: true,
				changeYear: true,
				yearRange: "-10:+10"		
		});
		
		$("#in_fecha_personas").datepicker({
						
				onSelect: function (date) {
					showPersonSchedules(date);
				},	
				changeMonth: true,
				changeYear: true,
				yearRange: "-10:+10"		
		});

		// ##################################################################
		// ########################## SHOW SCHEDULES #########################
		// ##################################################################
		$(".modal-calendar").click(function(){
			var persona_id = $(this).attr("rel");
			$("#myModalPersonas").attr("rel", persona_id);

			showPersonSchedules('today');
		});

		function showPersonSchedules(date){
			// obtengo el id de la persona.
			persona_id = $("#myModalPersonas").attr("rel");
console.log(date);
console.log(persona_id);
			// HAGO EL LLAMADO POR AJAX
			$.post("<?php echo $this->Html->url(array("controller" => "Audiencias","action" => "getPersonasTimetable"));?>/"+persona_id+"/"+date, function(data, status) {
console.log("respuesta");
				console.log(data);
				
				var date_sel = new Date($("#in_fecha").datepicker( "getDate" ));
				fecha_select = $.datepicker.formatDate("dd/mm/yy", date_sel);
				$("#tabla_horarios_persona").html(fecha_select);

				//Con la respuesta llamo a la funcion correspondiente.
				completePersonGrid(data);
			}, "json");
		}

		function cleanPersonGrid(){
			//$(".persona_fraction_hour").
		}
		
		
		// Se encarga de pinta y setear el texto de todas las celdas que se encuentran ocupadas
		function completePersonGrid(data){
			// Recorro todas los horarios ocupados
			$.each(data, function( index , ocupados ) {
				// Se parsean los horarios para poder compararlos
				var hora_ini = parseInt(ocupados['hora_ini']);
				var hora_fin = parseInt(ocupados['hora_fin']);

				//recorro todas las celdas
				$(".persona_fraction_hour").each(function() {

					// Parseo y obtengo los resultados.
					var hora = $(this).attr("ref");

					//debo pintar todas las celdas que pertenezcan a un horario ocupado
					if(( hora_ini <= hora ) &&  ( hora<=hora_fin )){
						
						// Debo pintar este elemento ya que el horario que representa para esta sala se encuentra ocupado
						$( "td[ref*='"+hora+"']" ).css("background-color", Ocupado_color);
						$( "td[ref*='"+hora+"']" ).css("color", Ocupado_text_color);
						$( "td[ref*='"+hora+"']" ).html(Ocupado_text);
					}
				});	
			});
		}		
		// ##################################################################
		// ############################ RESERVAS ############################
		// ##################################################################
		var horarios_salas = <?php echo json_encode($horarios_salas); ?>;
		var salas = <?php echo json_encode($salas);?>;
		
		// Se llama a esta funcion en el comienzo de la carga
		pintar_horarios_ocupados();
		
		// Se encarga de pinta y setear el texto de todas las celdas que se encuentran ocupadas
		function pintar_horarios_ocupados(){
			
			// Creo un array asociativo para poder acceder facil a la fila que representa
			// una sala. En este arreglo voy a guardar los horarios ocupados para cada sala.
			var ocupaciones_salas = [];
			for(var i=0; i < salas.length ; i++ ){
				var sala_id = salas[i].Sala['id'];
				
				ocupaciones_salas[sala_id] = [];
				
				for(var j=0; j < salas[i].Audiencias.length ; j++){
					var audiencia = salas[i].Audiencias[j];
					
					var hora_ini = parseInt(audiencia['Audiencia']['hora_ini_ml']);
					var hora_fin = parseInt(audiencia['Audiencia']['hora_fin_ml']);
					ocupaciones_salas[sala_id][j] = {"hora_ini":hora_ini,"hora_fin":hora_fin};
				}
			}

			//recorro todas las celdas
			$(".fraction_hour").each(function() {
				
				// Parseo y obtengo los resultados.
				var ref = $(this).attr("ref");
				ref = ref.split("|");
				var sala_id = ref[1];
				var hora = parseInt(ref[0]);
				
				// Recorro todas las celdas de la tabla
				$.each(ocupaciones_salas[sala_id], function( index , ocupados ) {
					// Se parsean los horarios para poder compararlos
					hora_ini = parseInt(ocupados['hora_ini']);
					hora_fin = parseInt(ocupados['hora_fin']);

					//debo pintar todas las celdas que pertenezcan a un horario ocupado
					if(( hora_ini <= hora ) &&  ( hora<=hora_fin )){
						
						// Debo pintar este elemento ya que el horario que representa para esta sala se encuentra ocupado
						$( "td[ref*='"+hora+"|"+sala_id+"']" ).css("background-color", Ocupado_color);
						$( "td[ref*='"+hora+"|"+sala_id+"']" ).css("color", Ocupado_text_color);
						$( "td[ref*='"+hora+"|"+sala_id+"']" ).html(Ocupado_text);
					}
				});	
			});
		}


		// #### SELECCION DE HORARIOS ####
		var start_selection = null;
		var end_selection = null;
		var sala_selected = "";
		var sala_selected_id = null;
		var hora_inicio = "";
		var hora_fin = "";
		var fecha_select = "";

		// Esta funcion se encarga de setear los valores correspondientes a la
		// seleccion en los inputs y span
		function setSelectionValues(){

			var date_sel = new Date($("#in_fecha").datepicker( "getDate" ));
			fecha_eng = $.datepicker.formatDate("yy-mm-dd", date_sel);
			fecha_esp = $.datepicker.formatDate("dd/mm/yy", date_sel);
						
			// Seteo de Inputs
			$("#fecha_in").val(fecha_eng);
			$("#hora_ini_in").val(hora_inicio);
			$("#hora_fin_in").val(hora_fin);
			$("#sala_in").val(sala_selected_id);

			// Seteo de span
			$("#sala_select").html(sala_selected);
			$("#fecha_select").html(fecha_esp);
			$("#hora_ini_select").html( hora_inicio);
			$("#hora_fin_select").html(hora_fin);	
		}

		// Se encarga de pinta la celda que recibe por parametro.
		function paint_cell(cell_id){			
			$("#"+cell_id).css("background-color", Seleccion_color);
			$("#"+cell_id).html(Seleccion_text);
		}

		// Chequea si la celda pertence a un horario ocupado.
		function celdaOcupada(cell_id){
			if($(cell_id).css("background-color") == Ocupado_color){
				return true;
			}
			return false;
		}

		// Pinta las celdas correspondientes a una seleccion completa
		function pintar_seleccion(){
			if(start_selection[0] <= end_selection[0]){
				for(var i=parseInt(start_selection[0]);i<=parseInt(end_selection[0]);i++){
					
					// Chequeo si la celda pertenece a alguna seleccion.
					if(celdaOcupada("#cell"+i.toString()+"_"+start_selection[1]+"")){
						alert("Este horario se encuentra ocupado");

						// Elimino cualquier rastro de la seleccion y marco de nuevo los ocupados
						clean_selection();
						return false;
					}
					
					$("#cell"+i.toString()+"_"+start_selection[1]+"").css("background-color", Seleccion_color);
					$("#cell"+i.toString()+"_"+start_selection[1]+"").html(Seleccion_text);
				}
			}
		}
		
		// Seleccion recibe el id de la celda que se esta seleccionando y decide como proceder
		// en el caso de que se este iniciando con una nueva seleccion o terminando la misma.
		function seleccion(cell_id){
			if(!start_selection){
				comenzar_seleccion(cell_id);
			}else if(!end_selection){
				// parse cell
				cell = $("#"+cell_id).attr("id").replace("cell","").split("_");
				if(start_selection[1] == cell[1]){ // Si estan en la misma columna.
					finalizar_seleccion(cell_id);
				}else{ // selecciono dos columnas distintas.
					alert("selecciono otra columna");
					comenzar_seleccion(cell_id);
				}
			}else{ //ya habia una seleccion pero realizo otra
				comenzar_seleccion(cell_id);
			}
		}
		
		// Este funcion se encarga de limpiar todas las celdas seleccionadas y 
		// luego pinta las celdas no disponibles con la informacion almacenada en la variable salas.
		function clean_selection(){
			$(".fraction_hour").css("background-color", Cell_clean_color);
			$(".fraction_hour").css("color", Cell_clean_text_color);
			$(".fraction_hour").html(Cell_clean_text);
			pintar_horarios_ocupados();
		}
		
		// Inicia una nueva seleccion.
		function comenzar_seleccion(cell_id){

			// Chequeo si el horario ya se encuentra ocupado.
			if(celdaOcupada("#"+cell_id)){
				alert("Este horario se encuentra ocupado");
				return false;
			}
			
			end_selection = null;
			hora_fin = "";
			fecha_select = "";
			
			clean_selection();
			start_selection = $("#"+cell_id).attr("id").replace("cell","").split("_");
			
			sala_selected = salas[start_selection[1]]['Sala'].numero+" - "+salas[start_selection[1]]['Sala'].descripcion;
			sala_selected_id = salas[start_selection[1]]['Sala'].id;
			
			var position = start_selection[0]-10;
			hora_inicio = horarios_salas[position].hora;
			
			paint_cell(cell_id);
		}
		
		// Finaliza una seleccion. Se encarga luedo de pintar las celdas correspondientes a la seleccion.
		function finalizar_seleccion(cell_id){
			end_selection = $("#"+cell_id).attr("id").replace("cell","").split("_");
			
			if(start_selection[0] > end_selection[0]){
				var start_aux = start_selection;
				
				start_selection = $("#"+cell_id).attr("id").replace("cell","").split("_");
				end_selection = start_aux;

				var position = start_selection[0]-10;
				hora_inicio = horarios_salas[position].hora;
			}
			
			var position = end_selection[0]-10;
			hora_fin = horarios_salas[position].hora;

			// solicito pintar la zona seleccionada
			pintar_seleccion();
			
			setSelectionValues();
		}
		
		// ########################
		
		// ######## EVENTS ########
		$(".button-juez").on("click", function(){
				$(".button-juez").css("background-color", "#FFFFFF");
				$(this).css("background-color", "#E5E5E5");
				var rel = $(this).attr("rel");
				rel = rel.split("|");
				$("#juez_select").html(rel[1]);
				$("#juez_in").val(rel[0]);

		});
		
		$(".button-fiscal").on("click", function(){
				$(".button-fiscal").css("background-color", "#FFFFFF");
				$(this).css("background-color", "#E5E5E5");
				var rel = $(this).attr("rel");
				rel = rel.split("|");
				$("#fiscal_select").html(rel[1]);
				$("#fiscal_in").val(rel[0]);

		});
		
		$(".button-defensor").on("click", function(){
				$(".button-defensor").css("background-color", "#FFFFFF");
				$(this).css("background-color", "#E5E5E5");
				var rel = $(this).attr("rel");
				rel = rel.split("|");
				$("#defensor_select").html(rel[1]);
				$("#defensor_in").val(rel[0]);
		});		

		
		// Este evento captura el click sobre una selda y llama a "seleccion"
		$(".fraction_hour").on("click",function(event){
			seleccion($(this).attr("id"));
		});
		
		// Esta porcion se encarga de evitar que se pueda seleccionar texto dentro de la tabla.
		$(".table").css({
			'MozUserSelect':'none',
			'webkitUserSelect':'none'
		}).attr('unselectable','on').bind('selectstart', function() {
			return false;
		});
		
		
		// ####### AJAX #######
		
		// Esta funcion se encarga de llamar a las funciones necesarias para actualizar el GRID
		// a la nueva fecha seleccionada
		function completeGrid(date,data){
			
			// cambio el formato de la fecha de Y-m-d a d/m/Y.
			var date_sel = new Date($("#in_fecha").datepicker( "getDate" ));
			fecha_select = $.datepicker.formatDate("dd/mm/yy", date_sel);
			
			// actualizo el valor del input hidden para la fecha
			$("#fecha_in").attr("val",fecha_select);
			
			 //actualizo en el span correspondiente la fecha indicada.
			$("#fecha_seleccionada").html("&nbsp;"+fecha_select);

			// la variable global "salas" contiene la informacion necesaria para dibujar el GRID
			salas = data;

			// llamo a clean selection para limpiar las celdas. la misma funcion llama a la funcion
			// que pinta los horarios no disponibles.
			clean_selection();

		}
		
		
		// Se pide informacion de las salas para una nueva fecha.
		function drawTable(date){
			// HAGO EL LLAMADO POR AJAX
			$.post("<?php echo $this->Html->url(array("controller" => "Audiencias","action" => "getSalasInfoInDate"));?>/"+date, function(data, status) {
				//Con la respuesta llamo a la funcion correspondiente.
				completeGrid(date,data);
			}, "json");
		}	
	});

</script>

