<?php 
session_start();
if ($_SESSION['logged']) { ?>
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
		<?php 	
		include('../common/menu.php');	
	  	?> 
      	<div class="panel panel-default login">
        	<div class="panel-heading">
          	  <!-- Encabezado del formulario -->
          	  <h3 class="panel-title">Obtener créditos<img src="../images/logo-gauchada.png"/></h3>
			</div>
        <div class="panel-body">
        <!-- Formulario de solicitud de crédito -->
          <form class="form-horizontal" method="post" action="reqCredits.php">
			<!-- Tarjeta -->
			<div class="form-group">
			  <label for="card" class="col-sm-2 control-label">Tarjeta</label>
				<div class="col-sm-10">
					<select class="selectpicker" id="card" name="card" required >
						<option id="0"> </option>
						<option id="vd">VISA</option>
						<option id="vc">MASTERCARD</option>
					</select>
			  	</div>
			</div>
			<!-- Titular de la tarjeta -->
            <div class="form-group">
			  <label for="titCard" class="col-sm-2 control-label">Titular</label>
              	<div class="col-sm-10">
					<input type="text" class="form-control" id="titCard" name="titCard" placeholder="Titular de la tarjeta" required />
                </div>
            </div>
            <!-- Número -->
            <div class="form-group">
			  <label for="numCard" class="col-sm-2 control-label">Número</label>
              	<div class="col-sm-10">
					<input type="text" class="form-control" id="numCard" name="numCard" placeholder="Sólo números" required />
                </div>
            </div>
            <!-- Fecha de Emisión -->
            <div class="form-group">
			  <label for="cardE" class="col-sm-2 control-label">Emisión</label>
              	<div class="col-sm-10">
					<input type="date" class="form-control" id="cardE" name="cardE" 
							data-provide="datepicker" data-date-format="mm/yy" 
                           	data-date-autoclose="true" placeholder="Fecha de emisión mm/yy" required />
                </div>
            </div>
            <!-- Fecha de Vencimiento -->
            <div class="form-group">
			  <label for="cardV" class="col-sm-2 control-label">Vencim.</label>
              	<div class="col-sm-10">
					<input type="date" class="form-control" id="cardV" name="cardV" 
							data-provide="datepicker" data-date-format="mm/yy" 
                           	data-date-autoclose="true" placeholder="Fecha de vencimiento mm/yy" required />
                </div>
            </div>
            <!-- Código de seguridad -->
            <div class="form-group">
			  <label for="codCard" class="col-sm-2 control-label">Código</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="codCard" name="codCard" placeholder="Tres dígitos" required />
                </div>
            </div>
            <!-- Cantidad de créditos -->
            <div class="form-group">
			  <label for="cantCredReq" class="col-sm-2 control-label">Cantidad</label>
				<div class="col-sm-10">
					<select class="selectpicker" id="cantCredReq" name="cantCredReq" required >
						<option id="0"> </option>
  						<option id="1">1</option>
					</select>
                </div>
            </div>
             
         	<!-- Botones del formulario -->
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">                                  
                  <input type="submit" class="btn btn-primary" value="Comprar">
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
<?php 
} else {
	header("location:../login/login.php");
}
?>