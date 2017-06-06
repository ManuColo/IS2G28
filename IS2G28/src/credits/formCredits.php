<?php 
session_start();
if ($_SESSION['logged']) { ?>
<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Obtener cr&eacute;ditos</title>
	<?php require '../common/common_headers.php' ;?>
	<script src="moment.min.js"></script>
	<script type="text/javascript">		
		//Validaciones en cliente
		$(document).ready(function() {
			$('#formCredits').on('submit', function() {
				var owner = $('#titCard').val();
				if (hasNumbers(owner)) {
					$("<div class='alert alert-danger'></div>").html("Debe ser el titular que figura en la tarjeta").appendTo(".cardOwner");
					$(".alert").delay(3000).fadeOut('slow');
					return false;
				}
				var cardNumber = $('#numCard').val();
				if (isNaN(cardNumber) || (cardNumber.length != 16)) {
					$("<div class='alert alert-danger'></div>").html("Deben ser los diecis&eacute;is d&iacute;gitos del frente").appendTo(".cardNumber");
					$(".alert").delay(3000).fadeOut('slow');
					return false;
				}
				var securityCode = $('#codCard').val();
				if (isNaN(securityCode) || (securityCode.length != 3)) {
					$("<div class='alert alert-danger'></div>").html("Deben ser los tres d&iacute;gitos del dorso").appendTo(".securityCode");
					$(".alert").delay(3000).fadeOut('slow');
					return false;
				}
				var em = $('#cardE').val();
				var ven = $('#cardV').val();
				if (em > ven) {
					$("<div class='alert alert-danger'></div>").html("Revis&aacute; las fechas").appendTo(".cardE");
					$(".alert").delay(3000).fadeOut('slow');
					$("<div class='alert alert-danger'></div>").html("Revis&aacute; las fechas").appendTo(".cardV");
					$(".alert").delay(3000).fadeOut('slow');
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
		include('../common/menu.php');	
	  	?> 
      	<div class="panel panel-default login">
        	<div class="panel-heading">
          	  <!-- Encabezado del formulario -->
          	  <h3 class="panel-title">Obtener cr&eacute;ditos<img src="../images/logo-gauchada.png"/></h3>
			</div>
        <div class="panel-body">
        <!-- Formulario de solicitud de crédito -->
          <form class="form-horizontal" id="formCredits" method="post" action="reqCredits.php">
			<!-- Tarjeta -->
			<div class="form-group">
			  <label for="card" class="col-sm-2 control-label">Tarjeta</label>
				<div class="col-sm-10">
					<select class="selectpicker" id="card" name="card" required >
						<option id="0" selected="true" disabled="disabled"> Seleccion&aacute; </option>
						<option id="V">VISA</option>
						<option id="M">MASTERCARD</option>
					</select>
			  	</div>
			</div>
			<!-- Titular de la tarjeta -->
            <div class="form-group cardOwner">
			  <label for="titCard" class="col-sm-2 control-label">Titular</label>
              	<div class="col-sm-10">
					<input type="text" class="form-control" id="titCard" name="titCard" placeholder="Titular de la tarjeta" required />
                </div>
            </div>
            <!-- Número -->
            <div class="form-group cardNumber">
			  <label for="numCard" class="col-sm-2 control-label">N&uacute;mero</label>
              	<div class="col-sm-10">
					<input type="text" class="form-control" id="numCard" name="numCard" placeholder="Sólo números" size="16" required />
                </div>
            </div>
            <!-- Fecha de Emisión -->
            <div class="form-group cardE">
			  <label for="cardE" class="col-sm-2 control-label">Emisi&oacute;n</label>
              	<div class="col-sm-10">
					<input type="date" class="form-control dateSelector" id="cardE" name="cardE" 
							data-provide="datepicker" data-date-format="mm/yy" 
                           	data-date-autoclose="true" placeholder="Fecha de emisión mm/yy" required />
                </div>
            </div>
            <!-- Fecha de Vencimiento -->
            <div class="form-group cardV">
			  <label for="cardV" class="col-sm-2 control-label">Vencim.</label>
              	<div class="col-sm-10">
					<input type="date" class="form-control dateSelector" id="cardV" name="cardV" 
							data-provide="datepicker" data-date-format="mm/yy" 
                           	data-date-autoclose="true" placeholder="Fecha de vencimiento mm/yy" required />
                </div>
            </div>
            <script type="text/javascript">
            $(".dateSelector").datepicker( {
    		    format: "mm/yy",
    		    startView: "months", 
    		    minViewMode: "months"
    		});
            </script>
            <!-- Código de seguridad -->
            <div class="form-group securityCode">
			  <label for="codCard" class="col-sm-2 control-label">C&oacute;digo</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="codCard" name="codCard" placeholder="Tres dígitos" size="3" required />
                </div>
            </div>
            <!-- Cantidad de créditos -->
            <div class="form-group">
			  <label for="cantCredReq" class="col-sm-2 control-label">Cantidad</label>
				<div class="col-sm-10">
					<select class="selectpicker" id="cantCredReq" name="cantCredReq" required >
  						<option id="1" selected>1</option>
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