<?php
session_start();
if ($_SESSION['logged']) {
	?>
		<!DOCTYPE html>
			<html>
			<head>
			<title>Una Gauchada - Categor&iacute;as</title>
			<?php require '../common/common_headers.php' ; ?>
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
					$categories= $entityManager->getRepository('Category')->findAll(array(),array('name'=>'DESC'));
			  	?>
				<div class="jumbotron">
					<div class="panel panel-default index">
					<!-- Titulo de la seccion -->
						<div class="panel-heading">
	            <h3 class="panel-title">Listado de categor&iacute;as</h3>            	          			
						</div>
						<div class="panel-body">
	            <?php if(count($categories) > 0): ?>
	              <div class="table-responsive">
	                <table class="table table-hover usersList">
	                  <tr>
	                    <th>Nombre</th>
	                    <th>Acciones</th>
	                  </tr>
	                <?php
	                  foreach ($categories as $category) { ?>
	                   <tr>
	                    <td><?php echo $category->getName();?></td>
	                    <td></td>
	                  </tr>
	                  <?php }; ?>
	                </table>
	              </div>
	            <?php else: ?>
	            <p style="font-size: 16px;">No se encontraron categor&iacute;as.</p>
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