<!DOCTYPE html>
<html>
  <head>
    <title>Una Gauchada - Alta de favor</title>
    <?php require '../common/common_stylesheets.html' ;?>
    <link type="text/css" rel="stylesheet" href="new.css">
    <?php require '../common/common_javascripts.html' ;?>        
  </head>
  <body>
    <!-- Contenedor principal, requerido por Bootstrap -->
    <div class="container">    
      <div class="panel panel-default favor-new">
        <div class="panel-heading">
          <!-- Titulo de la seccion -->
          <h3 class="panel-title">Nuevo favor</h3>
        </div>
        <div class="panel-body">
          <!-- Formulario de alta de favor -->
          <form class="form-horizontal">
              <!-- Titulo del favor -->
              <div class="form-group">
                  <label for="favor_title" class="col-sm-2 control-label">T&iacute;tulo</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="favor_title">
                  </div>
              </div>
              <!-- Descripcion del favor -->
              <div class="form-group">
                  <label for="favor_description" class="col-sm-2 control-label">Descripci&oacute;n</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="favor_description" rows="3"></textarea>
                  </div>
              </div>
              <!-- Foto del favor -->
              <div class="form-group">
                  <label for="favor_photo" class="col-sm-2 control-label">Foto</label>
                  <div class="col-sm-10">
                    <input type="file" id="favor_photo">
                  </div>
              </div>
              <!-- Ciudad donde se debe realizar favor -->
              <div class="form-group">
                  <label for="favor_city" class="col-sm-2 control-label">Ciudad</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="favor_city">
                  </div>
              </div>
              <!-- Fecha limite del favor -->
              <div class="form-group">
                  <label for="favor_deadline" class="col-sm-2 control-label">Fecha l&iacute;mite</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" id="favor_deadline">
                  </div>
              </div>

              <!-- Botones del formulario -->
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">                                  
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
