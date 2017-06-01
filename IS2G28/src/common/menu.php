<ul class="nav nav-pills pull-right">
<?php
if (isset($_SESSION['logged'])) {
	if($_SESSION['logged']== true){ ?>
		<li class="active"><a href="<?php echo $cfg->wwwRoot;?>/src">Inicio</a></li>
		<li><a href="<?php echo $cfg->wwwRoot;?>/src/favors/list.php">Favores</a></li>
		<li><a href="<?php echo $cfg->wwwRoot;?>/src/credits/formCredits.php">Cr&eacute;ditos</a></li>
		<li><a href="<?php echo $cfg->wwwRoot;?>/src/login/logout.php">Cerrar Sesión</a></li>
	<?php } 
} else { ?>
	<li class="active"><a href="<?php echo $cfg->wwwRoot;?>/src">Inicio</a></li>
	<li><a href="<?php echo $cfg->wwwRoot;?>/src/login/login.php">Iniciar Sesión</a></li>
	<li><a href="<?php echo $cfg->wwwRoot;?>/src/registro/registro.php">Registrate</a></li>
<?php }?>
</ul>