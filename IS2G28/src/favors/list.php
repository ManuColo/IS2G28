<?php
session_start();
if ($_SESSION['logged']) {
	require '../../config/doctrine_config.php';
	$today = new DateTime();
	$qb = $entityManager->createQueryBuilder();
	$qb->select('f, count(p) as HIDDEN cont')
		->from('Favor', 'f')
		->leftJoin('f.myPostulations', 'p')
		->where('f.deadline >= :today')
		->andWhere('f.unpublished != :unpublished')
		->andWhere('f.resolved != :resolved')
		->groupBy('f.id')
		->orderBy('cont','ASC')
		->addOrderBy('f.deadline','ASC')
		->setParameter('today', $today)
		->setParameter('unpublished', True)
		->setParameter('resolved', True);
	$query = $qb->getQuery();
	$query->execute();
	$favors = $query->getResult();
?>
	<!DOCTYPE html>
		<html>
		<head>
		<title>Una Gauchada - Listado</title>
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
              	<table class="table table-hover favorSearch">
	              	<tr>
						<td>
							<span class="badge btn btn-warning submitBuscar">Buscar:</span>
						</td>
	                    <td>
	                    	<input type="text" class="search searchControl" id="searchTitle" name="searchTitle" 
	                        	placeholder="T&iacute;tulo" value="<?php // echo $favor->getTitle() ?>">
						</td>
	                    <td>
	                    	<input type="text" class="search searchControl" id="searchCity" name="searchCity" 
	                        	placeholder="Ciudad" value="<?php // echo $favor->getTitle() ?>">
						</td>
						<td>
							<input type="text" class="search" id="searchDeadline" name="searchDeadline" 
	                        	 value="<?php // echo $favor->getTitle() ?>"
								data-provide="datepicker" data-date-format="dd/mm/yyyy" 
								data-date-autoclose="true" placeholder="Fecha L&iacute;mite">
						</td>
						<td>
	                    	<input type="text" class="search searchControl" id="searchOwner" name="searchOwner" 
	                        	placeholder="Due&ntilde;o" value="<?php // echo $favor->getOwner() ?>">
						</td>
						<td>
							<img class="img-responsive submitBuscar" src="<?php echo $cfg->wwwRoot;?>/src/images/search.jpg"/>
	                    </td>
					</tr>
		        </table>
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
                    <td><a href="../profile/public.php?idUs=<?php echo $favor->getOwner()->getId(); ?>"><?php echo $favor->getOwner() ?></a></td>
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