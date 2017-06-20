<?php
require_once substr(__DIR__,0,-11).'/config/doctrine_config.php';
require_once 'lib.php';

$uri = "http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
$string = "/src/";
$max = strlen($uri);
$result = strpos($uri, $string);
$firstReduction = substr($uri, $result + 5, $max);
$string = "/";
$max = strlen($firstReduction);
$result = strpos($firstReduction, $string);
$selected = substr($firstReduction, 0 , -($max - $result));
?>
<nav>
	 <?php if (isset($_SESSION['logged']) && $_SESSION['logged']){?>
	 <div class="dropdown">
  		<button class="btn btn-link dropdown-toggle" 
  		type="button" data-toggle="dropdown">
  		<p>Usuario: <?php 
  		$user= $entityManager->find('User',$_SESSION['userId']);
  		echo $user->getName();
  		?>
  		<span class="caret"></span></p></button>
  			<ul class="dropdown-menu">
  				<li><a href="#">Cr&eacute;ditos &nbsp;
  					<span class="badge"> 
  					<?php
  					if($user->getCantCredits()== 0){ 
  						echo 0;
  					} else { 
  						echo $user->getCantCredits();}?> 
  					</span></a><br>
  				</li>
  			</ul>
	</div> 
	<?php }?>
	<ul class="nav nav-pills pull-right">
	<?php
	if (isset($_SESSION['logged'])) {
		if($_SESSION['logged']== true){ ?>
			<li <?php if ($selected == '') { ?>class="active"<?php } ?>><a href="<?php echo $cfg->wwwRoot;?>/src">Inicio</a></li>
			<li <?php if ($selected == 'favors') { ?>class="active"<?php } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/favors/list.php">Gauchadas</a></li>
			<li <?php if ($selected == 'credits') { ?>class="active"<?php } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/credits/formCredits.php">Cr&eacute;ditos</a></li>
			<li><a href="<?php echo $cfg->wwwRoot;?>/src/login/logout.php">Cerrar Sesi&oacute;n</a></li>
		<?php } 
	} else { ?>
		<li <?php if ($selected == '') { ?>class="active"<?php } ?>><a href="<?php echo $cfg->wwwRoot;?>/src">Inicio</a></li>
		<li <?php if ($selected == 'login') { ?>class="active"<?php } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/login/login.php">Iniciar Sesi&oacute;n</a></li>
		<li <?php if ($selected == 'registro') { ?>class="active"<?php } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/registro/registro.php">Registrate</a></li>
	<?php }?>
	</ul>
</nav>
<?php showMessage()?>