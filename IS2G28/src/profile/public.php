<?php
session_start();
if ($_SESSION['logged']) { ?>
<!DOCTYPE html>
<html>
  <head>
	<title>Una Gauchada - Perfil de Usuario</title>
	<?php require '../common/common_headers.php' ;?>
	<style type="text/css">
    .reputation img {      
      width: 50px;
      height: 50px;
    }
  </style>
  <script type="text/javascript" src="../js/public.js"></script>   
  </head>
  <body>
  <!-- Contenedor principal, requerido por Bootstrap -->
  <div class="container">   
	<div id=header>
		<img class="img-responsive" src="../images/header-gauchada.png"/>
	</div>
	<?php 
	include('../common/menu.php');
	$idUserView= $_GET['idUs'];
	$userView= $entityManager->getRepository('User')->findBy(array('id'=>$idUserView))[0];
  $userReputation = $entityManager->getRepository('Reputation')->getReputationFromScore($userView->getReputation());
  
	?> 
    <div class="jumbotron" id="profileJumb">
		<div class="imgUsChica">
			<?php
			if ($user->getIsAdmin()&& !$userView->getIsAdmin()) { ?>
	            	<button class="btn btn-danger btn-xs pull-right" id="makeAdmin">Nombrar Administrador</button>
	        <?php }
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
			<div>        
        <h4>
          Reputaci&oacute;n del usuario:
          <span class="reputation">
            <span class="label label-default"><?= $userReputation->getName() ?></span>
            <img src="../uploads/<?= $userReputation->getImage() ?>" 
                 alt="Imagen de <?= $userReputation->getName() ?>" class="img-circle">                
          </span>
        </h4>
      </div>
		</div>
		<table class="table table-hover repList">
			<?php if(count($userView->getMyPostulations()) === 0){?> 
				<tr><td colspan="3">A&uacute;n no tiene gauchadas resueltas.</td></tr>
			<?php } else {?>
					<tr class="titleTableRep">
						<th scope="col" width="40%">Favor</th>
						<th scope="col"width="20%">Puntuaci&oacute;n</th>
						<th scope="col"width="40%">Comentario</th>
					</tr>
				<?php $postulations = $userView->getMyPostulations(); 
				foreach ($postulations as $postulation) {?>
				<tr>
				<?php if ($postulation->getStatus() === 'Aceptado'&& $postulation->getFavor()->getPostulantQualification()!= null) {?>
					<th scope="row" ><a href="../favors/show.php?id=<?php echo $postulation->getFavor()->getId(); ?>">
						<?php echo $postulation->getFavor()->getTitle(); ?>
					</a></th>
					<td> 
						<?php echo $postulation->getFavor()->getPostulantQualification();?> 
					</td>
					<td>
						<?php echo $postulation->getFavor()->getPostulantQualification()->getComment();?>
					</td>
				<?php } elseif ($postulation->getStatus() === 'Aceptado' && $postulation->getFavor()->getPostulantQualification()== null) {?>
					<th scope="row" ><a href="../favors/show.php?id=<?php echo $postulation->getFavor()->getId(); ?>">
						<?php echo $postulation->getFavor()->getTitle(); ?>
					</a></th>
					<td colspan="2"> A&uacute;n no ha sido calificado. </td>
				<?php }?>
				</tr>
			<?php }
				}?>
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