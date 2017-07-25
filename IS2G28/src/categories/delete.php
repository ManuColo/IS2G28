<?php 
if (!isset($_SESSION)){ 
	session_start();
}
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	require_once __DIR__.'/../common/lib.php';
	$user= $entityManager->find('User',$_SESSION['userId']);
	if ($user->getIsAdmin()) {
		$category = $entityManager->find('Category',$_POST['id']);
		$defautlCategory= $entityManager->getRepository('Category')->findBy(array('name'=>'Varios'))[0];
		if ($category!== $defautlCategory) {
			$favors = $category->getMyFavors();
			if (count($favors) > 0) {
				foreach ($favors as $favor) {
					$favor->setCategory($defautlCategory);
					$entityManager->persist($favor);
				}
			}
			$entityManager->remove($category);
			$entityManager->flush();
			addMessage("success","categor&iacute;a eliminada");
			showMessage();
		}
		$categories= $entityManager->getRepository('Category')->findAll(array(),array('name'=>'DESC')); ?>
		<table class="table table-hover categoryList">
		<tr>
			<th>Nombre</th>
			<th>Acciones</th>
		</tr>
		<?php foreach ($categories as $category) { ?>
		<tr>
			<td><?php echo $category->getName();?></td>
			<td class="actions" id="<?php echo $category->getId(); ?>">
			<?php if ($category->getName()!=="Varios") {
				if ($category->getId() == $_POST['id']) {?>
				<img alt="Finalizar" title="Finalizar" src="<?php echo $cfg->wwwRoot;?>/src/images/accept.png"/>
				<img alt="Cancelar" title="Cancelar" src="<?php echo $cfg->wwwRoot;?>/src/images/back.png"/>
				<?php } else { ?>
				<img alt="Editar" title="Editar" src="<?php echo $cfg->wwwRoot;?>/src/images/edit.png"/>
				<img class="delete" src="<?php echo $cfg->wwwRoot;?>/src/images/delete.png"/>
			<?php }
			}?>
			</td>
		</tr>
		<?php }; ?>
		</table>
	<?php } else {
		addMessage('danger','Ten&eacute;s que ser administrador para acceder');
		showMessage();
	}
} else {
	addMessage("danger","Ten&eacute;s que iniciar sesi&oacute;n para continuar");
	showMessage();
}
?>