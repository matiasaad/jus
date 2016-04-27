<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Matias Javier saad">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Poder Judicial - Provincia de Rio Negro</title>

    <!-- Bootstrap core CSS -->
    <?php echo $this->Html->css('bootstrap/bootstrap.min.css', 'stylesheet'); ?>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	<?php  $userlogged = $this->Session->read('User'); ?>
	<nav class="navbar navbar-default navbar-inverse" role="navigation">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<span class="navbar-brand" href="#">Poder Judicial - Provincia de Rio Negro</span>
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Navegacion</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav navbar-right">
			<?php if (!$userlogged){?>
				<li><a href="/auth/login" data-description="ingresar en el sistema">Ingresar</a></li>
			<?php }else{?>
				<?php if($userlogged['Usuario']['type'] == 1000){?>
					<li class="dropdown">
					  <a href="/Usuario/adminUsuarios" class="dropdown-toggle" data-toggle="dropdown">Administrar Usuarios <b class="caret"></b></a>
					  <ul class="dropdown-menu">
						<li><a href="/Usuario/addUser">Agregar Usuario</a></li>
						<li class="divider"></li>
						<li><a href="/Usuario/adminUsuarios">Administrar</a></li>
					  </ul>
					</li>
				<?php }?>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Audiencias <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="/Audiencias/">Listar Audiencias</a></li>
					<li class="divider"></li>
					<li><a href="/Audiencias/nuevaAudiencia">Nueva Audiencia</a></li>
				  </ul>
				</li>
				<li class="divider"></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $userlogged['Usuario']['username'];?> <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="/Usuario/cuenta">Mi cuenta</a></li>
					<li class="divider"></li>
					<li><a href="/Auth/logout">Salir</a></li>
				  </ul>
				</li>
			<?php }?>
		  </ul>

		</div><!-- /.navbar-collapse -->

	  </div><!-- /.container-fluid -->
	</nav>
	<!------------------------------------------------------------------------------------------------------------->
	<!--------------------------------------------- CONTENT ------------------------------------------------------->
	<!------------------------------------------------------------------------------------------------------------->	
	<div class="container principal-container">
		<?php echo $content_for_layout ?>
		<div class="clear"></div>

<!--
		<hr style="margin-top:15px;">	
-->
	</div>

	
	
	<!------------------------------------------------------------------------------------------------------------->
	<!-------------------------------------------- Footer --------------------------------------------------------->
	<!------------------------------------------------------------------------------------------------------------->
		<blockquote>
			<footer class="blockquote-reverse">
				<p class="text-muted"> <cite title="Source Title">Poder Judicial, Provincia de Río Negro - Copyleft <?php echo date('Y')?> </cite> | <a href="mailto:algun_email@jusrionegro.gov.ar">Contacto</a></p>
			</footer>
		</blockquote>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	<?php echo $this->Html->script(array(
		'jquery-2.1.1.min.js',
		'bootstrap/bootstrap.min.js',
	)); ?>
	
	<script language="javascript">

	//$(document).ready( function () {
		if(typeof($('.message_info, .message_error, .message_warning')) != 'undefined') {
			setTimeout(function(){ $('.message_info, .message_error').hide('slow'); }, 10000);
		}
	//});

	</script>
  </body>
</html>
