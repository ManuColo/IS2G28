<a role="button" id="btnMod" class="btn btn-warning" data-toggle="modal" href="#ventanaCP"> 
   <strong>Quiero postularme</strong> 
</a>
<div class="modal fade" id="ventanaCP" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" data-backdrop="static"> 
	<div class="modal-dialog" role="document"> 
    	<div class="modal-content"> 
        	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">×</button>
            	<h3 class="modal-title">Comentar Postulaci&oacute;n</h3>
   			</div>
   			<form method="post" action="../postulations/savePostulation.php?id=<?php echo $favor->getId();?>">
  			<div class="modal-body">
				<div class="form-group">
                	<textarea class="form-control" id="comment" name="comment" placeholder="Antes de postularte, pod&eacute;s dejar un comentario"></textarea>
                </div>		
           	</div>
           	<div class="modal-footer">
           		<button type="submit" class="btn btn-warning"><strong>Postularme</strong></button>
          	</div>
          	</form>
		</div>
	</div>
</div>
