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
		<div id="header">
			<img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
		</div>
	  	<?php 	
	  	session_start();
		include('common/menu.php');	?>
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
					<p> Sabemos que hay muchas personas que necesitan ayuda. </p>
					<p> Tambi&eacute;n hay muchas personas dispuestas a ayudar. </p>
					<p> ¿Necesit&aacute;s un favor?¿Quer&eacute;s hacerle un favor a alguien? </p>
					<p> Te ayudamos! Contactate con personas como vos desde UNA GAUCHADA </p>
					<p> Y lleg&aacute; a ser ""Dios""! </p>
			  		
			  		
			  		<?php if (!isset($_SESSION['logged'])): //Mensaje que verá sólo usuario sin iniciar sesión ?>
					<br>
			  		<small class="pull-right"> Para ver el contenido ten&eacute;s que iniciar sesi&oacute;n <span class="glyphicon glyphicon-arrow-up"></span></small>
			  		<?php endif; ?>
				</div>        
			</div>
		</div>
    </div>
  </body>    
</html>