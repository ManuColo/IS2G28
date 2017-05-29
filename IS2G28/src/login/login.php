<!DOCTYPE html>
<html>
  <head>
    <title>Una Gauchada - Acceso de usuarios</title>
    <?php require '../common/common_headers.php' ;?>         
  </head>
  <body>
    <!-- Contenedor principal, requerido por Bootstrap -->
    <div class="container">    
      <div class="panel panel-default login">
        <div class="panel-heading">
          <!-- Titulo de la seccion -->
          <h3 class="panel-title">Acceso de usuarios</h3>
        </div>
        <div class="panel-body">
          <!-- Formulario de alta de login -->
          <form class="form-horizontal">
              <!-- Titulo del favor -->
              <div class="form-group">
                  <label for="user" class="col-sm-2 control-label">Usuario</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="user" />
                  </div>
              </div>
              <!-- Descripcion del favor -->
              <div class="form-group">
                  <label for="pass" class="col-sm-2 control-label">Clave</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="pass" />
                  </div>
              </div>
              

              <!-- Botones del formulario -->
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">                                  
                  <input type="submit" class="btn btn-primary" value="Ingresar">
                </div>
              </div>              
          </form>
        </div>                                
      </div>
    </div>        
  </body>    
</html>