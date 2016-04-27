	<?php echo $this->Html->css('styles_added.css');?>

	<div class="grid_11">
		<div class="box-container">

			<h3>Registro de Usuario</h3>

			<div id="box-signup" >
				<?php echo $this->Session->flash('message_error'); ?>

				<p>Se deben completar todos los campos para poder registrarse en el sistema.</p>


				<?php echo $this->Form->create(null, array('url' => array('controller' => 'Usuario', 'action' => 'save'), 'id'=>'user_add')); ?>

					<div class="fila_datos databox">
							<h4>
							<label for="in_username">Nombre de Usuario</label><br/>
							<input type="text" name="data[Usuario][username]" id='in_username' value="<?php  if(isset($data['Usuario']['username'])){echo $data['Usuario']['username'];}?>"/>
							<?php echo $this->Form->error('Usuario.username', null, array('class'=>'message_error'));?>
							</h4>
					</div>
					
					
					<div class="fila_datos databox">
							<h4>
							<label for="in_name">Nombre</label><br/>
							<input type="text" name="data[Usuario][nombre]" id='in_name' value="<?php  if(isset($data['Usuario']['nombre'])){echo $data['Usuario']['nombre'];}?>"/>
							<?php echo $this->Form->error('Usuario.nombre', null, array('class'=>'message_error'));?>
							<br/>
							<label for="in_lastname">Apellido</label><br/>
							<input type="text" name="data[Usuario][apellido]" id='in_lastname' value="<?php  if(isset($data['Usuario']['apellido'])){echo $data['Usuario']['apellido'];}?>"/>
							<?php echo $this->Form->error('Usuario.apellido', null, array('class'=>'message_error'));?>
							</h4>
					</div>



					<div class="clearboth clearfloat" ></div>
					
					<div class="fila_datos databox" >
							<h4>
							<label for="data[Usuario][area_id]">Area</label><br/>
							<select name="data[Usuario][area_id]" id="data[Usuario][area_id]" style="height:45px;width:226px;">
								<option  value="0" SELECTED>Seleccione un Area</option>
								<?php  foreach($areas as $area){?>
									<option  value="<?php  echo $area['Area']['id'];?>"><?php  echo $area['Area']['nombre'];?></option>
								<?php }?>
							</select>
							<br/>
							<label for="in_cargo">Cargo</label><br/>
							<input type="text" name="data[Usuario][cargo]" id='in_cargo' value="<?php  if(isset($data['Usuario']['cargo'])){echo $data['Usuario']['cargo'];}?>"/>
							<?php echo $this->Form->error('Usuario.cargo', null, array('class'=>'message_error'));?>
							</h4>
					</div>

					<div class="fila_datos databox" >
							<h4>
							<label for="in_email">Email</label><br/>
							<input type="email" name="data[Usuario][email]" id='in_email' value="<?php  if(isset($data['Usuario']['email'])){echo $data['Usuario']['email'];}?>"/>
							<br/>
							<label for="in_email_confirm">Confirmar email</label><br/>
							<input type="email" name="data[Usuario][email_confirm]" id='in_email_confirm' value="<?php  if(isset($data['Usuario']['email_confirm'])){echo $data['Usuario']['email_confirm'];}?>"/>
							<?php echo $this->Form->error('Usuario.email', null, array('class'=>'message_error'));?>
							</h4>
					</div>

					<div class="fila_datos databox">
							<h4>
							<label for="in_password">Password</label><br/>
							<input type="password" name="data[Usuario][password]" id='in_password' value="<?php  if(isset($data['Usuario']['password'])){echo $data['Usuario']['password'];}?>"/>
							<br/>
							<label for="in_pass_confirm">Confirmar password</label><br/>
							<input type="password" name="data[Usuario][pass_confirm]" id='in_pass_confirm' value=""/>
							<?php echo $this->Form->error('Usuario.password', null, array('class'=>'message_error'));?>
							</h4>
					</div>

					<div class="clearboth clearfloat" ></div>

					<div class="reg_button">
						<input class="button-border"  type="submit" value="Registrar" class="button">  &nbsp; 
						<input class="button-border"  type="reset" value="Borrar" class="button">
					</div>

				</form>
				
			</div><!--box-signup-->
			
		</div><!--box-container-->
	</div><!--grid_11-->
<!--
	<script language='javascript'>
		$(document).ready( function () {


		});
	</script>
-->
