<!DOCTYPE html>
<html>
<head>
  <title>Una Gauchada - Vista de un favor</title>
  <?php require '../common/common_headers.php'; ?>
  <script type="text/javascript" src="../js/show.js"></script> 
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
              <?php endif; 
              $owner = $favor->getOwner();?>
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading favor-title">
            <?php if (!$favor->getUnpublished()&& !$favor->getResolved()) {
	            echo $favor->getTitle();
	            if ($owner === $user) {
	            	?>
	            	<button class="btn btn-danger btn-xs pull-right" id="unpublish">Despublicar</button>
	            <?php }
            	} elseif ($favor->getResolved()) { ?>
					<?php echo $favor->getTitle();?>
	            	<span class="label label-success pull-right">Gauchada resuelta</span>
            <?php } else { ?>
					<del><?php echo $favor->getTitle();?></del>
	            	<span class="text text-danger">Gauchada despublicada</span>
            <?php }?>
            </h4>
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
                  <a href="../profile/public.php?idUs=<?php echo $owner->getId(); ?>" class="text-white"><?php echo $owner ?></a>
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
                  <?php $postulations = $favor->getMyPostulations();
                  $cantPostulations = $postulations->count();
                  if ($cantPostulations < 1 ) { ?>
					0 postulaciones
                  <?php } elseif ($owner === $user) {?>
					<a role="button" data-toggle="modal" href="#favorPostulationsWindow" class="text-white">
	                  	<?php echo $cantPostulations; 
	                  	if ( $cantPostulations > 1 ) {?> postulaciones 
                  		<?php } else { ?> postulaci&oacute;n 
                  		<?php } ?>
                  	</a>
                  <?php } else { ?>
	                  	<?php echo $cantPostulations; 
	                  	if ( $cantPostulations > 1 ) {?> postulaciones 
                  		<?php } else { ?> postulaci&oacute;n 
                  		<?php } ?>
                  <?php } ?>
                </span>            
              </li>        
            </ul>
            <div><?php 
            	$imPostulated = false; 
            	foreach ($postulations as $postulation) {
            		if ($postulation->getUser() === $user) {
            			$imPostulated = True;
            			$myPostulation = $postulation;
            		}
            	};
            	if ($owner !== $user) {
            		if (!$imPostulated) {
              			include '../postulations/commentPostulation.php';
            		} else { ?>
            			<span class="text bg-info pull-right">
            				Mi postulación está: <?php echo $myPostulation->getStatus();?>
            			</span>
            		<?php }
            	} ?>
			</div> 
          </div>
          <?php if ($owner === $user) {
          			include '../postulations/favorPostulations.php'; 
          		};?>
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
