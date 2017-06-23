<div class="modal fade" id="favorPostulationsWindow" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document"> 
    	<div class="modal-content"> 
        	<div class="modal-header">
            	<h2 class="modal-title">Listado de Postulaciones</h2>
   			</div>
			<table class="table table-hover favorSearch">
				<tr>
					<th>
						Usuario
					</th>
				</tr>
				<?php foreach ($favor->getMyPostulations() as $postulation) { ?>
				<tr>
					<td>
						<?php $userPost = $postulation->getUser();
						echo $userPost->getName().' '.$userPost->getLastname();
						?>
					</td>
				</tr>
				<?php } ?>
			</table>
			<div class="modal-footer">
           		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          	</div>
		</div>
	</div>
</div>