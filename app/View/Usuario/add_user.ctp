	<?php echo $this->Html->css('styles_added_bootstrap.css');?>
	<?php echo $this->Html->script('jquery-2.1.1.min.js');?>
	

	<div class="section-title">Registrar nuevo usuario</div>	
	<hr>
	
	<div class="container">
		<?php echo $this->Session->flash('message_error'); ?>
		<?php echo $this->Form->create(null, array('url' => array('controller' => 'Usuario', 'action' => 'save_user'), 'id'=>'user_add')); ?>

			<p><b>Se deben completar todos los campos para pode registrar el usuario.</b></p>
			<div class="row">
				<div class="col-md-4 col-xs-8 box-default">
					<label for="in_username">Nombre de usuario</label><br/>
					<input class="form-control" type="text" name="data[Usuario][username]" id='in_username' value="<?php  if(isset($data['Usuario']['username'])){echo $data['Usuario']['username'];}?>"/>
					<?php echo $this->Form->error('Usuario.username', null, array('class'=>'message_error'));?>
					<br/>
					<h4>Seleccione el permiso que desea asignar</h4>
					<?php foreach($permissions as $key=>$val){?>
						<div class="row">
							<div class="col-md-1">
								<input class="form-control" type="radio" name="data[Usuario][type]" value="<?php echo $key; ?>" <?php if(isset($data['Usuario']['type']) && $key == $data['Usuario']['type']){ echo "CHECKED";}?>>
							</div>				
							<div class="col-md-4">
								<label><?php echo $val; ?></label>
							</div>
						</div>
					<?php }?>
				</div>			
			</div>
			<hr>
			<div class="row">
				<div class="col-md-4 col-xs-8 box-default">
					<p>Ingrese el nombre y apellido del usuario.</p>
					<label for="in_name">Nombre</label><br/>
					<input class="form-control" type="text" name="data[Usuario][nombre]" id='in_name' value="<?php  if(isset($data['Usuario']['nombre'])){echo $data['Usuario']['nombre'];}?>"/>
					<?php echo $this->Form->error('Usuario.nombre', null, array('class'=>'message_error'));?>
					<br/>
					<label for="in_lastname">Apellido</label><br/>
					<input class="form-control" type="text" name="data[Usuario][apellido]" id='in_lastname' value="<?php  if(isset($data['Usuario']['apellido'])){echo $data['Usuario']['apellido'];}?>"/>
					<?php echo $this->Form->error('Usuario.apellido', null, array('class'=>'message_error'));?>
				</div>
				<div class="col-md-4 col-xs-8 box-default">
					<p>Ingrese el el email usuario.</p>
					<?php echo $this->Form->error('Usuario.email', null, array('class'=>'message_error'));?>
					<label for="in_email">Email</label><br/>
					<input class="form-control" type="email" name="data[Usuario][email]" id='in_email' value="<?php  if(isset($data['Usuario']['email'])){echo $data['Usuario']['email'];}?>"/>
					<br/>
					<label for="in_email_confirm">Confirmar email</label><br/>
					<input class="form-control" type="email" name="data[Usuario][email_confirm]" id='in_email_confirm' value=""/>
				</div>

				<div class="col-md-4 col-xs-8 box-default">
					<p>Ingrese el Password del usuario y repitalo para confirmarlo.</p>
					<?php echo $this->Form->error('Usuario.password', null, array('class'=>'message_error'));?>
					<label for="in_password">Password</label><br/>
					<input class="form-control" type="password" name="data[Usuario][password]" id='in_password' value="<?php  if(isset($data['Usuario']['password'])){echo $data['Usuario']['password'];}?>"/>
					<label for="in_pass_confirm">Confirmar Password</label><br/>
					<input class="form-control" type="password" name="data[Usuario][pass_confirm]" id='in_pass_confirm' value=""/>
				</div>
			</div>
			<div class="row">
				<input class="btn btn-primary"  type="submit" value="Registrar" class="button">  &nbsp; 
				<input class="btn btn-default"  type="reset" value="Borrar" class="button">
			</div>
		</form>
		<hr>
		<div class="pull-right">
			<?php echo $this->Html->link('Volver - Administrar Usuarios',array('controller'=>'Usuario','action'=>'adminUsuarios'), array('class' => 'btn btn btn-primary'));?>
		</div>
	</div>


	<script language='javascript'>
		$(document).ready( function () {


		});
	</script>
