<?php
session_start();
if ($_SESSION['logged']) {
	require '../../config/doctrine_config.php';
	$favors = $entityManager->getRepository("Favor")->findBy(array(),array('deadline'=>'ASC')); ?>
	<!DOCTYPE html>
		<html>
		<head>
		<title>Una Gauchada - Listado</title>
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
		  	?>
			<div class="jumbotron">
				<div class="panel panel-default index">
				<!-- Titulo de la seccion -->
					<div class="panel-heading">
            <a class="btn btn-primary pull-right" href="new.php" style="line-height: 1">
              <span class="glyphicon glyphicon-plus-sign"></span> Nueva Gauchada
            </a>
            <h3 class="panel-title">Listado de gauchadas</h3>            	          			
					</div>
					<div class="panel-body">
            <?php if(count($favors) > 0): ?>
              <div class="table-responsive">
                <table class="table table-hover favorList">
                  <tr>
                    <th>Imagen</th>
                    <th>T&iacute;tulo</th>
                    <th>Ciudad</th>
                    <th>Fecha l&iacute;mite</th>
                    <th>Due&ntilde;o</th>
                  </tr>
                <?php
                  foreach ($favors as $favor) { ?>
                   <tr>
                    <td>
                      <a href="show.php?id=<?php echo  $favor->getId();?>">
                        <?php 
                        if ($favor->getPhoto()) {?>
                        <img alt="<?php echo $favor->getTitle();?>" src="../uploads/<?php echo $favor->getPhoto() ?>" class="img-circle">
                        <?php } else {?>
                          <img alt="<?php echo $favor->getTitle();?>" src="<?php echo $cfg->wwwRoot;?>/src/images/logo-gauchada.png" class="img-circle"/>
                        <?php }
                        ?>
                      </a>
                    </td>
                    <td><a href="show.php?id=<?php echo  $favor->getId();?>"><?php echo $favor->getTitle();?></a></td>
                    <td><?php echo $favor->getCity();?></td>
                    <td><?php echo $favor->getDeadline()->format("d/m/Y");?></td>
                    <td><?php echo $favor->getOwner() ?></td>
                  </tr>
                  <?php }; ?>
                </table>
              </div>
            <?php else: ?>
            <p style="font-size: 16px;">No hay favores publicados.</p>
            <?php endif;?>
					</div>        
				</div>
			</div>
	    </div>
	  </body>    
	</html>
	<?php
} else {
	header("location:../login/login.php");
}