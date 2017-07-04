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
		<?php include '../common/sidebar.php'; 
		if (!isset($_GET['order'])) {
			$postulations = $user->getMyPostulations();
			$order = 'ASC';
		} else { 
			$qb = $entityManager->createQueryBuilder();
			$qb->select('p')
			->from('Postulation', 'p')
			->where('p.user = :user')
			->setParameter('user', $user);
			if ($_GET['order'] === 'ASC') {
				$qb->orderBy('p.status','ASC');
				$order = 'DESC';
			} else {
				$qb->orderBy('p.status','DESC');
				$order = 'ASC';
			}
			$query = $qb->getQuery();
			$query->execute();
			$postulations = $query->getResult();
		}?>
		<div class="infoContainer" id="myFavors">
			<h3>Mis Gauchadas</h3>
			<table id="favorsList" class="table table-sm table-hover">
				<tr>
					<th class="col-sm-2">
						T&iacute;tulo
					</th>
					<th class="col-sm-6">
						Comentario
					</th>
					<th class="col-sm-2">
						<a href="myPostulations.php?order=<?php echo $order; ?>">Estado</a>
					</th>
				</tr>
				<?php
				foreach ($postulations as $postulation) {?>
				<tr>
					<td class="col-sm-2">
						<a href="../favors/show.php?id=<?php echo $postulation->getFavor()->getId(); ?>"><?php echo $postulation->getFavor(); ?></a>
					</td>
					<td class="col-sm-6">
						<?php echo $postulation->getComment(); ?>
					</td>
					<td class="col-sm-2">
						<?php echo $postulation->getStatus(); ?>
					</td>
				</tr>
				<?php } ?>
			</table>
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