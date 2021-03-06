<div class="modal fade" id="qualificationO_modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" data-backdrop="static"> 
	<div class="modal-dialog" role="document"> 
    <div class="modal-content"> 
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
          <h3 class="modal-title">Calificar due&ntilde;o de la gauchada</h3>
      </div>
      <form method="post" action="../qualifications/qualifyOwner.php">
        <div class="modal-body">
          <input type="hidden" id="qualification_favor_id" name="qualification[favor_id]" value="<?= $favor->getid() ?>">
          <div class="form-group">
            <label for="qualification_result" class="control-label">Calificación:</label>
            <div>
              <label class="radio-inline">
                <input type="radio" name="qualification[result]" id="qualification_result_postitive" value="1"> Positiva
              </label>
              <label class="radio-inline">
                <input type="radio" name="qualification[result]" id="qualification_result_neutral" value="0" checked="checked"> Neutral
              </label>
              <label class="radio-inline">
                <input type="radio" name="qualification[result]" id="qualification_result_negative" value="-2"> Negativa
              </label>
            </div>            
          </div>
          <div class="form-group">
            <label for="qualification_comment" class="control-label">Comentario:</label>
            <textarea class="form-control" id="qualification_comment" name="qualification[comment]" placeholder="Deje su comentario ..." required></textarea>            
          </div>                    
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Calificar</button>
        </div>
      </form>
		</div>
	</div>
</div>