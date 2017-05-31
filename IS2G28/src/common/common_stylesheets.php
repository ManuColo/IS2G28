<?php
$path = substr(__DIR__,0,-10);
require_once $path.'config/config.php';
?>
<!-- Hojas de estilos requeridas por varias paginas del proyeto -->
<link type="text/css" rel="stylesheet" href="<?php echo $cfg->wwwRoot?>/node_modules/bootstrap/dist/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="<?php echo $cfg->wwwRoot?>/node_modules/bootstrap/dist/css/bootstrap-theme.css">
<link type="text/css" rel="stylesheet" href="<?php echo $cfg->wwwRoot?>/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css">
