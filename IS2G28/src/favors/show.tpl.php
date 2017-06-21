<!DOCTYPE html>
<html>
<head>
  <title>Una Gauchada - Vista de un favor</title>
  <?php require '../common/common_headers.php'; ?> 
  <link type="text/css" rel="stylesheet" href="show.css">
</head>
<body>
  <div class="container">
    <div id=header>
      <img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
    </div>
    <?php include('../common/menu.php'); ?>
    <div class="panel panel-default favor">
      <div class="panel-heading">
        <h3 class="panel-title">Ver una gauchada</h3>        
      </div>
      <div class="panel-body">        
        <div class="media favor">          
          <?php if ($favor): ?>
          <div class="media-left">
            <a href="#">
              <?php if ($favor->getPhoto()): ?>
                <img class="media-object img-rounded favor-photo" 
                     src="../uploads/<?php echo $favor->getPhoto() ?>" 
                     alt="<?php echo $favor->getTitle() ?>">
              <?php else: ?>
                <img class="media-object img-rounded favor-photo" 
                     src="../images/logo-gauchada.png" 
                     alt="Imagen de favor">
              <?php endif; ?>
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading favor-title"><?php echo $favor->getTitle() ?></h4>
            <p class="favor-description"><?php echo $favor->getDescription() ?></p>      
            <ul class="list-inline favor-properties">
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                  <?php echo $favor->getCity() ?>
                </span>            
              </li>
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                  <?php echo $favor->getDeadline()->format('d/m/Y') ?>
                </span>            
              </li>
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                  <?php echo $favor->getOwner() ?>
                </span>            
              </li>
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                  0 comentarios
                </span>            
              </li>
              <li>
                <span class="label label-warning">
                  <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>
                  0 postulaciones
                </span>            
              </li> 
              <li>
              	<a role="button" href="../postulations/savePostulation.php?id=<?php echo $favor->getId();?>"	class="btn btn-warning btn-block; glyphicon glyphicon-ok"> 
              		<strong>Postularme</strong> 
              	</a>
			  </li>          
            </ul>
          </div>
          <?php else: ?>
            <p>No existe la gauchada especificada.</p>
          <?php endif; ?>
        </div><!-- End .media.favor -->
        <br>
        <a class="btn btn-default pull-right" href="list.php">Volver al listado</a>
      </div><!-- End .panel-body -->
      
    </div>
    
  </div>
  
    
</body>
</html>
