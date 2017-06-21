<?php
var_dump($_POST);
session_start();
if ($_SESSION['logged']) {
	require '../../config/doctrine_config.php';
	$today = new DateTime();
	$qb = $entityManager->createQueryBuilder();
	$qb->select('f')
	->from('Favor', 'f')
	->where('f.deadline >= :today')
	->orderBy('f.deadline','ASC')
	->setParameter('today', $today);
	if ($_POST){
		
	}
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
	<?php }?>
	exit;
}