<?php 
if (!isset($_SESSION)){ 
	session_start();
}
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	$user= $entityManager->find('User',$_SESSION['userId']);
	if ($user->getIsAdmin()) {
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
				<img alt="Eliminar" title="Eliminar" src="<?php echo $cfg->wwwRoot;?>/src/images/delete.png"/>
			<?php }
			}?>
			</td>
		</tr>
		<?php }; ?>
		</table>
	<?php }
}
?>