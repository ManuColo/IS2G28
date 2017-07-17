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
  				<li class="divider"></li>
  				<li><a href="<?php echo $cfg->wwwRoot;?>/src/profile/private.php">Mi Perfil</a></li>
  			</ul>
	</div> 
	<?php }?>
	<ul class="nav nav-pills pull-right">
	<?php
	if (isset($_SESSION['logged'])) {
		if($_SESSION['logged']== true){ ?>
			<?php if ($user->getIsAdmin()) { ?>
				<li>
				<button class="btn dropdown-toggle" id="btnAdmin" data-toggle="dropdown"> Admin <span class="caret"></span></button>
				<ul class="dropdown-menu">
				<li <?php if ($selected == 'users') { ?>class="active"<?php $referer = $selected.'list.php'; } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/users/list.php">Usuarios</a></li>
				<li <?php if ($selected == 'credits') { ?>class="active"<?php $referer = $selected.'earnings.php'; } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/credits/earningsList.php">Ganancias</a></li>
				</ul>
				</li>
			<?php } ?>
			<li <?php if ($selected == '') { ?>class="active"<?php $referer = $selected.'index.php'; } ?>><a href="<?php echo $cfg->wwwRoot;?>/src">Inicio</a></li>
			<li <?php if ($selected == 'favors') { ?>class="active"<?php $referer = $selected.'/list.php'; } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/favors/list.php">Gauchadas</a></li>
			<li <?php if ($selected == 'credits') { ?>class="active"<?php $referer = $selected.'/formCredits.php'; } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/credits/formCredits.php">Cr&eacute;ditos</a></li>
			<li><a href="<?php echo $cfg->wwwRoot;?>/src/login/logout.php">Cerrar Sesi&oacute;n</a></li>
		<?php
			if ($selected === 'profile') {
				$uri = "http://".$_SERVER["HTTP_REFERER"];
				$string = "/src/";
				$max = strlen($uri);
				$result = strpos($uri, $string);
				$reduction = substr($uri, $result + 5, $max);
				if ($reduction !== 'registro/editRegForm.php') {
					$referer = $reduction;
				}
			}
			
			if ($selected === 'registro') {
				$referer = 'profile/private.php';
			}
		} 
	} else { ?>
		<li <?php if ($selected == '') { ?>class="active"<?php $referer = 'index.php'; } ?>><a href="<?php echo $cfg->wwwRoot;?>/src">Inicio</a></li>
		<li <?php if ($selected == 'login') { ?>class="active"<?php $referer = 'index.php'; } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/login/login.php">Iniciar Sesi&oacute;n</a></li>
		<li <?php if ($selected == 'registro') { ?>class="active"<?php $referer = 'index.php'; } ?>><a href="<?php echo $cfg->wwwRoot;?>/src/registro/registro.php">Registrate</a></li>
	<?php }?>
	</ul>
</nav>
<?php
if (isset($_SESSION)) {
	$_SESSION['referer'] = $referer;
}
showMessage()
?>
