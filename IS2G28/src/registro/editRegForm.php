<?php
session_start();
if ($_SESSION['logged']) { ?>
<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Registro de usuarios</title>
	<?php require '../common/common_headers.php' ;?>
	<script type="text/javascript">
			//Validaciones en cliente
			$(document).ready(function() {
				$('#optradio').click(function(){
					if ($("#optradio").is(':checked')) {
						$("#userPhoto").attr('disabled', true);
					} else{ 
							$("#userPhoto").removeAttr('disabled');
					}
				});
				$('#reg-form').on('submit', function() {
					var nom = $('#name').val();
					if (hasNumbers(nom)) {
						$("<div class='alert alert-danger'></div>").html("Debes ingresar un nombre v&aacute;lido").appendTo(".name");
						$(".alert").delay(3000).fadeOut('slow');
						return false;
					}
					var ape = $('#lastname').val();
					if (hasNumbers(ape)) {
						$("<div class='alert alert-danger'></div>").html("Debes ingresar un apellido v&aacute;lido").appendTo(".lastname");
						$(".alert").delay(3000).fadeOut('slow');
						return false;
					}
					var tel = $('#phone').val();
					if (isNaN(tel)) {
						$("<div class='alert alert-danger'></div>").html("Debes ingresar s&oacute;lo n&oacute;meros").appendTo(".phone");
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
		$user= $entityManager->find('User',$_SESSION['userId']);
		?> 
      	<div class="panel panel-default editR">
        	<div class="panel-heading">
          	  <!-- Encabezado del formulario -->
          	  <h3 class="panel-title">Edici&oacute;n de usuario<img src="../images/logo-gauchada.png"/></h3>
			</div>
        <div class="panel-body">
        <!-- Formulario de edición de usuario -->
          <form class="form-horizontal" method="post" action="editReg.php" id="reg-form" enctype="multipart/form-data">
          	<!-- Foto del usuario -->
            <div class="form-group usPh <?php echo isset($errors['photo'])?'has-error':'' ?>">
            	<div class="imgUs">
            	<label for="userPhoto" class="col-sm-4 labelImg">
            	<?php if ($user->getPhoto()){ ?>
           		<img class="media-object img-rounded user-photo" 
           		src="../uploads/<?php echo $user->getPhoto() ?>" 
                alt="<?php echo $user->getPhoto() ?>">
              	<?php } else{ ?>
                	<img class="media-object img-rounded user-photo" 
                   	src="../images/profile.jpeg" 
                   	alt="Imagen de favor">
              		<?php }?>
                  </label>
              	</div>
              	<div class="col-sm-8 imgCharger">
              		<p>Pod&eacute;s seleccionar una imagen de perfil</p> 
              		<span><small>El tamaño m&aacute;ximo de la imagen es 1MB</small></span>
              		<input class="btn" type="file" id="userPhoto" name="userPhoto">
              		<?php if ($user->getPhoto()){ ?>
              		<label><input type="checkbox" name="optradio" id="optradio"> Quiero eliminar mi imagen</label>
              		<?php } ?>
                	<!-- Contenedor del mensaje de error -->
                	<span class="error help-block <?php echo isset($errors['photo'])?'shown':'hidden' ?>">
                	<?php echo isset($errors['photo'])?$errors['photo']:'' ?>
                	</span>                    
             	</div>
            </div>
            <!-- Nombre del usuario -->
			<div class="form-group name">
			  <label for="name" class="col-sm-2 control-label">Nombre</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" value="<?php echo $user->getName();?>" required />
			  	</div>
			</div>
            <!-- Apellido del usuario -->
            <div class="form-group lastname">
			  <label for="lastname" class="col-sm-2 control-label">Apellido</label>
				<div class="col-sm-10">
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user->getLastname();?>" required />
                </div>
            </div>
            <!-- Email del usuario -->
            <div class="form-group mail">
			  <label for="mail" class="col-sm-2 control-label">E-mail</label>
              	<div class="col-sm-10">
					<p class="mailF" id="mailF"> <?php echo $user->getMail(); ?> </p>
                </div>
            </div>
            <!-- Teléfono del usuario -->
            <div class="form-group phone">
			  <label for="phone" class="col-sm-2 control-label">Tel&eacute;fono</label>
				<div class="col-sm-10">
					<input type="tel" class="form-control" id="phone" name="phone" placeholder="S&oacute;lo n&uacute;meros" value="<?php echo $user->getPhone();?>" required />
                </div>
            </div>
            <!-- Contraseña del usuario -->
            <div class="form-group">
			  <label for="password" class="col-sm-2 control-label">Clave</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password" name="password" placeholder="Ingres&aacute; tu clave para enviar los datos" required />
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
<?php 
} else {
	header("location:../login/login.php?message=accessDenied");
}
?>