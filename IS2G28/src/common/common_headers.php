<?php
$path = substr(__DIR__,0,-10);
require_once $path.'config/config.php';
require($cfg->dataRoot.'/src/common/common_stylesheets.php');?>
<link type="text/css" rel="stylesheet" href="<?php echo $cfg->wwwRoot?>/src/css/style.css">
<?php require $cfg->dataRoot.'/src/common/common_javascripts.php';?>