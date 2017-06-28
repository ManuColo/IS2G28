<div class="modal fade" id="favorPostulationsWindow" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document"> 
    	<div class="modal-content"> 
        	<div class="modal-header">
            	<h2 class="modal-title">Postulantes a <?php echo $favor->getTitle();?></h2>
   			</div>
			<table class="table table-hover favorSearch">
				<tr>
					<th>
						Usuario
					</th>
					<th>
						Comentario
					</th>
					<th>
						Reputaci&oacute;n
					</th>
					<th>
						Estado
					</th>
				</tr>
				<?php foreach ($favor->getMyPostulations() as $postulation) { ?>
				<tr>
					<td>
						<?php $userPost = $postulation->getUser();
						echo $userPost->getName().' '.$userPost->getLastname();
						?>
					</td>
					<td>
						<?php echo $postulation->getComment(); ?>
					</td>
					<td>
						<?php echo $userPost->printReputation(); ?>
					</td>
					<td>
						<?php if ($favor->getResolved()){ ?>
						<?php echo $postulation->getStatus();?>
						<?php } else {?>
						<button class="btn btn-success btn-sm choose" id="<?php echo $postulation->getUser()->getId(); ?>">Seleccionar</button>
						<?php }?>
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