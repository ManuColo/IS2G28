<?php
use function Composer\Autoload\includeFile;
?>
<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Inicio</title>
	<?php 
		require './common/common_headers.php' ;
	?>
  </head>
  <body>
	<!-- Contenedor principal, requerido por Bootstrap -->	
	<div class="container">
		<div id=header>
			<img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
		</div>
	  	<?php 	
	  	session_start();
		include('common/menu.php');	
	  	?>
		<div class="jumbotron">
			<div class="panel panel-default index" style="text-align:center;">
			<!-- Titulo de la seccion -->
				<div class="panel-heading">
          			<h1 class="panel-title">Una Gauchada</h1>
				</div>
				<div id="logo">
					<img src="<?php echo $cfg->wwwRoot;?>/src/images/logo-gauchada.png"/>
				</div>
				<div class="panel-body">
					<p> Sabemos que hay muchas personas que necesitan ayuda y hay muchas otras personas dispuestas a ayudar. </p>
					<p> ¿Necesitás un favor?¿Querés ayudar a alguien? </p>
					<p> Te ayudamos! Contactate con personas como vos desde UNA GAUCHADA! </p>
			  		<?php 
			  		if (!isset($_SESSION['logged'])) {
						if($_SESSION['logged']== false){ ?>
			  		<small class="pull-right"> Para ver el contenido tenés que iniciar sesión <span class="glyphicon glyphicon-arrow-up"></span></small>
			  		<?php } }?>
				</div>        
			</div>
		</div>
    </div>
  </body>    
</html>