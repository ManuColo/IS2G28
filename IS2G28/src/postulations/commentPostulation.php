<?php
require '../common/common_headers.php';
?>
<a role="button" class="btn btn-warning btn-block; glyphicon glyphicon-ok" data-toggle="modal" href="#ventanaCP"> 
   <strong>Postularme</strong> 
</a>
<div class="modal fade" id="ventanaCP" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true"> 
	<div class="modal-dialog" role="document"> 
    	<div class="modal-content"> 
        	<div class="modal-header">
            	<h2 class="modal-title">Comentar Postulaci&oacute;n</h2>
   			</div>
   			<form method="post" action="../postulations/savePostulation.php?id=<?php echo $favor->getId();?>">
  			<div class="modal-body">
				<div class="form-group">
                	<label for="comment">Comentario</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="Dej&aacute; un comentario con tu postulaci&oacute;n"></textarea>
                </div>		
           	</div>
           	<div class="modal-footer">
           		<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
           		<button type="submit" class="btn btn-warning">Guardar</button>
          	</div>
          	</form>
		</div>
	</div>
</div>
