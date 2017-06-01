<!DOCTYPE html>
<html>
	<head>
		<title>Una Gauchada - Acceso de usuarios</title>
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
			<?php 	
		  	session_start();
			include('common/menu.php');	
		  	?>    
			<div class="panel panel-default login">
				<div class="panel-heading">
					<!-- Titulo de la seccion -->
					<h3 class="panel-title">Acceso de usuarios <img src="../images/logo-gauchada.png"/></h3>
				</div>
				<div class="panel-body">
					<!-- Formulario de alta de login -->
					<form class="form-horizontal" method="post" action="access.php" id="login-form">
						<?php 
						if (isset($_GET)&& ($_GET['message']=='loginFail')) { ?>
							<div class="alert alert-danger">Usuario o Clave Incorrectos</div>
						<?php }
						?>
						<!-- Usuario -->
						<div class="form-group">
							<label for="user" class="col-sm-2 control-label">Usuario</label>
							<div class="col-sm-10">
	                    		<input type="email" class="form-control" id="user" name="user" required/>
							</div>
						</div>
						<!-- Clave -->
						<div class="form-group">
							<label for="pass" class="col-sm-2 control-label">Clave</label>
							<div class="col-sm-10">
								<input type="password" name="password" class="form-control" id="pass" required/>
							</div>
						</div>
						<!-- Botones del formulario -->
						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">                                  
								<input id="submit" type="submit" class="btn btn-primary" value="Ingresar">
								<input type="button" class="btn btn-default" value="Cancelar" onClick="goBack();">
							</div>
						</div>              
					</form>
				</div>                                
			</div>
		</div>        
	</body>    
</html>