<!DOCTYPE html>
<html>
  <head>
    <title>Una Gauchada - Alta de reputaci&oacute;n</title>
    <?php require '../common/common_headers.php'; ?>
    <style type="text/css">
      /* Estilos aplicados al panel que contiene el nuevo favor */
      .reputation.panel {
        margin: 20px auto 0px;  
      }

      @media (min-width: 768px) {
        .reputation.panel {
          width: 65%;  
        }  
      } 
      
      .reputation.panel h3 {
        font-weight: bold;
        text-align: center;
        font-variant: small-caps;
      }

      
    </style>
  </head>
  <body>
    <!-- Contenedor principal, requerido por Bootstrap -->
    <div class="container-fluid">
      <!-- Encabezado de la página -->
      <div id="header">
        <img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
      </div>
      <!-- Menu de la pagina -->
      <?php include('../common/menu.php'); ?>
      <!-- Contenido principal de la página -->
      <div class="panel panel-default reputation">
        <div class="panel-heading">
          <!-- Titulo de la seccion -->
          <h3 class="panel-title">Nueva reputaci&oacute;n</h3>
        </div>
        <div class="panel-body">
          <!-- Formulario de alta de una reputacion -->
          <form id="reputation-form" class="form-horizontal" action="create.php" method="post" enctype="multipart/form-data" >                           
            <!-- Nombre de la reputación -->
            <div class="form-group <?php echo isset($errors['name'])?'has-error':'' ?>">
              <label for="reputation_name" class="col-sm-3 control-label">Nombre</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="reputation_name" name="reputation[name]" 
                       placeholder="Nombre de la reputación" value="<?php echo $reputation->getName() ?>">
                <!-- Contenedor del mensaje de error -->
                <span class="error help-block <?php echo isset($errors['name'])?'shown':'hidden' ?>">
                  <?php echo isset($errors['name'])?$errors['name']:'' ?>
                </span>                 
              </div>
            </div>
            <!-- Imagen de la reputación -->
            <div class="form-group <?php echo isset($errors['image'])?'has-error':'' ?>">
              <label for="reputation_image" class="col-sm-3 control-label">Imagen</label>
              <div class="col-sm-9">
                <input type="file" id="reputation_image" name="reputation_image">
                <p class="help-block">El tamaño m&aacute;ximo de la imagen es 1024 kB.</p>
                <!-- Contenedor del mensaje de error -->
                <span class="error help-block <?php echo isset($errors['image'])?'shown':'hidden' ?>">
                  <?php echo isset($errors['image'])?$errors['image']:'' ?>
                </span>
              </div>
            </div>
            <!-- Puntaje minimo de la reputacion -->
            <div class="form-group <?php echo isset($errors['minScore'])?'has-error':'' ?>">
              <label for="reputation_min_score" class="control-label col-sm-3">Puntaje m&iacute;nimo</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="reputation_min_score" name="reputation[minScore]"
                      placeholder="Puntaje minimo de la reputacion" value="<?= $reputation->getMinScore() ?>" />
                <!-- Contenedor del mensaje de error -->
                <span class="error help-block <?php echo isset($errors['minScore'])?'shown':'hidden' ?>">
                  <?php echo isset($errors['minScore'])?$errors['minScore']:'' ?>
                </span>
              </div>
            </div>
            
            <!-- Botones del formulario -->
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">                                  
                <input type="submit" id="submit" class="btn btn-primary" value="Guardar">
                <a class="btn btn-default" href="" role="button">Cancelar</a>
              </div>
            </div> 
            
          </form>
        </div>        
      </div>          
    </div>    
  </body>    
</html>