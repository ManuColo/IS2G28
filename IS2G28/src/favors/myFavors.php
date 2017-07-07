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
	//Menú de usuario
	include '../common/sidebar.php'; ?>
    <div class="jumbotron" id="profileJumb">
		<div class="infoContainer" id="myFavors">
		<?php if ($user->getMyFavors()->count() > 0 ) {?>
			<h3>Mis Gauchadas</h3>
			<table id="favorsList" class="table table-sm table-hover">
				<tr>
					<th class="col-sm-2">
						T&iacute;tulo
					</th>
					<th class="col-sm-6">
						Descripci&oacute;n
					</th>
					<th class="col-sm-2">
						Postulantes
					</th>
					<th class="col-sm-2">
						Estado
					</th>
				</tr>
				<?php foreach ($user->getMyFavors() as $favor) {?>
				<tr>
					<td class="col-sm-2">
						<a href="show.php?id=<?php echo $favor->getId(); ?>"><?php echo $favor; ?></a>
					</td>
					<td class="col-sm-6">
						<?php echo $favor->getDescription(); ?>
					</td>
					<td class="col-sm-2">
						<?php echo $favor->getMyPostulations()->count(); ?>
					</td>
					<td class="col-sm-2">
						<?php echo $favor->getStatus(); ?>
					</td>
				</tr>
				<?php } ?>
			</table>
		<?php } else { ?>
			<h3>No ten&eacute;s gauchadas pedidas</h3>
		<?php } ?>
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