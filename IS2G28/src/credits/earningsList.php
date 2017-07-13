<?php
session_start();
if ($_SESSION['logged']) {
		?>
		<!DOCTYPE html>
			<html>
			<head>
			<title>Una Gauchada - Ganancias</title>
			<?php require '../common/common_headers.php' ; ?>
			<script type="text/javascript" src="../js/search.js"></script>
		  </head>
		  <body>
			<!-- Contenedor principal, requerido por Bootstrap -->	
			<div class="container">
				<div id=header>
					<img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
				</div>
			  	<?php 	
				include('../common/menu.php');
				if ($user->getIsAdmin()) {
					require '../../config/doctrine_config.php';
					$credits= $entityManager->getRepository('Credit')->findBy(array(),array('id'=>'DESC'));
			  	?>
				<div class="jumbotron">
					<div class="panel panel-default index">
					<!-- Titulo de la seccion -->
						<div class="panel-heading">
	            <h3 class="panel-title">Listado de ganancias</h3>            	          			
						</div>
						<div class="panel-body">
	            <?php if(count($credits) > 0): ?>
	              <div class="table-responsive">
	                <table class="table table-hover usersList">
	                  <tr>
	                    <th>Usuario</th>
	                    <th>Fecha</th>
	                    <th>Cr&eacute;ditos</th>
	                    <th>Precio</th>
	                  </tr>
	                <?php
	                  foreach ($credits as $credit) { ?>
	                   <tr>
	                    <td><a href="../profile/public.php?idUs=<?php echo  $credit->getUserId();?>"><?php echo $credit->getUserId();?></a></td>
	                    <td><?php echo $credit->getOperationDate()->format("d/m/Y");?></td>
	                    <td><?php echo $credit->getCantidad();?></td>
	                    <td>$ <?php $amount=$credit->getAmount();
	                    	echo number_format($amount,2,',','.'); ?>
	                    </td>
	                  </tr>
	                  <?php }; ?>
	                </table>
	              </div>
	            <?php else: ?>
	            <p style="font-size: 16px;">No se encontraron ganancias.</p>
	            <?php endif;?>
						</div>        
					</div>
				</div>
		    </div>
		  </body>    
		</html>
		<?php
	} else {
		addMessage('danger','Ten&eacute;s que ser administrador para acceder');
		header("location:../favors/list.php");
	}
} else {
	header("location:../login/login.php?message=accessDenied");
}