<!DOCTYPE html>
<html>
  <head>
    <title>Una Gauchada - Edici&oacute;n de favor</title>
    <?php require '../common/common_headers.php'; ?>    
    <link type="text/css" rel="stylesheet" href="new.css">    
  </head>
  <body>
    <!-- Contenedor principal, requerido por Bootstrap -->
    <div class="container-fluid">
      <div id=header>
        <img class="img-responsive" src="<?php echo $cfg->wwwRoot;?>/src/images/header-gauchada.png"/>
      </div>
      <?php include('../common/menu.php'); ?>
      
      <div class="panel panel-default favor-new">
        <div class="panel-heading">
          <!-- Titulo de la seccion -->
          <h3 class="panel-title">Edici&oacute;n de gauchada</h3>
        </div>
        <div class="panel-body">
          <!-- Formulario de alta de favor -->
          <form id="favor-form" class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
              <!-- Titulo del favor -->
              <div class="form-group <?php echo isset($errors['title'])?'has-error':'' ?>">
                  <label for="favor_title" class="col-sm-3 control-label">T&iacute;tulo</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="favor_title" name="favor[title]" 
                           placeholder="Que favor necesita?" value="<?php echo $favor->getTitle() ?>">
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block <?php echo isset($errors['title'])?'shown':'hidden' ?>">
                      <?php echo isset($errors['title'])?$errors['title']:'' ?>
                    </span>                    
                  </div>
              </div>
              <!-- Descripcion del favor -->
              <div class="form-group <?php echo isset($errors['description'])?'has-error':'' ?>">
                  <label for="favor_description" class="col-sm-3 control-label">Descripci&oacute;n</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="favor_description" name="favor[description]" rows="3" 
                              placeholder="Cuentenos un poco mas acerca del favor ..."><?php echo $favor->getDescription() ?></textarea>
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block <?php echo isset($errors['description'])?'shown':'hidden' ?>">
                      <?php echo isset($errors['description'])?$errors['description']:'' ?>
                    </span>
                  </div>
              </div>
              <!-- Foto del favor -->
              <div class="form-group <?php echo isset($errors['photo'])?'has-error':'' ?>">
                  <label for="favor_photo" class="col-sm-3 control-label">Foto</label>
                  <div class="col-sm-9"> El tamaño m&aacute;ximo de la imagen es 1024 kB
                    <input type="file" id="favor_photo" name="favor_photo">
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block <?php echo isset($errors['photo'])?'shown':'hidden' ?>">
                      <?php echo isset($errors['photo'])?$errors['photo']:'' ?>
                    </span>                    
                  </div>
              </div>
              <!-- Ciudad donde se debe realizar favor -->
              <div class="form-group <?php echo isset($errors['city'])?'has-error':'' ?>">
                  <label for="favor_city" class="col-sm-3 control-label">Ciudad</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="favor_city" name="favor[city]"
                           placeholder="Ciudad donde se debe realizar el favor" 
                           value="<?php echo $favor->getCity() ?>">
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block <?php echo isset($errors['city'])?'shown':'hidden' ?>">
                      <?php echo isset($errors['city'])?$errors['city']:'' ?>
                    </span>
                  </div>
              </div>
              <!-- Fecha limite del favor -->
              <div class="form-group <?php echo isset($errors['deadline'])?'has-error':'' ?>">
                  <label for="favor_deadline" class="col-sm-3 control-label">Fecha l&iacute;mite</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="favor_deadline" name="favor[deadline]" 
                           value="<?php echo (is_string($favor->getDeadline()))?$favor->getDeadline():$favor->getDeadline()->format('d/m/Y')?>"
                           data-provide="datepicker" data-date-format="dd/mm/yyyy" 
                           data-date-autoclose="true" placeholder="Hasta cuando se puede realizar el favor? (dd/mm/yyyy)" >
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block <?php echo isset($errors['deadline'])?'shown':'hidden' ?>">
                      <?php echo isset($errors['deadline'])?$errors['deadline']:'' ?>
                    </span>                    
                  </div>
              </div>

              <!-- Botones del formulario -->
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">                                  
                  <input type="submit" id="submit-favor" class="btn btn-primary" value="Guardar">
                  <a class="btn btn-default" href="list.php" role="button">Cancelar</a>
                </div>
              </div>              
          </form>
        </div>                                
      </div>
    </div>    
  </body>    
</html>