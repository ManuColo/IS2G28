<?php
session_start();
if ($_SESSION['logged']) {
	require '../../config/doctrine_config.php';
	if ($user->getIsAdmin()) {
	$today = new DateTime();
	$qb = $entityManager->createQueryBuilder();
	$qb->select('c, count(e) as HIDDEN cont')
	->from('Credit', 'c')
	->leftJoin('c.myCredits', 'e')
	->join('c.userId','u')
	->where('c.id > 0');
	if ($_POST['userId'] != ''){
		$qb->andWhere(
				$qb->expr()->like('u.mail',':userId')
				)
				->setParameter('userId', '%'.$_POST['userId'].'%');
	}
	if ($_POST['operationDate'] != ''){
		$operationDate = DateTime::createFromFormat('d/m/Y',$_POST['operationDate']);
		$qb->andWhere('c.operationDate <= :operationDate')
		->setParameter('operationDate', $operationDate);
	}
	$qb->groupBy('c.id')
	->orderBy('cont','ASC')
	->addOrderBy('c.operationDate','ASC');
	$query = $qb->getQuery();
	$query->execute();
	$credits = $query->getResult();
	if (count($credits) > 0) { ?>
	<table class="table table-hover creditList">
		<tr>
			<th>Usuario</th>
			<th>Fecha</th>
			<th>Cr&eacute;ditos</th>
			<th>Precio</th>
		</tr>
		<?php foreach ($credits as $credit) { ?>
		<tr>
			<td>
				<a href="earningsList.php?id=<?php echo  $credit->getId();?>"><?php echo $credit->getUserId();?></a>
			</td>
			<td><?php echo $credit->getOperationDate();?></td>
			<td><?php echo $credit->getCantidad()->format("d/m/Y");?></td>
			<td><?php echo $credit->getAmount() ?></td>
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