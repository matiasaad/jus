	<?php echo $this->Html->css('styles_added_bootstrap.css');?>
	<?php echo $this->Html->script('jquery-2.1.1.min.js');?>


	<!------------------------------------------------------------------------------------------------------------->
	<!---------------------------------------------- LOGIN -------------------------------------------------------->
	<!------------------------------------------------------------------------------------------------------------->

    <div class="container-fluid">
		<h3 style="text-align: center;">Completa tu nombre de usuario o email y la contraseña para ingresar.</h3>
		
		<?php echo $this->Form->create(null, array('url' => array('controller' => 'Auth', 'action' => 'authenticate') , 'type' => 'post', 'class'=>'form-signin', 'id'=>'log_form')); ?>
			<?php echo $this->Session->flash('message_error');?>		
			<h2 class="form-signin-heading">Ingreso al Sistema</h2>
			<div class="row">
				<input type="text" class="input-block-level" name="data[nombre]" placeholder="Usuario o Email">
				<input type="password" class="input-block-level" name="data[password]" placeholder="Password">
			</div>
			
			<div class="row">
				<button class="btn btn-large btn-primary" type="submit">Entrar</button>
			</div>
		</form>
    </div> <!-- /container -->

	<script language="javascript">
	</script>
