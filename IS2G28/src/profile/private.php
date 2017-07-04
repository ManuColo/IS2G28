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
  <div class="container" id="cont">   
	<div id=header>
		<img class="img-responsive" src="../images/header-gauchada.png"/>
	</div>
	<?php 
	include('../common/menu.php');	
	$user= $entityManager->find('User',$_SESSION['userId']);
	
	include '../common/sidebar.php'; 
	?> 
    <div class="jumbotron" id="profileJumb">
		
		<div class="infoContainer">
			<div class="imgUsProf">
				<?php if ($user->getPhoto()){ ?>
						<img class="media-object img-circle userPhoto" src="../uploads/<?php echo $user->getPhoto() ?>" 
						alt="<?php echo $user->getPhoto() ?>">
	              		<?php } else{ ?>
	                			<img class="media-object img-circle userPhoto" src="../images/profile.jpeg" 
	                   	alt="Imagen de favor">
	              		<?php }?>
			</div>
			<div class="margSupD">
				<blockquote>
					<div><p>Tu Reputaci&oacute;n: <?php echo $user->printReputation(); ?> </p></div>
					<div><p>Tus Cr&eacute;ditos: <?php echo $user->getCantCredits();?></p></div>
				</blockquote>
			</div>
	    	<div class="nameProf">
					<img class="logoMin" src="../images/logo-gauchada.png"/>
					<span class="nm"> <?php echo $user->getName();?><span> <?php echo $user->getLastname();?></span></span>
					<img class="logoMin" src="../images/logo-gauchada.png"/>
					<span><b> <?php echo $user->getMail();?></b></span>
			</div>
			<a type="button" id="ret" class="btn btn-primary" onClick="goBack();">Volver</a>
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