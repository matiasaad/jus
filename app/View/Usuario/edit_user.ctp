	<?php echo $this->Html->css('styles_added_bootstrap.css');?>
	<?php echo $this->Html->script('jquery-2.1.1.min.js');?>
	
	<?php //print_r($user_a);exit;?>
	
	<div class="section-title">Datos del usuario, Cambio de permisos y reseteo de clave.</div>
	<hr/>
	<div class="container">

		<div class="row">
			<nav class="navbar navbar-default" role="navigation">
			  <div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#user-options-navbar-collapse">
					<span class="sr-only"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="">Acciones sobre usuarios</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="user-options-navbar-collapse">
				  <ul class="nav navbar-nav">
					<li><a class="btn" id="cambiar_permisos" >Cambiar permisos</a></li>
					<li><a class="btn" id="edit_password" >Cambiar Password</a></li>
					<li>
					<?php 
						if($user_a['Usuario']['blocked']){
							echo $this->Html->link('Desbloquear usuario', array('controller'=>'Usuario','action'=>'unblockUser', $user_a['Usuario']['id'], 'from_inside'), array('class'=>'btn'));
						}else{
							echo $this->Html->link('Bloquear usuario', array('controller'=>'Usuario','action'=>'blockUser', $user_a['Usuario']['id'], 'from_inside'), array('class'=>'btn'));
						}
					?>
					</li>
				  </ul>
				   <ul class="nav navbar-nav navbar-right">
					<li><?php echo $this->Html->link('Cancelar cuenta',array('controller'=>'Usuario','action'=>'cancelAccount', $user_a['Usuario']['id']));?></li>
				  </ul>
				</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>		
		</div><!-- /.row -->
		<hr/>

		
		<?php echo $this->Session->flash('message_error'); ?>
		<?php echo $this->Session->flash('general_message'); ?>
		<?php echo $this->Form->error('Usuario.password', null, array('class'=>'message_error'));?>

		<div class="row">

			<div class="col-md-4 col-xs-8 box-default">
				<h3>Detalles del usuario</h3>


				<h4>
					<p>Nombre de usuario: <?php echo $user_a['Usuario']['username'];?>
					<?php if($user_a['Usuario']['blocked']){?>
						<span class="glyphicon glyphicon-lock">(Bloqueado)</span></p>
					<?php }else{?>
						<b>( Habilitado )</b></p>
					<?php }?>
					<br/>
					<p>Nombre: <?php echo $user_a['Usuario']['nombre'];?></p><br/>
					<p>Apellido: <?php echo $user_a['Usuario']['apellido'];?></p><br/>
					<p>Email: <?php echo $user_a['Usuario']['email'];?></p><br/>
					<p>Permisos: <?php echo $permissions[$user_a['Usuario']['type']];?></p><br/>
				</h4>
			</div>
			<div class="col-md-4 col-xs-8 box-default" style="display:none;" id="box-permiso">	
				<h3>Permisos del usuario</h3>
				<h4>
					<? echo $this->Form->create(null, array('url'=>array('controller' => 'Usuario', 'action' => 'UptateUser',$user_a['Usuario']['id']))); ?>
						<input type="hidden" name="data[Usuario][id]" id="user_id" value="<?php echo $user_a['Usuario']['id'];?>">
						<?php foreach($permissions as $val=>$key){?>
							<div class="row">
								<div class="col-md-1">
									<input class="form-control" type="radio" name="data[Usuario][type]" value="<?php echo $val; ?>" <?php if($val == $user_a['Usuario']['type']){ echo "CHECKED";}?>>
								</div>
								<div class="col-md-4">
									<label><?php echo $key; ?></label>
								</div>
							</div>
						<?php }?>
						<div>
							<input class="btn btn-default"  type="submit" value="Guardar" class="button">
						</div>
					</form>
				</h4>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-4 col-xs-8 box-default" style="display:none;" id="box-password">
				<? echo $this->Form->create(null, array('url'=>array('controller' => 'Usuario', 'action' => 'UptateUser',$user_a['Usuario']['id']))); ?>
					<input type="hidden" name="data[Usuario][id]" id="user_id" value="<?php echo $user_a['Usuario']['id'];?>">
					<h4>
					<label for="in_password">Password</label><br/>
					<input type="password" name="data[Usuario][password]" id='in_password' value=""/>
					<br/>
					<label for="in_pass_confirm">Confirmar password</label><br/>
					<input type="password" name="data[Usuario][pass_confirm]" id='in_pass_confirm' value=""/>
					<div>
						<input class="button-border"  type="submit" value="Guardar" class="button">
						<input class="button-border" id="pass_cancelar" type="reset" value="cancelar" class="button">
					</div>
					</h4>
				</form>
			</div>
		</div>				


		<div class="pull-right">
			<?php echo $this->Html->link('Volver - Administrar Usuarios',array('controller'=>'Usuario','action'=>'adminUsuarios'), array('class' => 'btn btn btn-primary'));?>
		</div>

		<div class="clearboth clearfloat" ></div>
		
	</div><!--box-container-->


	<script language='javascript'>
		$(document).ready( function () {
			$("#edit_password").click(function(){
				$("#box-password").show(500);
				return false;
			});
			
			$("#cambiar_permisos").click(function(){
				
				$("#box-permiso").show(500);
			});
		});
	</script>

