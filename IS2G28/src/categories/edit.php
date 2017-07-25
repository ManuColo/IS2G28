<?php 
if (!isset($_SESSION)){ 
	session_start();
}
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	require_once __DIR__.'/../common/lib.php';
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
			$editedCategory = $entityManager->find('Category',$_POST['id']);
			if (count($newCategory) === 0 || $editedCategory->getName() === $_POST['name']) {
				if ($editedCategory->getName() === $_POST['name']) {
					$changed = False;
					addMessage('info','No se realiz&oacute; ning&uacute;n cambio');
					showMessage();
				} else {
					$editedCategory->setName($_POST['name']);
					$entityManager->persist($editedCategory);
					$entityManager->flush();
					$changed = True;
					addMessage('success','Categor&iacute;a actualizada');
					showMessage();
				}
			} else {
				$changed = False;
				addMessage('danger','La categor&iacute;a ya existe');
				showMessage();
			}
			$categories= $entityManager->getRepository('Category')->findAll(array(),array('name'=>'DESC'));
			foreach ($categories as $category) { ?>
			<tr>
			<?php if ($category->getName()!=="Varios") { 
					if ($changed) {?>
				<td><?php echo $category->getName();?></td>
				<td class="actions" id="<?php echo $category->getId(); ?>">
					<img alt="Editar" title="Editar" src="<?php echo $cfg->wwwRoot;?>/src/images/edit.png"/>
					<img class="delete" src="<?php echo $cfg->wwwRoot;?>/src/images/delete.png"/>
					<?php } else {
						if ($category->getId() == $_POST['id']) {?>
					<td><input type="text" id="newName" value="<?php echo $_POST['name'];?>" /></td>
					<td class="actions" id="<?php echo $category->getId(); ?>">
						<img alt="Finalizar" title="Finalizar" src="<?php echo $cfg->wwwRoot;?>/src/images/accept.png"/>
						<img alt="Cancelar" title="Cancelar" src="<?php echo $cfg->wwwRoot;?>/src/images/back.png"/>
					<?php } else { ?>
					<td><?php echo $category->getName();?></td>
					<td class="actions" id="<?php echo $category->getId(); ?>">
						<img alt="Editar" title="Editar" src="<?php echo $cfg->wwwRoot;?>/src/images/edit.png"/>
						<img class="delete" src="<?php echo $cfg->wwwRoot;?>/src/images/delete.png"/>
					<?php }
					}?>
			<?php } else { ?>
				<td><?php echo $category->getName();?></td>
				<td>
			<?php } ?>
				</td>
			</tr>
			<?php
			}
		} elseif (isset($_POST['id'])) {
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
					<img class="delete" src="<?php echo $cfg->wwwRoot;?>/src/images/delete.png"/>
			<?php }
			} else { ?>
				<td><?php echo $category->getName();?></td>
				<td>
			<?php }?>
				</td>
			</tr>
			<?php
			}
		
		} else {
			$categories= $entityManager->getRepository('Category')->findAll(array(),array('name'=>'DESC'));
			foreach ($categories as $category) { ?>
			<tr>
			<?php if ($category->getName()!=="Varios") { ?>
				<td><?php echo $category->getName();?></td>
				<td class="actions" id="<?php echo $category->getId(); ?>">
					<img alt="Editar" title="Editar" src="<?php echo $cfg->wwwRoot;?>/src/images/edit.png"/>
					<img class="delete" src="<?php echo $cfg->wwwRoot;?>/src/images/delete.png"/>
			<?php } else { ?>
				<td><?php echo $category->getName();?></td>
				<td>
			<?php }?>
				</td>
			</tr>
			<?php
			}
		} ?>
		</table>
	<?php } else {
		addMessage('danger','Ten&eacute;s que ser administrador para acceder');
		showMessage();
	}
} else {
	addMessage("danger","Ten&eacute;s que iniciar sesi&oacute;n para continuar");
	showMessage();
} ?>