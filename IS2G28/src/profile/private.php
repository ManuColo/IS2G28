<?php
session_start();
if ($_SESSION['logged']) { ?>
<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Mi Perfil</title>
	<?php require '../common/common_headers.php' ;?>
	<script type="text/javascript">
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
    <div class="jumbotron" id="profileJumb">
		<!-- Menú del usuario -->
		<nav class="myml-menu-navigation menu-expandable" role="navigation">
			<div class="btn-group-vertical" id="menuPP" role="group">
				<Ul class="nav nav-tabs nav-stacked dropdown-menu-left">                                  
            		<li id="menuEnc" class="nav-header"><p style="margin-bottom: 0px;">Mi Perfil</p></li>
            		<li class="nav-header"><a href="../registro/editRegForm.php">Editar Perfil</a></li>
            		<li class="nav-header"><strong>Gauchadas</strong></li>
            		<li class="nav-header"><a href="#">Mis Gauchadas<b class="glyphicon glyphicon-menu-right" aria-hidden="true"></b></a></li>
            		<li class="nav-header"><a href="#">Mis Postulaciones<b class="glyphicon glyphicon-menu-right" aria-hidden="true"></b></a></li>
            	    <li class="nav-header"><strong>Calificaciones</strong></li>
            	    <li class="nav-header"><a href="#">Mis calificaciones<b class="glyphicon glyphicon-menu-right" aria-hidden="true"></b></a></li>
					<li class="nav-header"><strong>Comentarios</strong></li>
					<li class="nav-header disabled"><a href="#">En mis gauchadas pedidas<b class="glyphicon glyphicon-menu-right" aria-hidden="true"></b></a></li>
					<li class="nav-header disabled"><a href="#">En gauchadas que hice<b class="glyphicon glyphicon-menu-right" aria-hidden="true"></b></a></li>
				</Ul>
			</div>
		</nav>
		<div class="imgUsProf">
			<?php if ($user->getPhoto()){ ?>
					<img class="media-object img-circle userPhoto" src="../uploads/<?php echo $user->getPhoto() ?>" 
					alt="<?php echo $user->getPhoto() ?>">
              		<?php } else{ ?>
                			<img class="media-object img-circle userPhoto" src="../images/profile.jpeg" 
                   	alt="Imagen de favor">
              		<?php }?>
		</div>    
    	<div class="nameProf">
				<img class="logoMin" src="../images/logo-gauchada.png"/>
				<span class="nm"> <?php echo $user->getName();?><span> <?php echo $user->getLastname();?></span></span>
				<img class="logoMin" src="../images/logo-gauchada.png"/>
				<span><b> <?php echo $user->getMail();?></b></span>
		</div>
		<div class="margSupD">
			<blockquote>
				<div><p>Tu Reputaci&oacute;n: <?php echo $user->printReputation(); ?> </p></div>
				<div><p>Tus Cr&eacute;ditos: <?php echo $user->getCantCredits();?></p></div>
			</blockquote>
		</div>
		<a type="button" id="ret" class="btn btn-primary" onClick="goBack();">Volver</a>
	</div>
  </div>		                                         
 </body>    
</html>
<?php 
} else {
	header("location:../login/login.php?message=accessDenied");
}
?>