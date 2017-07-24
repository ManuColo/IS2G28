<?php 
if (!isset($_SESSION)){ 
	session_start();
}
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	$user= $entityManager->find('User',$_SESSION['userId']);
	if ($user->getIsAdmin()) { ?>
		<table class="table table-hover categoryList">
			<tr>
				<th>Nombre</th>
				<th>Acciones</th>
			</tr>
		<?php
		if (isset($_POST['name'])) {
			$newCategory = $entityManager->getRepository('Category')->findBy(array('name'=>$_POST['name']));
			if (count($newCategory) === 0) {
				$editedCategory = $entityManager->find('Category',$_POST['id']);
				$editedCategory->setName($_POST['name']);
				$entityManager->persist($editedCategory);
				$entityManager->flush();
			}
			$categories= $entityManager->getRepository('Category')->findAll(array(),array('name'=>'DESC'));
			foreach ($categories as $category) { ?>
			<tr>
			<?php if ($category->getName()!=="Varios") { ?>
				<td><?php echo $category->getName();?></td>
				<td class="actions" id="<?php echo $category->getId(); ?>">
					<img alt="Editar" title="Editar" src="<?php echo $cfg->wwwRoot;?>/src/images/edit.png"/>
					<img alt="Eliminar" title="Eliminar" src="<?php echo $cfg->wwwRoot;?>/src/images/delete.png"/>
			<?php } else { ?>
				<td><?php echo $category->getName();?></td>
				<td>
			<?php } ?>
				</td>
			</tr>
			<?php
			}
		} else {
			$categories= $entityManager->getRepository('Category')->findAll(array(),array('name'=>'DESC'));
			foreach ($categories as $category) { ?>
			<tr>
			<?php if ($category->getName()!=="Varios") { 
				if ($category->getId() == $_POST['id']) {?>
				<td><input type="text" id="newName" value="<?php echo $category->getName();?>" /></td>
				<td class="actions" id="<?php echo $category->getId(); ?>">
					<img alt="Finalizar" title="Finalizar" src="<?php echo $cfg->wwwRoot;?>/src/images/accept.png"/>
					<img alt="Cancelar" title="Cancelar" src="<?php echo $cfg->wwwRoot;?>/src/images/back.png"/>
				<?php } else { ?>
				<td><?php echo $category->getName();?></td>
				<td class="actions" id="<?php echo $category->getId(); ?>">
					<img alt="Editar" title="Editar" src="<?php echo $cfg->wwwRoot;?>/src/images/edit.png"/>
					<img alt="Eliminar" title="Eliminar" src="<?php echo $cfg->wwwRoot;?>/src/images/delete.png"/>
			<?php }
			} else { ?>
				<td><?php echo $category->getName();?></td>
				<td>
			<?php }?>
				</td>
			</tr>
			<?php
			}; ?>
		</table>
		<script type="text/javascript">
			loadActions();
		</script>
	<?php }
	}
}
?>