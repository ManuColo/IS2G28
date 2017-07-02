<?php
session_start();
if ($_SESSION['logged']) { ?>
<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Perfil de Usuario</title>
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
	?> 
    <div class="jumbotron" id="profileJumb">
		<div class="imgUsChica">
			<?php 
			/*if(isset($_GET['idFav'])){
				$fav=$entityManager->getRepository('Favor')->findBy(array('owner_user_id'=>$_GET['idFav']))[0];
				$idUserView=$fav->getOwner();
			} else{
				if(isset($_GET['idUs'])){
					$idUserView= $_GET['id'];
				}
			}*/
			$idUserView= $_GET['idUs'];
			$userView= $entityManager->getRepository('User')->findBy(array('id'=>$idUserView))[0];
			if ($userView->getPhoto()){ ?>
					<img class="media-object img-circle userPhoto" src="../uploads/<?php echo $userView->getPhoto() ?>" 
					alt="<?php echo $userView->getPhoto() ?>">
              		<?php } else{ ?>
                			<img class="media-object img-circle userPhoto" src="../images/profile.jpeg" 
                   	alt="Imagen de favor">
              		<?php }?>
		</div>
		<div class="nameProfPub">
			<h3><img class="logoMin" src="../images/logo-gauchada.png"/>
			<span class="nm"> <?php echo $userView->getName();?><span> <?php echo $userView->getLastname();?></span></span>
			<img class="logoMin" src="../images/logo-gauchada.png"/></h3>
		</div>
		<div class="margSupPub">
			<div><h4>Reputaci&oacute;n del usuario: <?php echo $userView->printReputation(); ?> </h4></div>
		</div>
		<table class="table table-hover repList">
			<tr class="titleTableRep">
				<th>Favor</th>
				<th>Puntuaci&oacute;n</th>
				<th>Comentario</th>
			</tr>
			<?php $postulations = $userView->getMyPostulations(); 			
			foreach ($postulations as $postulation) {?>
				<tr>
				<?php if ($postulation->getStatus() === 'Aceptado') {?>
					<td><a href="../favors/show.php?id=<?php echo $postulation->getFavor()->getId(); ?>">
						<?php echo $postulation->getFavor()->getTitle(); ?>
					</a></td>
					<td> 
						<?php echo $postulation->getFavor()->getPostulantQualification()->getResult();?> 
					</td>
					<td>
						<?php echo $postulation->getFavor()->getPostulantQualification()->getComment();?>
					</td>
				<?php }?>
				</tr>
			<?php } ?>
		</table>
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