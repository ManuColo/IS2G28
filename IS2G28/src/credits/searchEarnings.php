<?php
require '../common/lib.php';
session_start();
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	$user= $entityManager->find('User',$_SESSION['userId']);
	if ($user->getIsAdmin()) {
	$today = new DateTime();
	$qb = $entityManager->createQueryBuilder();
	$qb->select('c, count(e) as HIDDEN cont')
	->from('Credit', 'c')
	->join('c.userId','u')
	->leftJoin('u.myCredits', 'e')
	->where('c.operationDate <= :today')
	->setParameter('today', $today);
	if ($_POST['user'] != ''){
		$qb->andWhere(
				$qb->expr()->like('u.mail',':user')
				)
				->setParameter('user', '%'.$_POST['user'].'%');
	}
	if ($_POST['dateIn'] != ''){
		$dateIn = DateTime::createFromFormat('d/m/Y',$_POST['dateIn']);
		$qb->andWhere('c.operationDate >= :dateIn')
		->setParameter('dateIn', $dateIn);
	}
	if ($_POST['dateEnd'] != ''){
		$dateEnd = DateTime::createFromFormat('d/m/Y',$_POST['dateEnd']);
		$qb->andWhere('c.operationDate <= :dateEnd')
		->setParameter('dateEnd', $dateEnd);
	}
	$qb->groupBy('c.id')
	->orderBy('c.id','ASC')
	->addOrderBy('c.operationDate','ASC');
	$query = $qb->getQuery();
	$query->execute();
	$credits = $query->getResult();
	if (count($credits) > 0) { ?>
	<table class="table table-hover earningsList">
		<tr>
			<th>Usuario</th>
			<th>Fecha</th>
			<th>Cr&eacute;ditos</th>
			<th>Precio</th>
		</tr>
		<?php foreach ($credits as $credit) { ?>
		<tr>
			<td><?php echo $credit->getUserId()->getMail();?></td>
			<td><?php echo $credit->getOperationDate()->format("d/m/Y");?></td>
			<td><?php echo $credit->getCantidad();?></td>
			<td>$ <?php $amount=$credit->getAmount();
	              echo number_format($amount,2,',','.'); ?>
	        </td>
		</tr>
       	<?php }; ?>
	</table>
	<?php } else { ?>
	<p style="font-size: 16px;">No hay cr&eacute;ditos que cumplan con el criterio.</p>
	<?php }
	exit;
  } else {
	addMessage('danger','Ten&eacute;s que ser administrador para acceder');
	header("location:../favors/list.php");
  }
} else {
	header("location:../login/login.php?message=accessDenied");
}