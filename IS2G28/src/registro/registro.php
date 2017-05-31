<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Registro de usuarios</title>
	<?php require '../common/common_headers.php' ;?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#login-form').on('submit', function() {
			var user = $('#user').val();
			if (!isEmail(user)) {
				return false;
				}
			});
		});
	</script>
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
          <form class="form-horizontal" method="post" action="signin.php">
			<!-- Nombre del usuario -->
			<div class="form-group">
			  <label for="name" class="col-sm-2 control-label" onchange="validarN('name')">Nombre</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" />
			  	</div>
			</div>
            <!-- Apellido del usuario -->
            <div class="form-group">
			  <label for="lastname" class="col-sm-2 control-label">Apellido</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" id="lastname" name="lastname" />
                </div>
            </div>
            <!-- Email del usuario -->
            <div class="form-group">
			  <label for="mail" class="col-sm-2 control-label">E-mail</label>
              	<div class="col-sm-10">
					<input type="email" class="form-control" id="mail" name="mail" />
                </div>
            </div>
            <!-- Teléfono del usuario -->
            <div class="form-group">
			  <label for="phone" class="col-sm-2 control-label">Teléfono</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" id="phone" name="phone" />
                </div>
            </div>
            <!-- Contraseña del usuario -->
            <div class="form-group">
			  <label for="password" class="col-sm-2 control-label">Clave</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password" name="password" />
                </div>
            </div>
             
         	<!-- Botones del formulario -->
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">                                  
                  <input type="submit" class="btn btn-primary" value="Enviar">
                  <input type="reset" class="btn btn-primary" value="Reiniciar">
                  <a type="button" class="btn btn-primary" onClick="goBack();">Cancelar</a>
				</div>
			</div>              
          </form>
        </div>                                
      </div>
    </div>        
  </body>    
</html>