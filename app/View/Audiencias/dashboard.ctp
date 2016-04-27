	<?php echo $this->Html->css(array('styles_added_bootstrap.css','jquery-ui/jquery-ui.css'));?>
	<?php echo $this->Html->script(array('jquery-2.1.1.min.js','jquery-ui/jquery-ui.js'));?>

	<div class="col-md-12 box-data">
		<?php echo $this->Session->flash('message_error');?>
			<div class="row">
				<h3>Listado de Audiencias.</h3>
			</div>

			<div class="row">
				<!--------------------------------------------->
				<!------------------ FILTROS ------------------>
				<!--------------------------------------------->
				<nav class="navbar navbar-default" role="navigation">
				  <div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>
					  <a class="navbar-brand" href="#">Filtrar</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">

						<!-- Collect the nav links, forms, and other content for toggling -->
						<?php echo $this->Form->create(null, array('url' => array('controller' => 'ParqueMovil', 'action' => 'dashboard'), 'class'=>'navbar-form navbar-right','role'=>'search')); ?>
						  <div class="form-group">
							<label class="navbar-btn">Fecha</label>
							<input class="form-control crt_field" id="in_fecha" style="width:100px; height:30px;" type="text" name="data[Audiencia][fecha]" value="" >
						  </div>
						  &nbsp;
						  <div class="form-group">
							<label class="navbar-btn">Juez</label>
							<select class="navbar-btn" name="data[filters][especialidad]" id='filter_especialidad'>
								<option value="0" SELECTED>Seleccione uno</option>
							</select>
						  </div>
						  &nbsp;
						  <div class="form-group">
							<label class="navbar-btn">Fiscal</label>
							<select class="navbar-btn" name="data[filters][especialidad]" id='filter_especialidad'>
								<option value="0" SELECTED>Seleccione uno</option>
							</select>
						  </div>
						  &nbsp;
						  <div class="form-group">
							<label class="navbar-btn">Defensor</label>
							<select class="navbar-btn" name="data[filters][especialidad]" id='filter_especialidad'>
								<option value="0" SELECTED>Seleccione uno</option>
							</select>
						  </div>
						  &nbsp;
						  <button type="submit" class="btn btn-default" style="margin-top:10px;">Aplicar</button>
						</form>
						<div class="form-group">
							<?php echo $this->Html->link('Limpiar Filtro', array('controller'=>'ParqueMovil','action'=>'dashboardClean'), array('style'=>'margin-top:10px;','class'=>'btn btn-default'));?>
						</div>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
				</nav>
			</div>
			<div class="row" style="margin-top:0px;">
					<?php // echo $this->Misc->pagination($pagination_data);?> 
			</div>

			<div class="row" style="margin-top:0px;">
					<ul  class="pagination"><h4>Mostrando Audiencias desde 1 hasta 5 de un total de 18.</h4><li class="disabled"><a href="#">&laquo;</a></li><li class="active"><a href="/sapt/Permisionarios/dashboard/1">1<span class="sr-only">(current)</span></a></li><li><a href="/sapt/Permisionarios/dashboard/2">2</a></li><li><a href="/sapt/Permisionarios/dashboard/3">3</a></li><li><a href="/sapt/Permisionarios/dashboard/4">4</a></li><li class="disabled"><a href="#">&raquo;</a></li></ul> 
			</div>

			<div class="row">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Acciones</th>
							<th>Sala</th>
							<th>Fecha</th>
							<th>Horario</th>
							<th>Expediente</th>
							<th>Juez</th>
							<th>Fiscal</th>
							<th>Defensor</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<a><span class="glyphicon glyphicon-eye-open"></span> Ver</a>
								<a><span class="glyphicon glyphicon-remove-circle"></span> Eliminar</a>
							</td>
							<td>A - CAMARA EN LO CRIMINAL</td>
							<td>22/04/2016</td>
							<td>16:45 - 18:30</td>
							<td>152313-asd-2016</td>
							<td>Esteban, Pablo</td>
							<td>Gonzales, Matias</td>
							<td>Ploca, Andres</td>
						</tr>
						<tr>
							<td>
								<a><span class="glyphicon glyphicon-eye-open"></span> Ver</a>
								<a><span class="glyphicon glyphicon-remove-circle"></span> Eliminar</a>
							</td>
							<td>A - CAMARA EN LO CRIMINAL</td>
							<td>22/04/2016</td>
							<td>18:30 - 20:00</td>
							<td>124213-asd-2014</td>
							<td>Esteban, Pablo</td>
							<td>Gonzales, Matias</td>
							<td>Ploca, Andres</td>
						</tr>
						<tr>
							<td>
								<a><span class="glyphicon glyphicon-eye-open"></span> Ver</a>
								<a><span class="glyphicon glyphicon-remove-circle"></span> Eliminar</a>
							</td>
							<td>B - CAMARA EN LO CRIMINAL</td>
							<td>22/04/2016</td>
							<td>9:30 - 13:00</td>
							<td>147413-asd-2016</td>
							<td>Garcia, Pablo</td>
							<td>Gonzales, Matias</td>
							<td>Garcia, Juan Pablo</td>
						</tr>
						<tr>
							<td>
								<a><span class="glyphicon glyphicon-eye-open"></span> Ver</a>
								<a><span class="glyphicon glyphicon-remove-circle"></span> Eliminar</a>
							</td>
							<td>C - CAMARA EN LO CRIMINAL</td>
							<td>22/04/2016</td>
							<td>8:00 - 9:15</td>
							<td>157213-asd-2015</td>
							<td>Gomez, Federico</td>
							<td>Gonzales, Matias</td>
							<td>Garcia, Juan Pablo</td>
						</tr>
						<tr>
							<td>
								<a><span class="glyphicon glyphicon-eye-open"></span> Ver</a>
								<a><span class="glyphicon glyphicon-remove-circle"></span> Eliminar</a>
							</td>
							<td>C - CAMARA EN LO CRIMINAL</td>
							<td>22/04/2016</td>
							<td>13:15 - 16:00</td>
							<td>123213-asd-2016</td>
							<td>Gomez, Federico</td>
							<td>Gonzales, Matias</td>
							<td>Garcia, Juan Pablo</td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>
	<div class="clearboth clearfloat" ></div>
		<hr>
		<div class="pull-right">
			<?php //echo $this->Html->link('Volver - Permisionarios',array('controller'=>'Usuario','action'=>'adminUsuarios'), array('class' => 'btn btn btn-primary'));?>
		</div>		
	</div>

	<script language='javascript'>
		$(document).ready( function () {
				
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
				dateFormat: 'dd/mm/yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
			
			$.datepicker.setDefaults($.datepicker.regional['es']);
			
			$("#in_fecha").datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: "0:+20"		
			});
		
		});
	</script>
