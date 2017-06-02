<?php
use function Composer\Autoload\includeFile;
?>
<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Falla Compra</title>
	<?php 
		require '../common/common_headers.php' ;
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
		include('common/menu.php');	
	  	?>
		<div class="jumbotron">
			<div class="panel panel-default index" style="text-align:center;">
			<!-- Mensaje de la seccion -->
				<div id="logo">
					<img src="<?php echo $cfg->wwwRoot;?>/src/images/logo-gauchada.png"/>
				</div>
				<div class="panel-body">
					<p> La operación no se pudo realizar! </p>
				</div>        
			</div>
		</div>
    </div>
  </body>    
</html>

