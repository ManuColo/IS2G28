<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Inicio</title>
	<?php require '../common/common_headers.php' ;?>
  </head>
  <body>
	<!-- Contenedor principal, requerido por Bootstrap -->	
	<div class="container">
		<div id=header>
			<img class="img-responsive" src="../images/header-gauchada.png"/>
		</div>
	  	<ul class="nav nav-pills pull-right">
		  <li class="active"><a href="#">Inicio</a></li>
		  <li><a href="./login.php">Iniciar Sesión</a></li>
		  <li><a href="../registro/registro.php">Registrate</a></li>
		</ul>
		<div class="jumbotron">
			<div class="panel panel-default index" style="text-align:center;">
			<!-- Titulo de la seccion -->
				<div class="panel-heading">
          			<h1 class="panel-title">Una Gauchada</h1>
				</div>
				<div id="logo">
					<img src="../images/logo-gauchada.png"/>
				</div>
				<div class="panel-body">
					<p> Sabemos que hay muchas personas que necesitan ayuda y hay muchas otras personas dispuestas a ayudar. </p>
					<p> ¿Necesitás un favor?¿Querés ayudar a alguien? </p>
					<p> Te ayudamos! Contactate con personas como vos desde UNA GAUCHADA! </p>
			  		<small class="pull-right"> Tenés que iniciar sesión <span class="glyphicon glyphicon-arrow-up"></span></small>
				</div>        
			</div>
		</div>
    </div>
  </body>    
</html>