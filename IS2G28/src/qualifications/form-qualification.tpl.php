<div class="modal fade" id="qualification_modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" data-backdrop="static"> 
	<div class="modal-dialog" role="document"> 
    <div class="modal-content"> 
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
          <h3 class="modal-title">Calificar postulante aceptado</h3>
      </div>
      <form method="post" action="">
        <div class="modal-body">
          <div class="form-group">
            <label for="qualification_result" class="control-label">Calificación:</label>
            <div>
              <label class="radio-inline">
                <input type="radio" name="qualification[result]" id="qualification_result_postitive" value="1"> Positiva
              </label>
              <label class="radio-inline">
                <input type="radio" name="qualification[result]" id="qualification_result_neutral" value="0"> Neutral
              </label>
              <label class="radio-inline">
                <input type="radio" name="qualification[result]" id="qualification_result_negative" value="-2"> Negativa
              </label>
            </div>            
          </div>
          <div class="form-group">
            <label for="qualification_comment" class="control-label">Comentario:</label>
            <textarea class="form-control" id="qualification_comment" name="qualification[comment]" placeholder="Deje su comentario ..."></textarea>            
          </div>                    
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Calificar</button>
        </div>
      </form>
		</div>
	</div>
</div>
