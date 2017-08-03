<!DOCTYPE html>
  <html>
  <head>
    <title>Una Gauchada - Reputaciones</title>
    <?php require '../common/common_headers.php' ; ?>
    <link href="list.css" rel="stylesheet" />    
  </head>
  <body>
  <!-- Contenedor principal, requerido por Bootstrap -->	
  <div class="container">
    <div id=header>
      <img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
    </div>
    <?php include('../common/menu.php'); ?>
    <div class="jumbotron">
      <div class="panel panel-default index">
      <!-- Titulo de la seccion -->
        <div class="panel-heading">
          <a class="btn btn-primary pull-right" href="new.php" style="line-height: 1">
            <span class="glyphicon glyphicon-plus-sign"></span> Nueva Reputaci&oacute;n
          </a>
          <h3 class="panel-title">Listado de reputaciones</h3>            	          			
        </div>
        <div class="panel-body">
          <?php if(count($reputations) > 0): ?>
            <div class="table-responsive">
              <table class="table table-hover reputations">
                <tr>
                  <th class="reputation-image">Imagen</th>
                  <th class="reputation-name">Nombre</th>
                  <th class="reputation-min-score">Puntaje min.</th>
                  <th class="actions">Acciones</th>
                </tr>
                <?php foreach ($reputations as $reputation): ?>
                  <tr>
                    <td class="reputation-image">
                      <img src="../uploads/<?= $reputation->getImage() ?>" 
                           alt="<?= $reputation->getName() ?>" class="img-circle">
                    </td>
                    <td class="reputation-name"><?= $reputation->getName() ?></td>
                    <td class="reputation-min-score"><?= $reputation->getMinScore() ?></td>
                    <td class="actions">
                      <a class="btn btn-warning btn-sm <?= $reputation->isDefault()?'disabled':'' ?>" href="edit.php?id=<?= $reputation->getId() ?>">
                        <span class="glyphicon glyphicon-pencil"></span> Editar
                      </a>
                      <a class="btn-delete btn btn-danger btn-sm <?= $reputation->isDefault()?'disabled':'' ?>" href="delete.php?id=<?= $reputation->getId() ?>">
                        <span class="glyphicon glyphicon-trash"></span> Borrar
                      </a>
                    </td>
                  </tr>                    
                <?php endforeach; ?>	                                      
              </table>
            </div>
          <?php else: ?>
            <p style="font-size: 16px;">No se encontraron reputaciones.</p>
          <?php endif;?>
        </div>        
      </div>
    </div>
    </div>
    <script type="text/javascript"> 
      $('.btn-delete').confirmation({
        title: 'Esta seguro de borrar la reputación seleccionada?',
        placement: 'right',
        btnOkLabel:'Si',
        btnCancelLabel:'No',
        btnOkClass:'btn btn-sm btn-danger btn-xs',
        btnCancelClass:'btn btn-sm btn-success btn-xs'        
      });
      
    </script>
  </body>    
</html>