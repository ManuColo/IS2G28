<?php
session_start();
if ($_SESSION['logged']) {
	require '../../config/doctrine_config.php';
	$favors = $entityManager->getRepository("Favor")->findAll(); ?>
	<!DOCTYPE html>
		<html>
		<head>
		<title>Una Gauchada - Listado</title>
		<?php
		require '../common/common_headers.php' ;
		?>
	  </head>
	  <body>
		<!-- Contenedor principal, requerido por Bootstrap -->	
		<div class="container">
			<div id=header>
				<img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
			</div>
		  	<ul class="nav nav-pills pull-right">
			  <li class="active"><a href="../index.php">Inicio</a></li>
			  <li><a href="../login/logout.php">Cerrar Sesión</a></li>
			</ul>
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
						<?php
							foreach ($favors as $favor) { ?>
								<p><?php echo $favor->getTitle();?></p>
							<?php }
						?>
					</div>        
				</div>
			</div>
	    </div>
	  </body>    
	</html>
	<?php
} else {
	header("location:../login/login.php");
}