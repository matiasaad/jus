	<?php echo $this->Html->css('styles_added_bootstrap.css');?>
	<?php echo $this->Html->script('jquery-2.1.1.min.js');?>
	<div class="section-title">Datos del usuario, Cambio de permisos y reseteo de clave.</div>
	<hr/>
	<!------------------------------------------------------------------------------------------------------------->
	<!------------------------------------------ User Admin ------------------------------------------------------->
	<!------------------------------------------------------------------------------------------------------------->

	<div class="container">
		<!--
		<div class="row">
			<h3>Configuración de modo de carga</h3>
			<div class="pull-right">
				<div class="col-md-5">
					<p>Este modo le indica al sistema si debe realizar o pasar por alto los chequeos importantes sobre fechas, vencimientos, etc.<br>
					</p>
				</div>
				<?php //if($flexibleMode){ ?>
					<span><b>Modo Flexible activado</b></span>
					<?php //echo $this->Html->link('<button type="button" class="btn btn-default"><span class="glyphicon glyphicon glyphicon-eye-open"></span>Activar Modo Estricto</button>', array('controller'=>'Usuario', 'action'=>'systemChargeMode', 'strict'), array('escape' => false) ); ?>
				<?php //}else{?>
					<span><b>Modo Flexible desactivado</b></span>
					<?php //echo $this->Html->link('<button type="button" class="btn btn-default"><span class="glyphicon glyphicon glyphicon-eye-close"></span>Activar Modo Flexible</button>', array('controller'=>'Usuario', 'action'=>'systemChargeMode', 'flexible'), array('escape' => false) ); ?>
				<?php //}?>
			</div>
		</div>		
		<hr>
		-->
		<div style="display: <?php if(Configure::read('sapt_flexible_mode')){ echo 'block';}else{ echo 'none';}?>">
			<div class="row bg-danger box box-rounded">
				<h3><b>Atención!..</b></h3>
				<h3><b>Modo Flexible activado</b></h3>
				<div class="col-md-12">
					<p>Este modo le indica al sistema si debe realizar o pasar por alto los chequeos importantes sobre fechas, vencimientos, etc.</p>
				</div>
			</div>		
			<hr>		
		</div>

		<div class="row">
			<div class="col-md-6 pull-right"> 
				<h4><b><span class="glyphicon glyphicon-bell"></span>Notificaciones: <?php if(isset($notificaciones) && $notificaciones){ echo 'Usted tiene '.$notificaciones.' notificaciones.';}else{ echo 'Usted NO tiene notificaciones';} ?></b></h4>
				<?php echo $this->Html->link('Click para ver las notificaciones', array('controller'=>'Notificaciones', 'action'=>'showNotificaciones')); ?>
				
			</div>
		</div>

		<div class="row">
			<?php echo $this->Html->link('<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span>Nuevo Usuario</button>', array('controller'=>'Usuario', 'action'=>'addUser'), array('escape' => false) ); ?>
		</div>
		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped table-hover table-bordered">
				  <thead>
					<tr>
					  <th>Usuario</th>
					  <th>Email</th>
					  <th>Permisos</th>
					  <th>Bloqueado</th>
					  <th>Acciones</th>
					</tr>
				  </thead>
				  <tbody>
					<?php
						if(!$users){
							echo "<tr><td>No se encontraron usuarios.</td><td>...</td><td>...</td><td>...</td><td>...</td></tr>";
						}else{
							
						}
					?>
					<tr>
					<?php
						if(!$users){
							echo "<tr><td>No se encontraron usuarios.</td><td>...</td><td>...</td><td>...</td><td>...</td></tr>";
						}
						
						foreach($users as $a_user){
							echo "<tr>";
							echo "<td>"; echo $this->Html->link($this->Html->image('edit.gif') . $a_user['Usuario']['username'], array('controller'=>'Usuario','action'=>'editUser',$a_user['Usuario']['id']), array('escape'=>false)); echo "</td>";
							echo "<td>".$a_user['Usuario']['email']."</td>";
							echo "<td>".$permissions[$a_user['Usuario']['type']]."</td>";
							if($a_user['Usuario']['blocked']){echo "<td>Si</td>";}else{echo "<td>No</td>";}
							echo "<td>";
								echo $this->Html->link('<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-trash"></span>Cancelar</button>', array('controller'=>'Usuario','action'=>'cancelAccount',$a_user['Usuario']['id']), array('escape'=>false));
								if($a_user['Usuario']['blocked']){
									echo $this->Html->link('<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-ok"></span>Desbloquear</button>', array('controller'=>'Usuario','action'=>'unblockUser',$a_user['Usuario']['id']), array('escape'=>false));
								}else{
									echo $this->Html->link('<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-lock"></span>Bloquear</button>', array('controller'=>'Usuario','action'=>'blockUser',$a_user['Usuario']['id']), array('escape'=>false));
								}
							echo "</td>";
							echo "</tr>";
						}
					?>
					</tr>
				  </tbody>
				</table>
			</div>

		</div>
	</div>

	<script language='javascript'>
		$(document).ready( function () {


		});
	</script>

