<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Registro de usuarios</title>
	<?php require '../common/common_headers.php' ;?>
  </head>
	<body>
      <!-- Contenedor principal, requerido por Bootstrap -->
      <div class="container">   
		<div id=header>
			<img class="img-responsive" src="../images/header-gauchada.png"/>
		</div> 
      	<div class="panel panel-default login">
        	<div class="panel-heading">
          	  <!-- Encabezado del formulario -->
          	  <h3 class="panel-title">Registro de usuarios<img src="../images/logo-gauchada.png"/></h3>
			</div>
        <div class="panel-body">
        <!-- Formulario de alta de usuario -->
          <form class="form-horizontal">
			<!-- Nombre del usuario -->
			<div class="form-group">
			  <label for="user" class="col-sm-2 control-label">Nombre</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="user" />
			  	</div>
			</div>
            <!-- Apellido del usuario -->
            <div class="form-group">
			  <label for="pass" class="col-sm-2 control-label">Apellido</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" id="user" />
                </div>
            </div>
            <!-- Email del usuario -->
            <div class="form-group">
			  <label for="user" class="col-sm-2 control-label">E-mail</label>
              	<div class="col-sm-10">
					<input type="email" class="form-control" id="user" />
                </div>
            </div>
            <!-- Teléfono del usuario -->
            <div class="form-group">
			  <label for="user" class="col-sm-2 control-label">Teléfono</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" id="user" />
                </div>
            </div>
            <!-- Contraseña del usuario -->
            <div class="form-group">
			  <label for="user" class="col-sm-2 control-label">Clave</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="user" />
                </div>
            </div>
             
         	<!-- Botones del formulario -->
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">                                  
                  <input type="submit" class="btn btn-primary" value="Enviar">
                  <input type="reset" class="btn btn-primary" value="Reiniciar">
                  <a type="button" class="btn btn-primary" href="../login/index.php">Inicio</a>
				</div>
			</div>              
          </form>
        </div>                                
      </div>
    </div>        
  </body>    
</html>