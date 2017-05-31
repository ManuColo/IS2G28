<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Obtener créditos</title>
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
          	  <h3 class="panel-title">Obtener créditos<img src="../images/logo-gauchada.png"/></h3>
			</div>
        <div class="panel-body">
        <!-- Formulario de solicitud de crédito -->
          <form class="form-horizontal">
			<!-- Tipo de tarjeta -->
			<div class="form-group">
			  <label for="user" class="col-sm-2 control-label">Tarjeta</label>
				<div class="col-sm-10">
					<select class="selectpicker">
						<option> </option>
						<option>VISA Débito</option>
						<option>VISA Crédito</option>
					</select>
			  	</div>
			</div>
            <!-- Banco -->
            <div class="form-group">
			  <label for="pass" class="col-sm-2 control-label">Banco</label>
				<div class="col-sm-10">
                    <select class="selectpicker">
						<option> </option>
						<option>Provincia</option>
						<option>Nación</option>
					</select>
                </div>
            </div>
            <!-- Número -->
            <div class="form-group">
			  <label for="user" class="col-sm-2 control-label">Número</label>
              	<div class="col-sm-10">
					<input type="number" class="form-control" id="user" />
                </div>
            </div>
            <!-- Código de seguridad -->
            <div class="form-group">
			  <label for="user" class="col-sm-2 control-label">Código</label>
				<div class="col-sm-10">
					<input type="number" class="form-control" id="user" />
                </div>
            </div>
            <!-- Cantidad de créditos -->
            <div class="form-group">
			  <label for="user" class="col-sm-2 control-label">Cantidad</label>
				<div class="col-sm-10">
					<select class="selectpicker">
						<option> - </option>
  						<option> 1 </option>
					</select>
                </div>
            </div>
             
         	<!-- Botones del formulario -->
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">                                  
                  <input type="submit" class="btn btn-primary" value="Comprar">
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