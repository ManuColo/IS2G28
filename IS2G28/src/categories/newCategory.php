<?php
session_start();
require_once __DIR__.'/../../config/doctrine_config.php';
$user= $entityManager->find('User',$_SESSION['userId']);
if ($_SESSION['logged']) {
	if ($user->getIsAdmin()) {
	?>
<!DOCTYPE html>
<html>
  <head>
    <title>Una Gauchada - Alta de categor&iacute;a</title>
    <?php require '../common/common_headers.php'; ?>    
    <link type="text/css" rel="stylesheet" href="new.css">
    <script type="text/javascript"></script>    
  </head>
  <body>
    <!-- Contenedor principal, requerido por Bootstrap -->
    <div class="container-fluid">
      <div id=header>
        <img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
      </div>
      <?php include('../common/menu.php'); 
      require '../../config/doctrine_config.php';?>
      <div class="panel panel-default category-new">
        <div class="panel-heading">
          <!-- Titulo de la seccion -->
          <h3 class="panel-title">Nueva categor&iacute;a</h3>
        </div>
        <div class="panel-body">
          <!-- Formulario de alta de favor -->
          <form id="category-form" class="form-horizontal" action="createCategory.php" method="post">
              <!-- Nueva categoria -->
            <div class="form-group category">
			  <label for="category" class="col-sm-2 control-label">Nombre</label>
              	<div class="col-sm-10">
					<input type="text" class="form-control" id="category" name="category" <?php if (isset($_POST['category'])){?>value="<?php echo $_POST['category']; ?>"<?php }?> placeholder="No debe existir una categor&iacute;a con este nombre" required />
                </div>
            </div>
              <!-- Botones del formulario -->
              <div class="form-group" id="btnCategory">
                <div class="col-sm-9 col-sm-offset-3">                                  
                  <input type="submit" id="submit-category" class="btn btn-primary" value="Guardar" <?php echo $user->getIsAdmin()?'':'disabled' ?>>
                  <a class="btn btn-default" href="list.php" role="button">Cancelar</a>
                </div>
              </div>              
          </form>
        </div>                                
      </div>
    </div>    
  </body>    
</html>
	<?php } else {
		addMessage('danger','Ten&eacute;s que ser administrador para acceder');
		header("location:../favors/list.php");
	}
}  else {
	header("location:../login/login.php?message=accessDenied");
}?>
