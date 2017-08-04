<?php
session_start();
if ($_SESSION['logged']) {
		?>
		<!DOCTYPE html>
			<html>
			<head>
			<title>Una Gauchada - Usuarios</title>
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
					$users= $entityManager->getRepository('User')->findBy(array(),array('reputation'=>'DESC'));
			  	?>
				<div class="jumbotron">
					<div class="panel panel-default index">
					<!-- Titulo de la seccion -->
						<div class="panel-heading">
	            <h3 class="panel-title">Listado de usuarios</h3>            	          			
						</div>
						<div class="panel-body">
	            <?php if(count($users) > 0): ?>
	              <div class="table-responsive">
	                <table class="table table-hover usersList">
	                  <tr>
	                    <th>Imagen</th>
	                    <th>Nombre</th>
	                    <th>Mail</th>
	                    <th>Reputaci&oacute;n</th>
	                  </tr>
	                <?php
	                  foreach ($users as $userList) { ?>
	                   <tr>
	                    <td>
	                      <a href="../profile/public.php?idUs=<?php echo  $userList->getId();?>">
	                        <?php 
	                        if ($userList->getPhoto()) {?>
	                        <img alt="<?php echo $$userList;?>" src="../uploads/<?php echo $userList->getPhoto() ?>" class="img-circle">
	                        <?php } else {?>
	                          <img alt="<?php echo $userList;?>" src="<?php echo $cfg->wwwRoot;?>/src/images/logo-gauchada.png" class="img-circle"/>
	                        <?php }
	                        ?>
	                      </a>
	                    </td>
	                    <td><a href="../profile/public.php?idUs=<?php echo  $userList->getId();?>"><?php echo $userList;?></a></td>
	                    <td><?php echo $userList->getMail();?></td>
                      <?php $userReputation = $entityManager->getRepository('Reputation')->getReputationFromScore($userList->getReputation()) ?>
                      <td>
                        <span class="label label-default"><?php echo $userReputation->getName() ?></span>
                      </td>
	                  </tr>
	                  <?php }; ?>
	                </table>
	              </div>
	            <?php else: ?>
	            <p style="font-size: 16px;">No se encontraron usuarios.</p>
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