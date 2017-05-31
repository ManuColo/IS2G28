<!DOCTYPE html>
<html>
  <head>
    <title>Una Gauchada - Alta de favor</title>
    <?php require '../common/common_headers.php'; ?>    
    <link type="text/css" rel="stylesheet" href="new.css">
    <script type="text/javascript" src="new.js"></script>    
  </head>
  <body>
    <!-- Contenedor principal, requerido por Bootstrap -->
    <div class="container-fluid">    
      <div class="panel panel-default favor-new">
        <div class="panel-heading">
          <!-- Titulo de la seccion -->
          <h3 class="panel-title">Nuevo favor</h3>
        </div>
        <div class="panel-body">
          <!-- Formulario de alta de favor -->
          <form id="favor-form" action="create.php" method="post" class="form-horizontal">
              <!-- Titulo del favor -->
              <div class="form-group">
                  <label for="favor_title" class="col-sm-3 control-label">T&iacute;tulo</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="favor_title" name="favor[title]" 
                           placeholder="Que favor necesita?">
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block hidden"></span>
                  </div>
              </div>
              <!-- Descripcion del favor -->
              <div class="form-group">
                  <label for="favor_description" class="col-sm-3 control-label">Descripci&oacute;n</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="favor_description" name="favor[description]" rows="3" 
                              placeholder="Cuentenos un poco mas acerca del favor ..."></textarea>
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block hidden"></span>
                  </div>
              </div>
              <!-- Foto del favor -->
              <div class="form-group">
                  <label for="favor_photo" class="col-sm-3 control-label">Foto</label>
                  <div class="col-sm-9">
                    <input type="file" id="favor_photo" name="favor[photo]">
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block hidden"></span>
                  </div>
              </div>
              <!-- Ciudad donde se debe realizar favor -->
              <div class="form-group">
                  <label for="favor_city" class="col-sm-3 control-label">Ciudad</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="favor_city" name="favor[city]"
                           placeholder="Ciudad donde se debe realizar el favor">
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block hidden"></span>
                  </div>
              </div>
              <!-- Fecha limite del favor -->
              <div class="form-group">
                  <label for="favor_deadline" class="col-sm-3 control-label">Fecha l&iacute;mite</label>
                  <div class="col-sm-9">
                    <input type="date" class="form-control" id="favor_deadline" name="favor[deadline]" 
                           data-provide="datepicker" data-date-format="dd/mm/yyyy" 
                           data-date-autoclose="true" placeholder="Hasta cuando se puede realizar el favor? (dd/mm/yyyy)">
                    <!-- Contenedor del mensaje de error -->
                    <span class="error help-block hidden"></span>
                  </div>
              </div>

              <!-- Botones del formulario -->
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">                                  
                  <input type="submit" class="btn btn-primary" value="Guardar">
                  <input type="button" class="btn btn-default" value="Cancelar">
                </div>
              </div>              
          </form>
        </div>                                
      </div>
    </div>    
  </body>    
</html>
