	<?php echo $this->Html->css('styles_added_bootstrap.css');?>
	<?php echo $this->Html->script('jquery-2.1.1.min.js');?>
	

	<div class="section-title">Cuenta de usuario</div>	
	<hr>
	<div class="container">
		<?php echo $this->Session->flash('message_error'); ?>
		<?php echo $this->Session->flash('message_info'); ?>

		<div class="row">
			<div class="col-md-4 col-xs-8 box-default">
				<h4></p>Nombre de usuario: <?php echo $user['Usuario']['username']?></h4>
				<h4>Nombre: <?php  echo $user['Usuario']['nombre'].' '.$user['Usuario']['apellido'];?></h4>
				<h4>Email: <?php  echo $user['Usuario']['email'];?></h4>
				<button class="btn btn-default" id='edit_email' href="">Cambiar Email</button>
				<button class="btn btn-default" id='edit_password' href="">Cambiar Password</button>
			</div>			
		</div>
		<hr>
		<div class="row">
			<div class="col-md-4 col-xs-8 box-default" style="<?php if(isset($field) && $field == 'email'){ echo 'display:block;';}else{ echo 'display:none;';}?>" id="box-email">
				<?php  echo $this->Form->create(null, array('url'=>array('controller' => 'Usuario', 'action' => 'editUserAccount', 'email'))); ?>
					<?php echo $this->Form->error('Usuario.email', null, array('class'=>'message_error'));?>
					<label for="in_email">Email</label><br/>
					<input class="form-control" type="email" name="data[Usuario][email]" id='in_email' value="<?php  if(isset($user['Usuario']['email'])){echo $user['Usuario']['email'];}?>"/>
					<br/>
					<label for="in_email_confirm">Confirmar email</label><br/>
					<input class="form-control" type="email" name="data[Usuario][email_confirm]" id='in_email_confirm' value="<?php  if(isset($user['Usuario']['email_confirm'])){echo $user['Usuario']['email_confirm'];}?>"/>
					<div>
						<input class="btn btn-primary"  type="submit" value="Guardar">
						<input class="btn btn-default" id="email_cancelar" type="reset" value="cancelar">
					</div>
				</form>
			</div>			


			<div class="col-md-4 col-xs-8 box-default" style="<?php if(isset($field) && $field == 'password'){ echo 'display:block;';}else{ echo 'display:none;';}?>" id="box-password">
				<?php  echo $this->Form->create(null, array('url'=>array('controller' => 'Usuario', 'action' => 'editUserAccount', 'password'))); ?>
					<?php echo $this->Form->error('Usuario.password', null, array('class'=>'message_error'));?>
					<label for="in_password">Password</label><br/>
					<input class="form-control" type="password" name="data[Usuario][password]" id='in_password' value=""/>
					<br/>
					<label for="in_pass_confirm">Confirmar password</label><br/>
					<input class="form-control" type="password" name="data[Usuario][pass_confirm]" id='in_pass_confirm' value=""/>
					<div>
						<input class="btn btn-primary"  type="submit" value="Guardar" class="button">
						<input class="btn btn-default" id="pass_cancelar" type="reset" value="cancelar" class="button">
					</div>
				</form>
			</div>
		</div>

	</div>
	
	<script language='javascript'>
		$(document).ready( function () {

			//
			//-------Cuenta de usuario---------
			//
			$("#edit_email").click(function(){
				$("#box-email").show(500);
				return false;
			});
			$("#email_cancelar").click(function(){
				$("#box-email").hide(500);
				return false;
			});

			$("#edit_password").click(function(){
				$("#box-password").show(500);
				return false;
			});
			$("#pass_cancelar").click(function(){
				$("#box-password").hide(500);
				return false;
			});

		});
	</script>
