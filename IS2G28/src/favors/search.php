<?php
session_start();
if ($_SESSION['logged']) {
	require '../../config/doctrine_config.php';
	$today = new DateTime();
	$qb = $entityManager->createQueryBuilder();
	$qb->select('f, count(p) as HIDDEN cont')
	->from('Favor', 'f')
	->leftJoin('f.myPostulations', 'p')
	->join('f.owner','u')
	->where('f.deadline >= :today')
	->andWhere('f.unpublished != :unpublished')
	->setParameter('today', $today)
	->setParameter('unpublished', True);
	if ($_POST['title'] != ''){
		$qb->andWhere(
				$qb->expr()->like('f.title',':title')
			)
		->setParameter('title', '%'.$_POST['title'].'%');
	}
	if ($_POST['city'] != ''){
		$qb->andWhere(
				$qb->expr()->like('f.city',':city')
			)
			->setParameter('city', '%'.$_POST['city'].'%');
	}
	if ($_POST['deadline'] != ''){
		$deadline = DateTime::createFromFormat('d/m/Y',$_POST['deadline']);
		$qb->andWhere('f.deadline <= :deadline')
		->setParameter('deadline', $deadline);
	}
	if ($_POST['owner'] != ''){
		$qb->andWhere(
			$qb->expr()->orX(
					$qb->expr()->like('u.name',':owner'),
				$qb->expr()->like('u.lastname',':owner')
			)
		)
		->setParameter('owner', '%'.$_POST['owner'].'%');
	}
	
	$qb->groupBy('f.id')
		->orderBy('cont','ASC')
		->addOrderBy('f.deadline','ASC');
	$query = $qb->getQuery();
	$query->execute();
	$favors = $query->getResult();
	if (count($favors) > 0) { ?>
	<table class="table table-hover favorList">
		<tr>
			<th>Imagen</th>
			<th>T&iacute;tulo</th>
			<th>Ciudad</th>
			<th>Fecha l&iacute;mite</th>
			<th>Due&ntilde;o</th>
		</tr>
		<?php foreach ($favors as $favor) { ?>
		<tr>
			<td>
				<a href="show.php?id=<?php echo  $favor->getId();?>">
				<?php if ($favor->getPhoto()) {?>
					<img alt="<?php echo $favor->getTitle();?>" src="../uploads/<?php echo $favor->getPhoto() ?>" class="img-circle">
				<?php } else {?>
					<img alt="<?php echo $favor->getTitle();?>" src="<?php echo $cfg->wwwRoot;?>/src/images/logo-gauchada.png" class="img-circle"/>
				<?php } ?>
				</a>
			</td>
			<td>
				<a href="show.php?id=<?php echo  $favor->getId();?>"><?php echo $favor->getTitle();?></a></td>
			<td><?php echo $favor->getCity();?></td>
			<td><?php echo $favor->getDeadline()->format("d/m/Y");?></td>
			<td><?php echo $favor->getOwner() ?></td>
		</tr>
       	<?php }; ?>
	</table>
	<?php } else { ?>
	<p style="font-size: 16px;">No hay favores publicados que cumplan con el criterio.</p>
	<?php }
	exit;
}