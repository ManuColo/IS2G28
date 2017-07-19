<?php
session_start();
if ($_SESSION['logged']) {
	require '../../config/doctrine_config.php';
	$today = new DateTime();
	$qb = $entityManager->createQueryBuilder();
	$qb->select('c, count(e) as HIDDEN cont')
	->from('Credit', 'c')
	->join('c.userId','u')
	->leftJoin('u.myCredits', 'e')
	->where('c.operationDate <= :today')
	->groupBy('c.id')
	->orderBy('c.id','ASC')
	->addOrderBy('c.operationDate','ASC')
	->setParameter('today', $today);
	$query = $qb->getQuery();
	$query->execute();
	$credits = $query->getResult();?>
		<!DOCTYPE html>
			<html>
			<head>
			<title>Una Gauchada - Ganancias</title>
			<?php require '../common/common_headers.php' ; ?>
			<script type="text/javascript" src="../js/searchEarnings.js"></script>
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
					//require '../../config/doctrine_config.php';
					//$credits= $entityManager->getRepository('Credit')->findBy(array(),array('id'=>'DESC'));
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
					<table class="table table-hover earningsSearch">
	            	  <tr>
						<td>
							<span class="badge btn btn-warning submitBuscar">Buscar:</span>
						</td>
	                	<td>
	                    	<input type="text" class="search searchControl" id="searchUser" name="searchUser" 
	                        	placeholder="Usuario" value="<?php // echo $credit->getUserId()->getMail() ?>">
						</td>
						<td>
							<input type="text" class="search" id="searchDateIn" name="searchDateIn" 
	                        	 value="<?php // echo $credit->getOperationDate() ?>"
								data-provide="datepicker" data-date-format="dd/mm/yyyy" 
								data-date-autoclose="true" placeholder="Fecha Inicial">
						</td>
						<td>
							<input type="text" class="search" id="searchDateEnd" name="searchDateEnd" 
	                        	 value="<?php // echo $credit->getOperationDate() ?>"
								data-provide="datepicker" data-date-format="dd/mm/yyyy" 
								data-date-autoclose="true" placeholder="Fecha Final">
						</td>
						<td>
							<img class="img-responsive submitBuscar" id="sE" src="<?php echo $cfg->wwwRoot;?>/src/images/search.jpg"/>
	                    </td>
					  </tr>
		       		</table>
	            	<table class="table table-hover earningsList">
	                  <tr>
	                    <th>Usuario</th>
	                    <th>Fecha</th>
	                    <th>Cr&eacute;ditos</th>
	                    <th>Precio</th>
	                  </tr>
	                <?php
	                  foreach ($credits as $credit) { ?>
	                   <tr>
	                    <td><?php echo $credit->getUserId()->getMail();?>
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